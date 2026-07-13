@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Branch, Sub-Branch & ATM List')}}
@endsection
@section('page-title')
    {{__('Branch, Sub-Branch & ATM List')}}
@endsection
@section('content')
    {{-- <section class="padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form method="get" action="{{route('frontend.locations')}}" class="mb-5">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="type">
                                        <option value="">{{__('All Types')}}</option>
                                        <option value="branch" @if(($filters['type'] ?? '') == 'branch') selected @endif>{{__('Branch')}}</option>
                                        <option value="sub_branch" @if(($filters['type'] ?? '') == 'sub_branch') selected @endif>{{__('Sub Branch')}}</option>
                                        <option value="atm" @if(($filters['type'] ?? '') == 'atm') selected @endif>{{__('ATM')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="division">
                                        <option value="">{{__('All Divisions')}}</option>
                                        @foreach($divisions as $division)
                                            <option value="{{$division}}" @if(($filters['division'] ?? '') == $division) selected @endif>{{$division}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="district">
                                        <option value="">{{__('All Districts')}}</option>
                                        @foreach($districts as $district)
                                            <option value="{{$district}}" @if(($filters['district'] ?? '') == $district) selected @endif>{{$district}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="upazila">
                                        <option value="">{{__('All Upazilas')}}</option>
                                        @foreach($upazilas as $upazila)
                                            <option value="{{$upazila}}" @if(($filters['upazila'] ?? '') == $upazila) selected @endif>{{$upazila}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="locker">
                                        <option value="">{{__('Locker')}}</option>
                                        <option value="1" @if(($filters['locker'] ?? '') === '1') selected @endif>{{__('Yes')}}</option>
                                        <option value="0" @if(($filters['locker'] ?? '') === '0') selected @endif>{{__('No')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-base btn-block" type="submit">{{__('Filter')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse($locations as $location)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product-item-2 margin-bottom-30">
                            <div class="thumb">
                                <a href="{{route('frontend.locations.single',$location->slug)}}">
                                    {!! render_image_markup_by_attachment_id($location->image,'','grid') !!}
                                </a>
                            </div>
                            <div class="content">
                                <span class="cat">{{ucwords(str_replace('_',' ',$location->type))}}</span>
                                <h4 class="title">
                                    <a href="{{route('frontend.locations.single',$location->slug)}}">{{$location->name}}</a>
                                </h4>
                                <ul class="product-list-info">
                                    <li><strong>{{__('Division')}}:</strong> {{$location->division ?: __('N/A')}}</li>
                                    <li><strong>{{__('District')}}:</strong> {{$location->district ?: __('N/A')}}</li>
                                    <li><strong>{{__('Upazila')}}:</strong> {{$location->upazila ?: __('N/A')}}</li>
                                    <li><strong>{{__('Address')}}:</strong> {{$location->address}}</li>
                                    <li><strong>{{__('Mobile')}}:</strong> {{$location->mobile ?: __('N/A')}}</li>
                                    <li><strong>{{__('Routing No')}}:</strong> {{$location->routing_no ?: __('N/A')}}</li>
                                </ul>
                                <div class="btn-wrapper margin-top-20">
                                    <a href="{{route('frontend.locations.single',$location->slug)}}" class="btn-default rounded-btn">{{__('View Details')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <div class="alert alert-warning">{{__('No locations found for the selected filters.')}}</div>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{$locations->links()}}
                </div>
            </div>
        </div>
    </section> --}}

    <section class="location-section">
                <div class="container-fluid">
                <div class="empty-height-50"></div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center title-color">
                                FIND OUR LOCATIONS
                            </h2>
                            <div class="title-seperator">
                            </div>
                        </div>
                    </div> -->
                    <div class="tab-wrapper">
                    @forelse($types as $key => $type)
                        <button class="tab {{ $key === 0 ? 'active' : '' }}" data-tab="{{ $type }}">
                            {{ ucwords(str_replace('_',' ', $type)) }}
                        </button>
                    @empty
                        <div class="col-lg-12">
                            <div class="alert alert-warning">{{__('No locations found for the selected filters.')}}</div>
                        </div>
                    @endforelse
                    </div>
                    <div class="location-grid">
                        <div class="map-area" id="mapFrame">
                        </div>

                        <div class="list-area">
                            <div class="search-boxs">
                                <div class="filter-wrapper" style="display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;">
                                    <select id="filterCategory" style="flex: 1; min-width: 120px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; display: none;">
                                        <option value="">All Categories</option>
                                        <option value="Branches">Branch</option>
                                        <option value="AD Branches">AD Branch</option>
                                    </select>
                                    <select id="filterDivision" style="flex: 1; min-width: 120px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                        <option value="">All Divisions</option>
                                    </select>
                                    <select id="filterDistrict" style="flex: 1; min-width: 120px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                        <option value="">All Districts</option>
                                    </select>
                                </div>
                                <input type="text" id="searchInputLocation" placeholder="Search...">
                                <div class="branch-count pb-2" style="margin: 0px 10px; font-weight: bold; color: #1a1a1a;">
                                    Total: <span id="totalBranches">0</span>
                                </div>
                            </div>
                            <div class="branch-list" id="branchList"></div>
                        </div>
                    </div>
                </div>
            </section>
        @php
            $locationData = $locationDirectory->groupBy('type')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'address' => $item->address,
                        'phone' => $item->phone,
                        'mobile' => $item->mobile,
                        'email' => $item->email,
                        'division' => $item->division,
                        'district' => $item->district,
                        'upazila' => $item->upazila,
                        'map' => $item->map,
                        'latitude' => $item->latitude,
                        'longitude' => $item->longitude,
                        'routing_no' => $item->routing_no,
                        'branch_point' => $item->branch_point,
                        'query' => collect([
                            $item->name,
                            $item->address,
                            $item->upazila,
                            $item->district,
                            $item->division,
                            $item->email,
                            $item->phone,
                            $item->mobile,
                            $item->routing_no,
                            $item->branch_point
                        ])->filter()->implode(', '),
                    ];
                })->values();
            });
        @endphp
<script>
    window.locationData = @json($locationData);
</script>
@endsection
