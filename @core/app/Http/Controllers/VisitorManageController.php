<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;

class VisitorManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_visitors = Visitor::orderBy('id', 'desc')->paginate(20);
        $total_db_visitors = Visitor::count();
        return view('backend.pages.visitors')->with([
            'all_visitors' => $all_visitors,
            'total_db_visitors' => $total_db_visitors
        ]);
    }

    public function update_settings(Request $request)
    {
        $this->validate($request, [
            'show_visitor_count' => 'nullable|string',
            'manual_visitor_count' => 'nullable|integer|min:0',
        ]);

        update_static_option('show_visitor_count', $request->show_visitor_count);
        update_static_option('manual_visitor_count', $request->manual_visitor_count ?? 0);

        return redirect()->back()->with(['msg' => __('Settings Updated...'), 'type' => 'success']);
    }

    public function delete($id)
    {
        Visitor::findOrFail($id)->delete();
        return redirect()->back()->with(['msg' => __('Visitor Log Deleted...'), 'type' => 'danger']);
    }

    public function bulk_action(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array',
        ]);

        Visitor::whereIn('id', $request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }

    public function clear_all()
    {
        Visitor::truncate();
        return redirect()->back()->with(['msg' => __('All Visitor Logs Cleared...'), 'type' => 'danger']);
    }
}
