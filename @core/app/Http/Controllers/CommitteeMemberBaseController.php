<?php

namespace App\Http\Controllers;

use App\Designation;
use App\Language;
use App\TeamMember;
use Illuminate\Http\Request;

/**
 * Base controller for committee-type admin pages.
 * Child classes must define COMMITTEE, TITLE, and ROUTE_PREFIX constants.
 */
abstract class CommitteeMemberBaseController extends Controller
{
    /** TeamMember type key, e.g. 'executive_committee' */
    protected const COMMITTEE = '';

    /** Human-readable page title, e.g. 'Executive Committee' */
    protected const TITLE = '';

    /** Route name prefix, e.g. 'admin.executive.committee' */
    protected const ROUTE_PREFIX = '';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function committeeKey(): string  { return static::COMMITTEE; }
    protected function pageTitle(): string     { return static::TITLE; }
    protected function routePrefix(): string   { return static::ROUTE_PREFIX; }

    public function index()
    {
        $all_language = Language::all();

        $all_members = TeamMember::all()
            ->filter(function ($m) {
                return in_array($this->committeeKey(), (array) $m->type);
            })
            ->groupBy('lang');

        $all_designations = Designation::all();

        return view('backend.pages.committee-member')->with([
            'all_members'      => $all_members,
            'all_languages'    => $all_language,
            'all_designations' => $all_designations,
            'committee_key'    => $this->committeeKey(),
            'page_title'       => $this->pageTitle(),
            'route_prefix'     => $this->routePrefix(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'           => 'required|string|max:191',
            'lang'           => 'required|string|max:191',
            'designation'    => 'required|string|max:191',
            'image'          => 'nullable|string|max:191',
            'icon_one'       => 'nullable|string|max:191',
            'icon_two'       => 'nullable|string|max:191',
            'icon_three'     => 'nullable|string|max:191',
            'icon_one_url'   => 'nullable|string|max:191',
            'icon_two_url'   => 'nullable|string|max:191',
            'icon_three_url' => 'nullable|string|max:191',
            'order_by'       => 'nullable|integer',
            'status'         => 'nullable|string|max:191',
        ]);

        $data = $request->all();
        $data['type'] = [$this->committeeKey()];

        TeamMember::create($data);

        return redirect()->back()->with([
            'msg'  => __('New Member Added Successfully'),
            'type' => 'success',
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id'             => 'required|integer',
            'name'           => 'required|string|max:191',
            'lang'           => 'required|string|max:191',
            'designation'    => 'required|string|max:191',
            'image'          => 'nullable|string|max:191',
            'icon_one'       => 'nullable|string|max:191',
            'icon_two'       => 'nullable|string|max:191',
            'icon_three'     => 'nullable|string|max:191',
            'icon_one_url'   => 'nullable|string|max:191',
            'icon_two_url'   => 'nullable|string|max:191',
            'icon_three_url' => 'nullable|string|max:191',
            'order_by'       => 'nullable|integer',
            'status'         => 'nullable|string|max:191',
        ]);

        $data = $request->except('id');
        $data['type'] = [$this->committeeKey()];

        TeamMember::findOrFail($request->id)->update($data);

        return redirect()->back()->with([
            'msg'  => __('Member Updated Successfully'),
            'type' => 'success',
        ]);
    }

    public function delete($id)
    {
        TeamMember::findOrFail($id)->delete();

        return redirect()->back()->with([
            'msg'  => __('Member Deleted'),
            'type' => 'danger',
        ]);
    }

    public function bulk_action(Request $request)
    {
        TeamMember::whereIn('id', $request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }
}
