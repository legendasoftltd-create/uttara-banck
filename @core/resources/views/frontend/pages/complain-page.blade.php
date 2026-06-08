@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Complaint Management Cell')}}
@endsection
@section('page-title')
    {{__('Complaint Management Cell')}}
@endsection
@section('content')
    <div class="contact-section padding-bottom-120 padding-top-120">
        <div class="container">

            {{-- Central Customer Service & Complaint Management Cell --}}
            <div class="row margin-bottom-50">
                <div class="col-md-12">
                    <div class="section-title margin-bottom-30">
                        <h4 class="title">{{__('Central Customer Service & Complaint Management Cell')}}</h4>
                    </div>
                    <p>
                        <strong>{{get_static_option('complaint_cell_bank_name')}}</strong><br>
                        @if(!empty(get_static_option('complaint_cell_email')))
                            {{__('Email')}}: {{get_static_option('complaint_cell_email')}}<br>
                        @endif
                        @if(!empty(get_static_option('complaint_cell_phone')))
                            {{__('Phone')}}: {{get_static_option('complaint_cell_phone')}}
                        @endif
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Designation')}}</th>
                                <th>{{__('Position')}}</th>
                                <th>{{__('Contact')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($central_members as $member)
                                <tr>
                                    <td>{{$member->name}}</td>
                                    <td>{{$member->designation}}</td>
                                    <td>{{$member->position}}</td>
                                    <td>{!! nl2br(e($member->contact)) !!}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">{{__('No information available')}}</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Zonal Customer Service & Complaint Management Cell --}}
            <div class="row margin-bottom-50">
                <div class="col-md-12">
                    <div class="section-title margin-bottom-30">
                        <h4 class="title">{{__('Zonal Customer Service & Complaint Management Cell')}}</h4>
                    </div>

                    @if($zonal_members->count())
                        <ul class="nav nav-tabs margin-bottom-30" role="tablist">
                            @foreach($zonal_members as $zone_name => $members)
                                <li class="nav-item">
                                    <a class="nav-link {{$loop->first ? 'active' : ''}}" data-toggle="tab" href="#zone-{{$loop->index}}" role="tab">{{$zone_name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($zonal_members as $zone_name => $members)
                                <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}" id="zone-{{$loop->index}}" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Designation')}}</th>
                                                <th>{{__('Position')}}</th>
                                                <th>{{__('Contact')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($members as $member)
                                                <tr>
                                                    <td>{{$member->name}}</td>
                                                    <td>{{$member->designation}}</td>
                                                    <td>{{$member->position}}</td>
                                                    <td>{!! nl2br(e($member->contact)) !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>{{__('No information available')}}</p>
                    @endif
                </div>
            </div>

            {{-- Send Complaint --}}
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="contact-info">
                        <div class="section-title text-center margin-bottom-30">
                            <h4 class="title">{{__('Send Complaint')}}</h4>
                        </div>
                        @include('backend.partials.message')
                        @include('backend.partials.error')
                        <form action="{{route('frontend.complain.submit')}}" method="post" class="contact-page-form">
                            @csrf
                            <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="concerned_division">{{__('Concerned Division')}}</label>
                                        <select name="concerned_division" id="concerned_division" class="form-control">
                                            <option value="">{{__('Select Division')}}</option>
                                            @foreach($all_divisions as $division)
                                                <option value="{{$division}}">{{$division}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="concerned_branch">{{__('Concerned Branch')}}</label>
                                        <select name="concerned_branch" id="concerned_branch" class="form-control">
                                            <option value="">{{__('Select Branch')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h5 class="margin-top-30 margin-bottom-20">{{__('Complainant Information')}}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">{{__('Full Name')}} *</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">{{__('Address')}}</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">{{__('Mobile/Phone')}} *</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{__('Email')}}</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" name="has_account" id="has_account" value="1">
                                        <label class="form-check-label" for="has_account">{{__('Do you have an account with Uttara Bank PLC.?')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nature_of_complain">{{__('Nature of Complain')}}</label>
                                        <input type="text" name="nature_of_complain" id="nature_of_complain" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_involved">{{__('Amount Involved (if any)')}}</label>
                                        <input type="text" name="amount_involved" id="amount_involved" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="details">{{__('Details of Complaint')}} *</label>
                                        <textarea name="details" id="details" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="suggestion">{{__('What would you like us to do?')}}</label>
                                        <textarea name="suggestion" id="suggestion" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-wrapper">
                                <button type="submit" class="boxed-btn reverse-color">{{__('Submit Complaint')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    @include('frontend.partials.google-captcha')
    <script>
        (function ($) {
            "use strict";
            $(document).on('change', '#concerned_division', function () {
                var division = $(this).val();
                var $branch = $('#concerned_branch');
                $branch.html('<option value="">{{__('Select Branch')}}</option>');
                if (division) {
                    $.ajax({
                        url: '{{url('/'.(get_static_option('complain_page_slug') ?? 'complain').'/branches')}}/' + division,
                        type: 'GET',
                        success: function (branches) {
                            $.each(branches, function (i, branch) {
                                $branch.append('<option value="' + branch.name + '">' + branch.name + '</option>');
                            });
                        }
                    });
                }
            });
        })(jQuery);
    </script>
@endsection
