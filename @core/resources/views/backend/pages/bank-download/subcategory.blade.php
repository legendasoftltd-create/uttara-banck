@extends('backend.admin-master')
@section('site-title')
    {{__('Bank Download Subcategories')}}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
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
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-8 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Bank Download Subcategories')}}</h4>
                        <div class="bulk-delete-wrapper">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value="">{{{__('Bulk Action')}}}</option>
                                    <option value="delete">{{{__('Delete')}}}</option>
                                    <option value="publish">{{__('Publish')}}</option>
                                    <option value="draft">{{__('Draft')}}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                            </div>
                        </div>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_subcategories as $key => $subcategories)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#subcategory_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_subcategories as $key => $subcategories)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="subcategory_tab_{{$key}}" role="tabpanel" >
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default">
                                        <thead>
                                        <th class="no-sort">
                                            <div class="mark-all-checkbox">
                                                <input type="checkbox" class="all-checkbox">
                                            </div>
                                        </th>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Category')}}</th>
                                        <th>{{__('Slug')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($subcategories as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->title}}</td>
                                                <td>{{optional($data->category)->title ?? 'N/A'}}</td>
                                                <td>{{$data->slug}}</td>
                                                <td>
                                                    @if('publish' == $data->status)
                                                        <span class="btn btn-success btn-sm">{{ucfirst(__($data->status))}}</span>
                                                    @else
                                                        <span class="btn btn-warning btn-sm">{{ucfirst(__($data->status))}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#subcategory_edit_modal"
                                                       class="btn btn-primary btn-xs mb-3 mr-1 subcategory_edit_btn"
                                                       data-id="{{$data->id}}"
                                                       data-title="{{$data->title}}"
                                                       data-category_id="{{$data->category_id}}"
                                                       data-status="{{$data->status}}"
                                                    >
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <x-delete-popover :url="route('admin.bank.download.subcategory.delete',$data->id)"/>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                @php $b++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Subcategory')}}</h4>
                        <form method="POST" action="{{ route('admin.bank.download.subcategory') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="{{__('Title')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">{{__('Category')}}</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">{{__('Select Category')}}</option>
                                    @foreach(\App\BankDownloadCategory::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" hidden>
                                <label for="lang">{{__('Language')}}</label>
                                <select id="lang" name="lang" class="form-control" required>
                                    @foreach(get_all_language() as $language)
                                        <option value="{{ $language->slug }}" @if($language->default) selected @endif>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="publish">{{__('Publish')}}</option>
                                    <option value="draft">{{__('Draft')}}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Add Subcategory')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Subcategory Modal -->
    <div class="modal fade" id="subcategory_edit_modal" tabindex="-1" role="dialog" aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubcategoryModalLabel">{{__('Edit Subcategory')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_subcategory_form" method="POST">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" id="edit_title" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_id">{{__('Category')}}</label>
                            <select id="edit_category_id" name="category_id" class="form-control" required>
                                <option value="">{{__('Select Category')}}</option>
                                @foreach(\App\BankDownloadCategory::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_sub_status">{{__('Status')}}</label>
                            <select id="edit_sub_status" name="status" class="form-control" required>
                                <option value="publish">{{__('Publish')}}</option>
                                <option value="draft">{{__('Draft')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Update Subcategory')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="{{asset('assets/backend/js/bulk-action.js')}}"></script>
    <script>
        $(document).on('click', '.subcategory_edit_btn', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const category_id = $(this).data('category_id');
            const status = $(this).data('status');
            
            $('#edit_id').val(id);
            $('#edit_title').val(title);
            $('#edit_category_id').val(category_id);
            $('#edit_sub_status').val(status);
            $('#edit_subcategory_form').attr('action', '{{ route("admin.bank.download.subcategory.update") }}');
        });
        
        $('#edit_subcategory_form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    location.reload();
                }
            });
        });
    </script>
@endsection
