<?php

namespace App\Http\Controllers;

use App\ComplaintCellMember;
use Illuminate\Http\Request;

class ComplaintCellController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function complaint_cell_settings()
    {
        $all_members = ComplaintCellMember::orderBy('section')->orderBy('zone_name')->orderBy('sort_order')->get();
        return view('backend.pages.complaint-cell-settings')->with([
            'all_members' => $all_members,
        ]);
    }

    public function update_complaint_cell_info(Request $request)
    {
        $this->validate($request, [
            'complaint_cell_bank_name' => 'nullable|string|max:191',
            'complaint_cell_email' => 'nullable|string|max:191',
            'complaint_cell_phone' => 'nullable|string|max:191',
        ]);

        update_static_option('complaint_cell_bank_name', $request->complaint_cell_bank_name);
        update_static_option('complaint_cell_email', $request->complaint_cell_email);
        update_static_option('complaint_cell_phone', $request->complaint_cell_phone);

        return redirect()->back()->with([
            'msg' => __('Complaint Cell Info Updated...'),
            'type' => 'success'
        ]);
    }

    public function new_member(Request $request)
    {
        $this->validate($request, [
            'section' => 'required|in:central,zonal',
            'zone_name' => 'nullable|string|max:191',
            'name' => 'required|string|max:191',
            'designation' => 'nullable|string|max:191',
            'position' => 'nullable|string|max:191',
            'contact' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        ComplaintCellMember::create([
            'section' => $request->section,
            'zone_name' => $request->section === 'zonal' ? $request->zone_name : null,
            'name' => $request->name,
            'designation' => $request->designation,
            'position' => $request->position,
            'contact' => $request->contact,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with([
            'msg' => __('New Member Added...'),
            'type' => 'success'
        ]);
    }

    public function update_member(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'section' => 'required|in:central,zonal',
            'zone_name' => 'nullable|string|max:191',
            'name' => 'required|string|max:191',
            'designation' => 'nullable|string|max:191',
            'position' => 'nullable|string|max:191',
            'contact' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        ComplaintCellMember::find($request->id)->update([
            'section' => $request->section,
            'zone_name' => $request->section === 'zonal' ? $request->zone_name : null,
            'name' => $request->name,
            'designation' => $request->designation,
            'position' => $request->position,
            'contact' => $request->contact,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with([
            'msg' => __('Member Updated...'),
            'type' => 'success'
        ]);
    }

    public function delete_member(Request $request, $id)
    {
        ComplaintCellMember::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Member Deleted...'),
            'type' => 'danger'
        ]);
    }
}
