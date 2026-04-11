<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    private const BASE_PATH = 'backend.locations.';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_locations(Request $request)
    {
        $query = Location::query();

        if (!empty($request->type)) {
            $query->where('type', $request->type);
        }

        if (!empty($request->division)) {
            $query->where('division', $request->division);
        }

        if (!empty($request->district)) {
            $query->where('district', $request->district);
        }

        $all_locations = $query->orderBy('type')->orderBy('name')->get();

        return view(self::BASE_PATH . 'all-locations')->with([
            'all_locations' => $all_locations,
            'filters' => $request->only(['type', 'division', 'district']),
        ]);
    }

    public function new_location()
    {
        return view(self::BASE_PATH . 'new-location');
    }

    public function store_location(Request $request)
    {
        $data = $this->validatedData($request);
        Location::create($this->prepareData($data));

        return redirect()->back()->with([
            'msg' => __('New location added successfully.'),
            'type' => 'success',
        ]);
    }

    public function edit_location($id)
    {
        $location = Location::findOrFail($id);

        return view(self::BASE_PATH . 'edit-location')->with([
            'location' => $location,
        ]);
    }

    public function update_location(Request $request)
    {
        $location = Location::findOrFail($request->location_id);
        $data = $this->validatedData($request, $location->id);
        $location->update($this->prepareData($data));

        return redirect()->back()->with([
            'msg' => __('Location updated successfully.'),
            'type' => 'success',
        ]);
    }

    public function delete_location($id)
    {
        Location::findOrFail($id)->delete();

        return redirect()->back()->with([
            'msg' => __('Location deleted successfully.'),
            'type' => 'danger',
        ]);
    }

    public function bulk_action(Request $request)
    {
        Location::whereIn('id', $request->ids ?? [])->delete();

        return response()->json(['status' => 'ok']);
    }

    private function validatedData(Request $request, $id = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:191',
            'slug' => [
                'nullable',
                'string',
                'max:191',
                Rule::unique('locations', 'slug')->ignore($id),
            ],
            'type' => ['required', Rule::in(['branch', 'sub_branch', 'atm'])],
            'branch_point' => 'nullable|string|max:191',
            'branch' => 'nullable|string|max:191',
            'division' => 'nullable|string|max:191',
            'district' => 'nullable|string|max:191',
            'upazila' => 'nullable|string|max:191',
            'address' => 'required|string|max:500',
            'email' => 'nullable|email|max:191',
            'mobile' => 'nullable|string|max:191',
            'fax' => 'nullable|string|max:191',
            'image' => 'nullable|integer',
            'dates' => 'nullable|string|max:191',
            'date_opening' => 'nullable|date',
            'map' => 'nullable|string',
            'locker' => 'nullable|boolean',
            'dhaka_branch' => 'nullable|boolean',
            'gstatus' => 'nullable|string|max:191',
            'routing_no' => 'nullable|string|max:191',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);
    }

    private function prepareData(array $data): array
    {
        $data['slug'] = !empty($data['slug']) ? $data['slug'] : Str::slug($data['name']);
        $data['status'] = (int) ($data['status'] ?? 0);
        $data['locker'] = (int) ($data['locker'] ?? 0);
        $data['dhaka_branch'] = (int) ($data['dhaka_branch'] ?? 0);
        $data['phone'] = $data['mobile'] ?? null;
        $data['latitude'] = $data['latitude'] ?? 0;
        $data['longitude'] = $data['longitude'] ?? 0;

        return $data;
    }
}
