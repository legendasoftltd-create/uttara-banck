<?php

namespace App\Http\Controllers;

use App\Notice;
use App\Language;
use App\Helpers\SanitizeInput;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_notices = Notice::orderBy('notice_date', 'desc')->get()->groupBy('lang');
        return view('backend.pages.notice.index')->with([
            'all_notices' => $all_notices,
        ]);
    }

    public function new_notice()
    {
        $all_languages = Language::all();
        return view('backend.pages.notice.new')->with([
            'all_languages' => $all_languages,
        ]);
    }

    public function store_notice(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:255',
            'notice_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'status'      => 'required',
            'lang'        => 'required',
        ]);

        $slug = Str::slug($request->title . '-' . $request->notice_date);
        if (Notice::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        Notice::create([
            'title'       => SanitizeInput::esc_html($request->title),
            'slug'        => $slug,
            'category'    => SanitizeInput::esc_html($request->category),
            'description' => $request->description,
            'image'       => $request->image,
            'notice_date' => $request->notice_date,
            'expiry_date' => $request->expiry_date ?: null,
            'status'      => $request->status,
            'lang'        => $request->lang,
        ]);

        return redirect()->route('admin.notice.all')->with(['msg' => __('Notice created successfully'), 'type' => 'success']);
    }

    public function edit_notice($id)
    {
        $notice = Notice::findOrFail($id);
        $all_languages = Language::all();
        return view('backend.pages.notice.edit')->with([
            'notice'        => $notice,
            'all_languages' => $all_languages,
        ]);
    }

    public function update_notice(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:255',
            'notice_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'status'      => 'required',
        ]);

        $notice = Notice::findOrFail($id);
        $notice->update([
            'title'       => SanitizeInput::esc_html($request->title),
            'category'    => SanitizeInput::esc_html($request->category),
            'description' => $request->description,
            'image'       => $request->image,
            'notice_date' => $request->notice_date,
            'expiry_date' => $request->expiry_date ?: null,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.notice.all')->with(['msg' => __('Notice updated successfully'), 'type' => 'success']);
    }

    public function delete_notice(Request $request, $id)
    {
        Notice::findOrFail($id)->delete();
        return redirect()->route('admin.notice.all')->with(['msg' => __('Notice deleted'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        $ids = $request->ids ?? [];
        if ($request->action === 'delete') {
            Notice::whereIn('id', $ids)->delete();
        }
        return redirect()->back()->with(['msg' => __('Bulk action applied'), 'type' => 'success']);
    }

    public function page_settings()
    {
        return view('backend.pages.notice.settings');
    }

    public function update_page_settings(Request $request)
    {
        $fields = [
            'notice_page_slug',
            'notice_page_title',
            'notice_page_meta_description',
            'notice_page_meta_tags',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                update_static_option($field, $request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Notice page settings updated'), 'type' => 'success']);
    }
}
