<?php

namespace App\Http\Controllers;

use App\Designation;
use App\Language;
use App\TeamMember;
use Illuminate\Http\Request;

class BoardOfDirectorController extends Controller
{
    // The committee key for Board of Directors in TeamMember model
    const COMMITTEE = 'board_of_directors';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_language = Language::all();

        // Only fetch board_of_directors type members, grouped by lang
        $all_members = TeamMember::all()
            ->filter(function ($m) {
                return in_array(self::COMMITTEE, (array) $m->type);
            })
            ->groupBy('lang');

        $all_designations = Designation::all();

        return view('backend.pages.board-of-director')->with([
            'all_members'      => $all_members,
            'all_languages'    => $all_language,
            'all_designations' => $all_designations,
            'committee_key'    => self::COMMITTEE,
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

        // Always assign board_of_directors type
        $data = $request->all();
        $data['type'] = [self::COMMITTEE];

        TeamMember::create($data);

        return redirect()->back()->with(['msg' => __('New Board Member Added Successfully'), 'type' => 'success']);
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
        $data['type'] = [self::COMMITTEE];

        TeamMember::findOrFail($request->id)->update($data);

        return redirect()->back()->with(['msg' => __('Board Member Updated Successfully'), 'type' => 'success']);
    }

    public function delete($id)
    {
        TeamMember::findOrFail($id)->delete();
        return redirect()->back()->with(['msg' => __('Board Member Deleted'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        TeamMember::whereIn('id', $request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }
}
