@extends('backend.admin-master')
@section('site-title')
    {{__('All Complaints')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Complaints')}}</h4>
                        <table class="table table-default">
                            <thead>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Mobile')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Division / Branch')}}</th>
                            <th>{{__('Nature of Complain')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @forelse($all_complaints as $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->full_name}}</td>
                                    <td>{{$data->mobile}}</td>
                                    <td>{{$data->email}}</td>
                                    <td>{{$data->concerned_division}} / {{$data->concerned_branch}}</td>
                                    <td>{{$data->nature_of_complain}}</td>
                                    <td>
                                        <span class="badge @if($data->status == 'resolved') badge-success @elseif($data->status == 'in_progress') badge-warning @else badge-secondary @endif">
                                            {{ucwords(str_replace('_',' ',$data->status))}}
                                        </span>
                                    </td>
                                    <td>{{$data->created_at->format('d M Y, h:i A')}}</td>
                                    <td>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#view_complaint_modal"
                                           class="btn btn-xs btn-primary btn-sm mb-3 mr-1 view_complaint_btn"
                                           data-id="{{$data->id}}"
                                           data-division="{{$data->concerned_division}}"
                                           data-branch="{{$data->concerned_branch}}"
                                           data-name="{{$data->full_name}}"
                                           data-address="{{$data->address}}"
                                           data-mobile="{{$data->mobile}}"
                                           data-email="{{$data->email}}"
                                           data-has_account="{{$data->has_account ? __('Yes') : __('No')}}"
                                           data-nature="{{$data->nature_of_complain}}"
                                           data-amount="{{$data->amount_involved}}"
                                           data-details="{{$data->details}}"
                                           data-suggestion="{{$data->suggestion}}"
                                           data-status="{{$data->status}}"
                                        >
                                            <i class="ti-eye"></i>
                                        </a>
                                        <x-delete-popover :url="route('admin.complaints.delete',$data->id)"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">{{__('No complaints found')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_complaint_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Complaint Details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr><th>{{__('Concerned Division')}}</th><td id="vc_division"></td></tr>
                        <tr><th>{{__('Concerned Branch')}}</th><td id="vc_branch"></td></tr>
                        <tr><th>{{__('Full Name')}}</th><td id="vc_name"></td></tr>
                        <tr><th>{{__('Address')}}</th><td id="vc_address"></td></tr>
                        <tr><th>{{__('Mobile/Phone')}}</th><td id="vc_mobile"></td></tr>
                        <tr><th>{{__('Email')}}</th><td id="vc_email"></td></tr>
                        <tr><th>{{__('Has Account with Uttara Bank?')}}</th><td id="vc_has_account"></td></tr>
                        <tr><th>{{__('Nature of Complain')}}</th><td id="vc_nature"></td></tr>
                        <tr><th>{{__('Amount Involved')}}</th><td id="vc_amount"></td></tr>
                        <tr><th>{{__('Details of Complaint')}}</th><td id="vc_details" style="white-space: pre-line;"></td></tr>
                        <tr><th>{{__('What they would like us to do')}}</th><td id="vc_suggestion" style="white-space: pre-line;"></td></tr>
                    </table>
                    <form action="{{route('admin.complaints.status.change')}}" method="post" class="form-inline">
                        @csrf
                        <input type="hidden" name="id" id="vc_status_id">
                        <div class="form-group mr-2">
                            <label class="mr-2 mb-0">{{__('Status')}}</label>
                            <select name="status" id="vc_status_select" class="form-control">
                                <option value="pending">{{__('Pending')}}</option>
                                <option value="in_progress">{{__('In Progress')}}</option>
                                <option value="resolved">{{__('Resolved')}}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('Update Status')}}</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function($){
            "use strict";
            $(document).ready(function () {
                $(document).on('click', '.view_complaint_btn', function () {
                    var el = $(this);
                    $('#vc_division').text(el.data('division'));
                    $('#vc_branch').text(el.data('branch'));
                    $('#vc_name').text(el.data('name'));
                    $('#vc_address').text(el.data('address'));
                    $('#vc_mobile').text(el.data('mobile'));
                    $('#vc_email').text(el.data('email'));
                    $('#vc_has_account').text(el.data('has_account'));
                    $('#vc_nature').text(el.data('nature'));
                    $('#vc_amount').text(el.data('amount'));
                    $('#vc_details').text(el.data('details'));
                    $('#vc_suggestion').text(el.data('suggestion'));
                    $('#vc_status_id').val(el.data('id'));
                    $('#vc_status_select').val(el.data('status'));
                });
            });
        })(jQuery);
    </script>
@endsection
