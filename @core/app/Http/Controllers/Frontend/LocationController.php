<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::published();

        if (!empty($request->type)) {
            $query->where('type', $request->type);
        }

        foreach (['division', 'district', 'upazila', 'branch_point'] as $field) {
            if (!empty($request->$field)) {
                $query->where($field, $request->$field);
            }
        }

        if ($request->filled('dhaka_branch')) {
            $query->where('dhaka_branch', (int) $request->dhaka_branch);
        }

        if ($request->filled('locker')) {
            $query->where('locker', (int) $request->locker);
        }

        $filteredQuery = (clone $query)->orderBy('type')->orderBy('name');
        $locations = (clone $filteredQuery)->paginate(12)->withQueryString();
        $locationDirectory = (clone $filteredQuery)->get();
        $types = $locationDirectory->pluck('type')->unique()->values();
            
        return view('frontend.pages.locations.index')->with([
            'locations' => $locations,
            'locationDirectory' => $locationDirectory,
            'types' => $types,
            'user_select_lang_slug' => LanguageHelper::user_lang_slug(),
            'filters' => $request->only(['type', 'division', 'district', 'upazila', 'branch_point', 'dhaka_branch', 'locker']),
            'divisions' => Location::published()->whereNotNull('division')->where('division', '!=', '')->distinct()->orderBy('division')->pluck('division'),
            'districts' => Location::published()->whereNotNull('district')->where('district', '!=', '')->distinct()->orderBy('district')->pluck('district'),
            'upazilas' => Location::published()->whereNotNull('upazila')->where('upazila', '!=', '')->distinct()->orderBy('upazila')->pluck('upazila'),
        ]);
    }

    public function show($slug)
    {
        $location = Location::published()->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.locations.single')->with([
            'location' => $location,
            'user_select_lang_slug' => LanguageHelper::user_lang_slug(),
            'related_locations' => Location::published()
                ->where('type', $location->type)
                ->where('id', '!=', $location->id)
                ->orderBy('name')
                ->take(6)
                ->get(),
        ]);
    }
}
