@extends('backend.admin-master')
@section('site-title')
    {{__('Visitor Management')}}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 0 !important;
        }
        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
            display: inline-block;
        }
    </style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Visitor Logs List -->
            <div class="@if(check_page_permission('visitor_log_delete')) col-lg-7 @else col-lg-12 @endif mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title mb-0">{{__('Visitor Logs')}}</h4>
                            @if(check_page_permission('visitor_log_delete'))
                            <form action="{{route('admin.visitors.clear.all')}}" method="POST" onsubmit="return confirm('Are you sure you want to clear all logs?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">{{__('Clear All Logs')}}</button>
                            </form>
                            @endif
                        </div>
                        @if(check_page_permission('visitor_log_delete'))
                        <div class="bulk-delete-wrapper mb-3">
                            <div class="select-box-wrap d-flex justify-content-start align-items-center">
                                <select name="bulk_option" id="bulk_option" class="form-control form-control-sm mr-2" style="width: 150px;">
                                    <option value="">{{__('Bulk Action')}}</option>
                                    <option value="delete">{{{__('Delete')}}}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                            </div>
                        </div>
                        @endif
                        <div class="table-wrap table-responsive">
                            <table class="table table-default">
                                <thead>
                                @if(check_page_permission('visitor_log_delete'))
                                <th class="no-sort" style="width: 50px;">
                                    <div class="mark-all-checkbox">
                                        <input type="checkbox" class="all-checkbox">
                                    </div>
                                </th>
                                @endif
                                <th>{{__('ID')}}</th>
                                <th>{{__('IP Address')}}</th>
                                <th>{{__('Visit Date')}}</th>
                                <th>{{__('Action')}}</th>
                                </thead>
                                <tbody>
                                @foreach($all_visitors as $data)
                                    <tr>
                                        @if(check_page_permission('visitor_log_delete'))
                                        <td>
                                            <div class="bulk-checkbox-wrapper">
                                                <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                            </div>
                                        </td>
                                        @endif
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->ip_address}}</td>
                                        <td>{{$data->created_at ? $data->created_at->format('Y-m-d h:i A') : $data->visit_date}}</td>
                                        <td>
                                            @if(check_page_permission('visitor_log_delete'))
                                            <x-delete-popover :url="route('admin.visitors.delete',$data->id)"/>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper mt-4">
                            {!! $all_visitors->links() !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Column -->
            @if(check_page_permission('visitor_log_delete'))
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Visitor Counter Settings')}}</h4>
                        <form action="{{route('admin.visitors.settings')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="show_visitor_count"><strong>{{__('Show Visitor Counter in Footer')}}</strong></label>
                                <label class="switch">
                                    <input type="checkbox" name="show_visitor_count" id="show_visitor_count" @if(get_static_option('show_visitor_count') === 'on') checked @endif value="on">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <label for="manual_visitor_count">{{__('Manual Visitor Count Offset')}}</label>
                                <input type="number" class="form-control" id="manual_visitor_count" name="manual_visitor_count" value="{{get_static_option('manual_visitor_count') ?? 0}}" placeholder="{{__('e.g. 5000')}}">
                                <small class="text-muted">{{__('This value will be added to the database visitor count shown in the footer.')}}</small>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded">
                                <h5>{{__('Summary')}}</h5>
                                <ul class="list-unstyled mt-2">
                                    <li><strong>{{__('Database Logs Count:')}}</strong> {{number_format($total_db_visitors)}}</li>
                                    <li><strong>{{__('Manual Offset Count:')}}</strong> {{number_format(get_static_option('manual_visitor_count') ?? 0)}}</li>
                                    <hr>
                                    <li><strong>{{__('Total Count Displayed in Footer:')}}</strong> 
                                        {{number_format($total_db_visitors + (int)(get_static_option('manual_visitor_count') ?? 0))}}
                                    </li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();

                var bulkOption = $('#bulk_option').val();
                var allCheckbox =  $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption == 'delete'){
                    $(this).text('{{__('Deleting...')}}');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.visitors.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds
                        },
                        success:function (data) {
                            location.reload();
                        }
                    });
                }
            });

            $('.all-checkbox').on('change',function (e) {
                e.preventDefault();
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });
        });
    </script>
@endsection
