@extends('backend.admin-master')
@section('site-title')
    {{__('Designations')}}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
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

            {{-- List --}}
            <div class="@if(check_page_permission('designation_create')) col-lg-8 @else col-lg-12 @endif mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Designations')}}</h4>
                        @if(check_page_permission('designation_delete'))
                        <div class="bulk-delete-wrapper mb-3">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value="">{{__('Bulk Action')}}</option>
                                    <option value="delete">{{__('Delete')}}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                            </div>
                        </div>
                        @endif

                        <ul class="nav nav-tabs" id="langTab" role="tablist">
                            @php $i = 0; @endphp
                            @foreach($all_designations as $langKey => $items)
                                <li class="nav-item">
                                    <a class="nav-link @if($i == 0) active @endif"
                                       data-toggle="tab" href="#lang_tab_{{$langKey}}" role="tab">
                                        {{get_language_by_slug($langKey)}}
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>

                        <div class="tab-content mt-4" id="langTabContent">
                            @php $j = 0; @endphp
                            @foreach($all_designations as $langKey => $items)
                                <div class="tab-pane fade @if($j == 0) show active @endif"
                                     id="lang_tab_{{$langKey}}" role="tabpanel">
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default">
                                            <thead>
                                                @if(check_page_permission('designation_delete'))
                                                <th class="no-sort">
                                                    <div class="mark-all-checkbox">
                                                        <input type="checkbox" class="all-checkbox">
                                                    </div>
                                                </th>
                                                @endif
                                                <th>{{__('ID')}}</th>
                                                <th>{{__('Designation Name')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </thead>
                                            <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    @if(check_page_permission('designation_delete'))
                                                    <td>
                                                        <div class="bulk-checkbox-wrapper">
                                                            <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$item->id}}">
                                                        </div>
                                                    </td>
                                                    @endif
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>
                                                        @if(check_page_permission('designation_delete'))
                                                        <x-delete-popover :url="route('admin.designation.delete', $item->id)"/>
                                                        @endif
                                                        @if(check_page_permission('designation_edit'))
                                                        <a href="#"
                                                           data-toggle="modal"
                                                           data-target="#designation_edit_modal"
                                                           class="btn btn-primary btn-xs mb-3 mr-1 designation_edit_btn"
                                                           data-id="{{$item->id}}"
                                                           data-name="{{$item->name}}"
                                                           data-lang="{{$item->lang}}">
                                                            <i class="ti-pencil"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @php $j++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add Form --}}
            @if(check_page_permission('designation_create'))
            <div class="col-lg-4 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Designation')}}</h4>
                        <form action="{{route('admin.designation.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>{{__('Language')}}</label>
                                <select name="lang" class="form-control">
                                    @foreach($all_languages as $lang)
                                        <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{__('Designation Name')}} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="{{__('e.g. Chairman')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 pr-4 pl-4">{{__('Add Designation')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="designation_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Designation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.designation.update')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="edit_designation_id">
                        <div class="form-group">
                            <label>{{__('Language')}}</label>
                            <select name="lang" class="form-control" id="edit_designation_lang">
                                @foreach($all_languages as $lang)
                                    <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{__('Designation Name')}} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="edit_designation_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $(document).on('click', '#bulk_delete_btn', function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allIds = [];
                $('.bulk-checkbox:checked').each(function () { allIds.push($(this).val()); });
                if (allIds.length && bulkOption === 'delete') {
                    $(this).text('{{__('Deleting...')}}');
                    $.ajax({
                        type: 'POST',
                        url: '{{route('admin.designation.bulk.action')}}',
                        data: { _token: '{{csrf_token()}}', ids: allIds },
                        success: function () { location.reload(); }
                    });
                }
            });

            $('.all-checkbox').on('change', function () {
                var checked = $(this).is(':checked');
                $(this).closest('table').find('.bulk-checkbox').prop('checked', checked);
            });

            $(document).on('click', '.designation_edit_btn', function () {
                var el = $(this);
                $('#edit_designation_id').val(el.data('id'));
                $('#edit_designation_name').val(el.data('name'));
                $('#edit_designation_lang option[value="' + el.data('lang') + '"]').prop('selected', true);
            });

        });
    </script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.table-wrap > table').DataTable({
                order: [[1, 'desc']],
                columnDefs: [{ targets: 'no-sort', orderable: false }]
            });
        });
    </script>
@endsection
