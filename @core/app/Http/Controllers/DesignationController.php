<?php

namespace App\Http\Controllers;

use App\Designation;
use App\Language;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_languages = Language::all();
        $all_designations = Designation::all()->groupBy('lang');
        return view('backend.pages.designation')->with([
            'all_designations' => $all_designations,
            'all_languages'    => $all_languages,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
        ]);
        Designation::create($request->only('name', 'lang'));
        return redirect()->back()->with(['msg' => __('Designation Added Successfully'), 'type' => 'success']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id'   => 'required|integer',
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
        ]);
        Designation::findOrFail($request->id)->update($request->only('name', 'lang'));
        return redirect()->back()->with(['msg' => __('Designation Updated Successfully'), 'type' => 'success']);
    }

    public function delete($id)
    {
        Designation::findOrFail($id)->delete();
        return redirect()->back()->with(['msg' => __('Designation Deleted'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        Designation::whereIn('id', $request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }
}
