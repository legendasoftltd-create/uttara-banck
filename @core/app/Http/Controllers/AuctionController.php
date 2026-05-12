<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Language;
use App\Helpers\SanitizeInput;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuctionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_auctions = Auction::orderBy('notice_date', 'desc')->get()->groupBy('lang');
        return view('backend.pages.auction.index')->with([
            'all_auctions' => $all_auctions,
        ]);
    }

    public function new_auction()
    {
        $all_languages = Language::all();
        return view('backend.pages.auction.new')->with([
            'all_languages' => $all_languages,
        ]);
    }

    public function store_auction(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:255',
            'notice_date' => 'required|date',
            'expiry_date' => 'required|date',
            'status'      => 'required',
            'lang'        => 'required',
        ]);

        $slug = Str::slug($request->title . '-' . $request->notice_date);
        if (Auction::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        Auction::create([
            'title'       => SanitizeInput::esc_html($request->title),
            'slug'        => $slug,
            'description' => $request->description,
            'image'       => $request->image,
            'notice_date' => $request->notice_date,
            'expiry_date' => $request->expiry_date,
            'status'      => $request->status,
            'lang'        => $request->lang,
        ]);

        return redirect()->route('admin.auction.all')->with(['msg' => __('Auction notice created successfully'), 'type' => 'success']);
    }

    public function edit_auction($id)
    {
        $auction = Auction::findOrFail($id);
        $all_languages = Language::all();
        return view('backend.pages.auction.edit')->with([
            'auction'       => $auction,
            'all_languages' => $all_languages,
        ]);
    }

    public function update_auction(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:255',
            'notice_date' => 'required|date',
            'expiry_date' => 'required|date',
            'status'      => 'required',
        ]);

        $auction = Auction::findOrFail($id);
        $auction->update([
            'title'       => SanitizeInput::esc_html($request->title),
            'description' => $request->description,
            'image'       => $request->image,
            'notice_date' => $request->notice_date,
            'expiry_date' => $request->expiry_date,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.auction.all')->with(['msg' => __('Auction notice updated successfully'), 'type' => 'success']);
    }

    public function delete_auction(Request $request, $id)
    {
        Auction::findOrFail($id)->delete();
        return redirect()->route('admin.auction.all')->with(['msg' => __('Auction notice deleted'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        $ids = $request->ids ?? [];
        if ($request->action === 'delete') {
            Auction::whereIn('id', $ids)->delete();
            return redirect()->back()->with(['msg' => __('Selected auctions deleted'), 'type' => 'danger']);
        }
        return redirect()->back();
    }

    public function page_settings()
    {
        return view('backend.pages.auction.settings');
    }

    public function update_page_settings(Request $request)
    {
        $fields = [
            'auction_page_slug',
            'auction_page_title',
            'auction_page_meta_description',
            'auction_page_meta_tags',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                update_static_option($field, $request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Auction page settings updated'), 'type' => 'success']);
    }
}
