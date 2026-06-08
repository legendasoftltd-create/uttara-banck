<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_complaints()
    {
        $all_complaints = Complaint::orderBy('id', 'desc')->get();
        return view('backend.pages.all-complaints')->with(['all_complaints' => $all_complaints]);
    }

    public function status_change(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'status' => 'required|string|in:pending,in_progress,resolved',
        ]);

        Complaint::findOrFail($request->id)->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with([
            'msg' => __('Complaint Status Updated...'),
            'type' => 'success'
        ]);
    }

    public function delete_complaint(Request $request, $id)
    {
        Complaint::findOrFail($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Complaint Deleted...'),
            'type' => 'danger'
        ]);
    }
}
