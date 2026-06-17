@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Submit Your Complaint')}}
@endsection
@section('page-title')
    {{__('Submit Your Complaint')}}
@endsection
@section('content')
    <style>
        /* Modern Complaint Page Styles */
        .complaint-page-wrapper {
            background-color: #f8fafc;
            font-family: 'Outfit', 'Inter', sans-serif;
            color: #334155;
        }

        /* Complaint Form Container */
        .complaint-form-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            padding: 40px;
            margin-top: 20px;
        }

        .form-main-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .form-step-title {
            font-size: 14px;
            font-weight: 700;
            color: #006227;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 6px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
            padding: 10px 14px;
            height: 46px !important;
            color: #334155;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        textarea.form-control {
            height: auto !important;
        }

        .form-control:focus {
            border-color: #006227;
            box-shadow: 0 0 0 3px rgba(0, 98, 39, 0.15);
            outline: 0;
        }

        .form-check-label {
            font-size: 13px;
            color: #334155;
            font-weight: 500;
            cursor: pointer;
        }

        .form-check-input {
            margin-top: 4px;
        }

        .btn-submit-complaint {
            background-color: #006227;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit-complaint:hover {
            background-color: #004018;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 98, 39, 0.2);
            color: #ffffff;
        }

        .btn-submit-complaint:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .complaint-form-container {
                padding: 24px;
            }
        }
    </style>

    <div class="complaint-page-wrapper padding-bottom-120 padding-top-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="complaint-form-container">
                        <h4 class="form-main-title">{{__('Submit Your Complaint')}}</h4>
                        
                        @include('backend.partials.message')
                        @include('backend.partials.error')
                        
                        <form action="{{route('frontend.complain.submit')}}" method="post" class="contact-page-form">
                            @csrf
                            <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            
                            <!-- Step 1 -->
                            <div class="form-step-title">{{__('Step 1: Select Division & Branch')}}</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="concerned_division">{{__('Division')}}</label>
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

                            <!-- Step 2 -->
                            <div class="form-step-title">{{__('Step 2: Personal Details')}}</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">{{__('Full Name')}} *</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control" placeholder="{{__('Enter your full name')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">{{__('Address')}}</label>
                                        <input type="text" name="address" id="address" class="form-control" placeholder="{{__('Enter your address')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">{{__('Mobile/Phone')}} *</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="{{__('Enter your phone number')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{__('Email')}}</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="{{__('Enter your email address')}}">
                                    </div>
                                </div>
                                <div class="col-md-12 my-2">
                                    <div class="form-group form-check" style="display: flex; align-items: center; gap: 8px; padding-left: 0;">
                                        <input type="checkbox" class="form-check-input" name="has_account" id="has_account" value="1" style="width: 18px; height: 18px; margin: 0; cursor: pointer; position: relative; opacity: 1; -webkit-appearance: checkbox; -moz-appearance: checkbox; appearance: checkbox;">
                                        <label class="form-check-label" for="has_account" style="margin: 0; cursor: pointer; font-size: 14px; font-weight: 500; color: #334155; user-select: none;">{{__('Do you have an account with Uttara Bank PLC.?')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-12" id="account_number_wrapper" style="display: none; transition: all 0.3s ease;">
                                    <div class="form-group">
                                        <label for="account_number">{{__('Account Number/Credit Card Number')}} *</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control" placeholder="{{__('Enter Account or Credit Card Number')}}">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="form-step-title">{{__('Step 3: Complaint Information')}}</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nature_of_complain">{{__('Nature of Complaint')}}</label>
                                        <select name="nature_of_complain" id="nature_of_complain" class="form-control">
                                            <option value="">{{ __('Select Nature of Complaint') }}</option>
                                            <option value="Apps Banking">Apps Banking</option>
                                            <option value="Bank Guarantee">Bank Guarantee</option>
                                            <option value="Cards">Cards</option>
                                            <option value="Cheque Forgery">Cheque Forgery</option>
                                            <option value="Clearing">Clearing</option>
                                            <option value="Debit card or credit card or atm card">Debit card or credit card or atm card</option>
                                            <option value="export related">export related</option>
                                            <option value="fees and charges">fees and charges</option>
                                            <option value="foreign trade bill">foreign trade bill</option>
                                            <option value="general banking">general banking</option>
                                            <option value="import bill (foreign)">import bill (foreign)</option>
                                            <option value="import bill(local)">import bill(local)</option>
                                            <option value="internet banking">internet banking</option>
                                            <option value="legal">legal</option>
                                            <option value="notice">notice</option>
                                            <option value="loans and advances">loans and advances</option>
                                            <option value="local trade bill">local trade bill</option>
                                            <option value="miscellaneous">miscellaneous</option>
                                            <option value="mobile banking">mobile banking</option>
                                            <option value="notes and coins">notes and coins</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_involved">{{__('Amount Involved (if any)')}}</label>
                                        <input type="text" name="amount_involved" id="amount_involved" class="form-control" placeholder="{{__('Amount Involved')}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="details">{{__('Details of Complaint')}} *</label>
                                        <textarea name="details" id="details" class="form-control" rows="5" placeholder="{{__('Explain details of your complaint here...')}}" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="suggestion">{{__('What would you like us to do?')}}</label>
                                        <textarea name="suggestion" id="suggestion" class="form-control" rows="3" placeholder="{{__('Suggestions or requested actions...')}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="btn-wrapper mt-4">
                                <button type="submit" class="btn-submit-complaint">{{__('Submit Complaint')}}</button>
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

            $(document).on('change', '#has_account', function () {
                if ($(this).is(':checked')) {
                    $('#account_number_wrapper').slideDown();
                    $('#account_number').attr('required', true);
                } else {
                    $('#account_number_wrapper').slideUp();
                    $('#account_number').removeAttr('required').val('');
                }
            });
        })(jQuery);
    </script>
@endsection
