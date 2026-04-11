@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
        }
    </style>
@endsection
@section('site-title')
    {{__('All Locations')}}
@endsection
@section('content')
    <div class="col-lg-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between mb-4">
                            <h4 class="header-title">{{__('Bank Branch, Sub-Branch & ATM List')}}</h4>
                            <a href="{{route('admin.locations.new')}}" class="btn btn-primary">{{__('Add New Location')}}</a>
                        </div>

                        <form method="get" action="{{route('admin.locations.all')}}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="type">{{__('Type')}}</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="">{{__('All')}}</option>
                                            <option value="branch" @if(($filters['type'] ?? '') == 'branch') selected @endif>{{__('Branch')}}</option>
                                            <option value="sub_branch" @if(($filters['type'] ?? '') == 'sub_branch') selected @endif>{{__('Sub Branch')}}</option>
                                            <option value="atm" @if(($filters['type'] ?? '') == 'atm') selected @endif>{{__('ATM')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="division">{{__('Division')}}</label>
                                        <input type="text" id="division" name="division" class="form-control" value="{{$filters['division'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="district">{{__('District')}}</label>
                                        <input type="text" id="district" name="district" class="form-control" value="{{$filters['district'] ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <button class="btn btn-info mr-2" type="submit">{{__('Filter')}}</button>
                                        <a href="{{route('admin.locations.all')}}" class="btn btn-secondary">{{__('Reset')}}</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="bulk-delete-wrapper">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value="">{{__('Bulk Action')}}</option>
                                    <option value="delete">{{__('Delete')}}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                            </div>
                        </div>

                        <div class="table-wrap table-responsive">
                            <table class="table table-default" id="all_locations_table">
                                <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="mark-all-checkbox">
                                            <input type="checkbox" class="all-checkbox">
                                        </div>
                                    </th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Type')}}</th>
                                    <th>{{__('Division')}}</th>
                                    <th>{{__('District')}}</th>
                                    <th>{{__('Mobile')}}</th>
                                    <th>{{__('Routing No')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_locations as $location)
                                    <tr>
                                        <td>
                                            <div class="bulk-checkbox-wrapper">
                                                <input type="checkbox" class="bulk-checkbox" value="{{$location->id}}">
                                            </div>
                                        </td>
                                        <td>{{$location->id}}</td>
                                        <td>{{$location->name}}</td>
                                        <td>{{ucwords(str_replace('_',' ',$location->type))}}</td>
                                        <td>{{$location->division}}</td>
                                        <td>{{$location->district}}</td>
                                        <td>{{$location->mobile}}</td>
                                        <td>{{$location->routing_no}}</td>
                                        <td>
                                            @if($location->status)
                                                <span class="alert alert-success" style="display:inline-block;">{{__('Publish')}}</span>
                                            @else
                                                <span class="alert alert-warning" style="display:inline-block;">{{__('Draft')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <x-delete-popover :url="route('admin.locations.delete',$location->id)"/>
                                            <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.locations.edit',$location->id)}}">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            <a class="btn btn-info btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.locations.single',$location->slug)}}">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#all_locations_table').DataTable({
                order: [[1, 'desc']],
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });

            $(document).on('click', '#bulk_delete_btn', function (e) {
                e.preventDefault();

                var bulkOption = $('#bulk_option').val();
                var allIds = [];

                $('.bulk-checkbox:checked').each(function () {
                    allIds.push($(this).val());
                });

                if (allIds.length && bulkOption === 'delete') {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('admin.locations.bulk.action')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            ids: allIds
                        },
                        success: function () {
                            location.reload();
                        }
                    });
                }
            });

            $('.all-checkbox').on('change', function () {
                $('.bulk-checkbox').prop('checked', $(this).is(':checked'));
            });
        });
    </script>
@endsection
