<?php

namespace App\Http\Controllers;

use App\Tender;
use App\Language;
use App\Helpers\SanitizeInput;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenderController extends Controller
{
    const UPLOAD_DIR = 'assets/uploads/tenders';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_tenders = Tender::orderBy('notice_date', 'desc')->get()->groupBy('lang');
        return view('backend.pages.tender.index')->with([
            'all_tenders' => $all_tenders,
        ]);
    }

    public function new_tender()
    {
        $all_languages = Language::all();
        return view('backend.pages.tender.new')->with([
            'all_languages' => $all_languages,
        ]);
    }

    public function store_tender(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:500',
            'notice_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'status'      => 'required',
            'lang'        => 'required',
            'file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:20480',
        ]);

        $filename = $this->handleFileUpload($request);

        $slug = Str::slug(Str::limit($request->title, 80) . '-' . $request->notice_date);
        if (Tender::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        Tender::create([
            'title'       => SanitizeInput::esc_html($request->title),
            'slug'        => $slug,
            'description' => $request->description,
            'file'        => $filename,
            'notice_date' => $request->notice_date,
            'expiry_date' => $request->expiry_date ?: null,
            'status'      => $request->status,
            'lang'        => $request->lang,
        ]);

        return redirect()->route('admin.tender.all')
            ->with(['msg' => __('Tender created successfully'), 'type' => 'success']);
    }

    public function edit_tender($id)
    {
        $tender = Tender::findOrFail($id);
        $all_languages = Language::all();
        return view('backend.pages.tender.edit')->with([
            'tender'        => $tender,
            'all_languages' => $all_languages,
        ]);
    }

    public function update_tender(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:500',
            'notice_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'status'      => 'required',
            'file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:20480',
        ]);

        $tender   = Tender::findOrFail($id);
        $filename = $this->handleFileUpload($request, $tender->file);

        $tender->update([
            'title'       => SanitizeInput::esc_html($request->title),
            'description' => $request->description,
            'file'        => $filename,
            'notice_date' => $request->notice_date,
            'expiry_date' => $request->expiry_date ?: null,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.tender.all')
            ->with(['msg' => __('Tender updated successfully'), 'type' => 'success']);
    }

    public function delete_tender(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);
        $this->deleteFile($tender->file);
        $tender->delete();

        return redirect()->route('admin.tender.all')
            ->with(['msg' => __('Tender deleted'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        $ids = $request->ids ?? [];
        if ($request->action === 'delete') {
            foreach (Tender::whereIn('id', $ids)->get() as $tender) {
                $this->deleteFile($tender->file);
                $tender->delete();
            }
        }
        return redirect()->back()->with(['msg' => __('Bulk action applied'), 'type' => 'success']);
    }

    public function page_settings()
    {
        return view('backend.pages.tender.settings');
    }

    public function update_page_settings(Request $request)
    {
        foreach (['tender_page_slug', 'tender_page_title', 'tender_page_meta_description', 'tender_page_meta_tags'] as $field) {
            if ($request->has($field)) {
                update_static_option($field, $request->$field);
            }
        }
        return redirect()->back()->with(['msg' => __('Tender page settings updated'), 'type' => 'success']);
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function handleFileUpload(Request $request, $existing = null)
    {
        if (!$request->hasFile('file')) {
            return $existing;
        }

        $this->deleteFile($existing);

        $dir = public_path(self::UPLOAD_DIR);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $file     = $request->file('file');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return $filename;
    }

    private function deleteFile($filename)
    {
        if ($filename) {
            $path = public_path(self::UPLOAD_DIR . '/' . $filename);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
