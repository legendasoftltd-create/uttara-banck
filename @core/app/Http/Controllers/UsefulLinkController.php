<?php

namespace App\Http\Controllers;

use App\UsefulLink;
use App\Language;
use App\Helpers\SanitizeInput;
use Illuminate\Http\Request;

class UsefulLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_links = UsefulLink::orderBy('sort_order')->orderBy('id')->get()->groupBy('lang');
        return view('backend.pages.useful-links.index')->with([
            'all_links' => $all_links,
        ]);
    }

    public function new_link()
    {
        $all_languages = Language::all();
        return view('backend.pages.useful-links.new')->with([
            'all_languages' => $all_languages,
        ]);
    }

    public function store_link(Request $request)
    {
        $this->validate($request, [
            'title'  => 'required|string|max:500',
            'url'    => 'required|string|max:500',
            'status' => 'required',
            'lang'   => 'required',
        ]);

        $max_order = UsefulLink::where('lang', $request->lang)->max('sort_order') ?? 0;

        UsefulLink::create([
            'title'      => SanitizeInput::esc_html($request->title),
            'url'        => $request->url,
            'image'      => $request->image,
            'sort_order' => $max_order + 1,
            'status'     => $request->status,
            'lang'       => $request->lang,
        ]);

        return redirect()->route('admin.useful.links.all')
            ->with(['msg' => __('Link added successfully'), 'type' => 'success']);
    }

    public function edit_link($id)
    {
        $link = UsefulLink::findOrFail($id);
        $all_languages = Language::all();
        return view('backend.pages.useful-links.edit')->with([
            'link'          => $link,
            'all_languages' => $all_languages,
        ]);
    }

    public function update_link(Request $request, $id)
    {
        $this->validate($request, [
            'title'  => 'required|string|max:500',
            'url'    => 'required|string|max:500',
            'status' => 'required',
        ]);

        UsefulLink::findOrFail($id)->update([
            'title'      => SanitizeInput::esc_html($request->title),
            'url'        => $request->url,
            'image'      => $request->image,
            'sort_order' => $request->sort_order ?? 0,
            'status'     => $request->status,
        ]);

        return redirect()->route('admin.useful.links.all')
            ->with(['msg' => __('Link updated successfully'), 'type' => 'success']);
    }

    public function delete_link(Request $request, $id)
    {
        UsefulLink::findOrFail($id)->delete();
        return redirect()->route('admin.useful.links.all')
            ->with(['msg' => __('Link deleted'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        $ids = $request->ids ?? [];
        if ($request->action === 'delete') {
            UsefulLink::whereIn('id', $ids)->delete();
        }
        return redirect()->back()->with(['msg' => __('Bulk action applied'), 'type' => 'success']);
    }

    public function update_order(Request $request)
    {
        foreach ($request->order ?? [] as $item) {
            UsefulLink::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }
        return response()->json(['status' => true]);
    }

    public function page_settings()
    {
        return view('backend.pages.useful-links.settings');
    }

    public function update_page_settings(Request $request)
    {
        foreach (['useful_links_page_slug', 'useful_links_page_title', 'useful_links_page_meta_description', 'useful_links_page_meta_tags'] as $field) {
            if ($request->has($field)) {
                update_static_option($field, $request->$field);
            }
        }
        return redirect()->back()->with(['msg' => __('Settings updated'), 'type' => 'success']);
    }
}
