@extends('backend.admin-master')
@section('site-title')
    {{__('Complaint Cell Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @include('backend/partials/error')
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Complaint Cell Info')}}</h4>
                        <form action="{{route('admin.complaint.cell.info.update')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="complaint_cell_bank_name">{{__('Bank Name')}}</label>
                                <input type="text" name="complaint_cell_bank_name" class="form-control" value="{{get_static_option('complaint_cell_bank_name')}}" id="complaint_cell_bank_name">
                            </div>
                            <div class="form-group">
                                <label for="complaint_cell_email">{{__('Email of Complaint Cell')}}</label>
                                <input type="text" name="complaint_cell_email" class="form-control" value="{{get_static_option('complaint_cell_email')}}" id="complaint_cell_email">
                            </div>
                            <div class="form-group">
                                <label for="complaint_cell_phone">{{__('Phone No of Complaint Cell')}}</label>
                                <input type="text" name="complaint_cell_phone" class="form-control" value="{{get_static_option('complaint_cell_phone')}}" id="complaint_cell_phone">
                            </div>
                            @if(check_page_permission('complaint_edit'))
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Info')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Complaint Cell Members')}}</h4>
                        @if(check_page_permission('complaint_create'))
                        <div class="right-cotnent margin-bottom-40"><a class="btn btn-primary" data-target="#add_member_modal" data-toggle="modal" href="#">{{__('Add New Member')}}</a></div>
                        @endif
                        <table class="table table-default">
                            <thead>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Section')}}</th>
                            <th>{{__('Zone')}}</th>
                            <th>{{__('Name & Designation')}}</th>
                            <th>{{__('Position')}}</th>
                            <th>{{__('Contact')}}</th>
                            <th>{{__('Order')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @foreach($all_members as $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{ucfirst($data->section)}}</td>
                                    <td>{{$data->zone_name}}</td>
                                    <td>{{$data->name}}<br><small class="text-muted">{{$data->designation}}</small></td>
                                    <td>{{$data->position}}</td>
                                    <td>{!! nl2br(e($data->contact)) !!}</td>
                                    <td>{{$data->sort_order}}</td>
                                    <td>
                                        @if(check_page_permission('complaint_delete'))
                                        <x-delete-popover :url="route('admin.complaint.cell.member.delete',$data->id)"/>
                                        @endif
                                        @if(check_page_permission('complaint_edit'))
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#edit_member_modal"
                                           class="btn btn-xs btn-primary btn-sm mb-3 mr-1 member_edit_btn"
                                           data-id="{{$data->id}}"
                                           data-section="{{$data->section}}"
                                           data-zone_name="{{$data->zone_name}}"
                                           data-name="{{$data->name}}"
                                           data-designation="{{$data->designation}}"
                                           data-position="{{$data->position}}"
                                           data-contact="{{$data->contact}}"
                                           data-sort_order="{{$data->sort_order}}"
                                        >
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_member_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add Complaint Cell Member')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{route('admin.complaint.cell.member.new')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="add_section">{{__('Section')}}</label>
                            <select name="section" id="add_section" class="form-control">
                                <option value="central">{{__('Central')}}</option>
                                <option value="zonal">{{__('Zonal')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_zone_name">{{__('Zone Name')}}</label>
                            <input type="text" name="zone_name" id="add_zone_name" class="form-control" placeholder="{{__('e.g. Dhaka North Zone (only for Zonal)')}}">
                        </div>
                        <div class="form-group">
                            <label for="add_name">{{__('Name')}}</label>
                            <input type="text" name="name" id="add_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="add_designation">{{__('Designation')}}</label>
                            <input type="text" name="designation" id="add_designation" class="form-control" placeholder="{{__('e.g. Deputy General Manager & Zonal Head')}}">
                        </div>
                        <div class="form-group">
                            <label for="add_position">{{__('Position in Cell')}}</label>
                            <input type="text" name="position" id="add_position" class="form-control" placeholder="{{__('e.g. Head of Cell / Member')}}">
                        </div>
                        <div class="form-group">
                            <label for="add_contact">{{__('Contact')}}</label>
                            <textarea name="contact" id="add_contact" class="form-control" rows="2" placeholder="{{__('Phone / Email')}}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="add_sort_order">{{__('Sort Order')}}</label>
                            <input type="number" name="sort_order" id="add_sort_order" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Add Member')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_member_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Complaint Cell Member')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{route('admin.complaint.cell.member.update')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="edit_id" value="">
                        <div class="form-group">
                            <label for="edit_section">{{__('Section')}}</label>
                            <select name="section" id="edit_section" class="form-control">
                                <option value="central">{{__('Central')}}</option>
                                <option value="zonal">{{__('Zonal')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_zone_name">{{__('Zone Name')}}</label>
                            <input type="text" name="zone_name" id="edit_zone_name" class="form-control" placeholder="{{__('e.g. Dhaka North Zone (only for Zonal)')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_name">{{__('Name')}}</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit_designation">{{__('Designation')}}</label>
                            <input type="text" name="designation" id="edit_designation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit_position">{{__('Position in Cell')}}</label>
                            <input type="text" name="position" id="edit_position" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit_contact">{{__('Contact')}}</label>
                            <textarea name="contact" id="edit_contact" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_sort_order">{{__('Sort Order')}}</label>
                            <input type="number" name="sort_order" id="edit_sort_order" class="form-control">
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
        (function($){
            "use strict";
            $(document).ready(function () {
                $(document).on('click', '.member_edit_btn', function () {
                    var el = $(this);
                    var form = $('#edit_member_modal');
                    form.find('#edit_id').val(el.data('id'));
                    form.find('#edit_section').val(el.data('section'));
                    form.find('#edit_zone_name').val(el.data('zone_name'));
                    form.find('#edit_name').val(el.data('name'));
                    form.find('#edit_designation').val(el.data('designation'));
                    form.find('#edit_position').val(el.data('position'));
                    form.find('#edit_contact').val(el.data('contact'));
                    form.find('#edit_sort_order').val(el.data('sort_order'));
                });
            });
        })(jQuery);
    </script>
@endsection
