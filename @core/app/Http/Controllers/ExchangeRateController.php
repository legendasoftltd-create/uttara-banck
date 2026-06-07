<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExchangeRateController extends Controller
{
    private const BASE_PATH = 'backend.pages.exchange-rate.';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_exchange_rates = ExchangeRate::orderBy('id', 'desc')->paginate(10);
        return view(self::BASE_PATH . 'index')->with(['all_exchange_rates' => $all_exchange_rates]);
    }

    public function create()
    {
        return view(self::BASE_PATH . 'new');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'currency_name' => 'required|array',
            'currency_name.*' => 'required|string|max:191',
            'buying' => 'required|array',
            'buying.*' => 'required|numeric',
            'selling' => 'required|array',
            'selling.*' => 'required|numeric',
            'date' => 'nullable|array',
            'date.*' => 'nullable|date',
            'pdf' => 'nullable|file|mimes:pdf|max:102400',
        ]);

        $upload_dir = 'assets/uploads/exchange-rates';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $pdf_filename = null;
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $pdf_filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move($upload_dir, $pdf_filename);
        }

        $items = [];
        foreach ($request->currency_name as $index => $currency_name) {
            $items[] = [
                'date' => $request->date[$index] ?? null,
                'currency_name' => $currency_name,
                'buying' => $request->buying[$index] ?? 0,
                'selling' => $request->selling[$index] ?? 0,
            ];
        }

        ExchangeRate::create([
            'items' => $items,
            'pdf' => $pdf_filename,
            'status' => 1,
        ]);

        return redirect()->route('admin.exchange.rate.all')->with([
            'msg' => __('New exchange rates added successfully.'),
            'type' => 'success',
        ]);
    }

    public function edit($id)
    {
        $exchange_rate = ExchangeRate::findOrFail($id);
        return view(self::BASE_PATH . 'edit')->with(['exchange_rate' => $exchange_rate]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'currency_name' => 'required|array',
            'currency_name.*' => 'required|string|max:191',
            'buying' => 'required|array',
            'buying.*' => 'required|numeric',
            'selling' => 'required|array',
            'selling.*' => 'required|numeric',
            'date' => 'nullable|array',
            'date.*' => 'nullable|date',
            'pdf' => 'nullable|file|mimes:pdf|max:102400',
        ]);

        $exchange_rate = ExchangeRate::findOrFail($id);

        $items = [];
        foreach ($request->currency_name as $index => $currency_name) {
            $items[] = [
                'date' => $request->date[$index] ?? null,
                'currency_name' => $currency_name,
                'buying' => $request->buying[$index] ?? 0,
                'selling' => $request->selling[$index] ?? 0,
            ];
        }

        $data = [
            'items' => $items,
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('pdf')) {
            $upload_dir = 'assets/uploads/exchange-rates';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if ($exchange_rate->pdf && file_exists($upload_dir . '/' . $exchange_rate->pdf)) {
                unlink($upload_dir . '/' . $exchange_rate->pdf);
            }

            $file = $request->file('pdf');
            $pdf_filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move($upload_dir, $pdf_filename);
            $data['pdf'] = $pdf_filename;
        }

        $exchange_rate->update($data);

        return redirect()->back()->with([
            'msg' => __('Exchange rate updated successfully.'),
            'type' => 'success',
        ]);
    }

    public function delete($id)
    {
        $exchange_rate = ExchangeRate::findOrFail($id);

        if ($exchange_rate->pdf) {
            $pdf_path = 'assets/uploads/exchange-rates/' . $exchange_rate->pdf;
            if (file_exists($pdf_path)) {
                unlink($pdf_path);
            }
        }

        $exchange_rate->delete();

        return redirect()->back()->with([
            'msg' => __('Exchange rate deleted successfully.'),
            'type' => 'danger',
        ]);
    }

    public function bulk_action(Request $request)
    {
        $exchange_rates = ExchangeRate::whereIn('id', $request->ids ?? [])->get();

        foreach ($exchange_rates as $rate) {
            if ($rate->pdf) {
                $pdf_path = 'assets/uploads/exchange-rates/' . $rate->pdf;
                if (file_exists($pdf_path)) {
                    unlink($pdf_path);
                }
            }
        }

        ExchangeRate::whereIn('id', $request->ids ?? [])->delete();

        return response()->json(['status' => 'ok']);
    }
}
