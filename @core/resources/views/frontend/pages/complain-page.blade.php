@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Complaint Management Cell')}}
@endsection
@section('page-title')
    {{__('Complaint Management Cell')}}
@endsection
@section('content')
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Modern Complaint Page Styles */
        .complaint-page-wrapper {
            background-color: #f8fafc;
            font-family: 'Outfit', 'Inter', sans-serif;
            color: #334155;
        }

        /* Redesigned Complaint Info Card CSS */
        .complaint-info-card-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 40px;
        }

        .complaint-info-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #008649; /* Bank green theme */
            width: 100%;
            max-width: 580px;
            padding: 35px;
            box-sizing: border-box;
            text-align: left;
        }

        .complaint-info-card .info-card-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
            margin: 0 0 20px 0;
            letter-spacing: 1px;
        }

        .complaint-info-card .info-card-divider {
            height: 1px;
            background-color: #e2e8f0;
            width: 80%;
            margin: 0 auto 25px auto;
        }

        .complaint-info-card .info-card-body {
            display: flex;
            flex-direction: column;
        }

        .complaint-info-card .info-item-row {
            display: flex;
            align-items: center;
            padding: 15px 0;
            position: relative;
        }

        .complaint-info-card .info-item-row:not(:last-child) {
            border-bottom: 1px dotted #cbd5e1;
        }

        .complaint-info-card .info-icon-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #eff6ff; /* light blue bg */
            color: #008649; /* bank theme green */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .complaint-info-card .info-texts {
            display: flex;
            flex-direction: column;
        }

        .complaint-info-card .info-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .complaint-info-card .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            word-break: break-all;
        }

        .complaint-info-card .link-value {
            color: #0f172a;
            text-decoration: none;
            transition: color 0.2s;
        }

        .complaint-info-card .link-value:hover {
            color: #008649;
        }

        @media (max-width: 575px) {
            .complaint-info-card {
                padding: 20px;
            }
            .complaint-info-card .info-icon-circle {
                margin-right: 15px;
            }
            .complaint-info-card .info-value {
                font-size: 14px;
            }
        }
        
        .complaint-section-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 8px;
        }


        /* Central Cell Card Container */
        .central-cell-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-bottom: 40px;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        /* Background water mark graphic */
        .central-cell-container::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(0,98,39,0.03) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .central-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .member-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            border-top: 4px solid #006227;
            overflow: hidden;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-color: #006227;
        }

        .member-card-body {
            padding: 24px 20px 20px 20px;
        }

        .member-name {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .member-designation {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 2px;
        }

        .member-position {
            font-size: 11px;
            font-weight: 500;
            color: #006227;
            background-color: rgba(0, 98, 39, 0.08);
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            margin-bottom: 12px;
        }

        .member-contacts {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            text-align: left;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
            margin-top: 10px;
        }

        .contact-item {
            margin-bottom: 4px;
            word-break: break-all;
        }

        .contact-item strong {
            color: #334155;
        }

        /* Zonal Cell Container */
        .zonal-cell-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-bottom: 40px;
            border: 1px solid #e2e8f0;
        }

        /* Custom Tabs Styling */
        .zonal-tabs-wrapper {
            margin-bottom: 25px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .zonal-tabs-list.nav-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
            border-bottom: none;
        }

        .zonal-tab-item {
            margin: 0;
        }

        .zonal-tab-link.nav-link {
            display: inline-block;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            background-color: #f1f5f9;
            border-radius: 6px;
            border: 1px solid transparent !important;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .zonal-tab-link.nav-link:hover {
            background-color: #e2e8f0;
            color: #006227;
            text-decoration: none;
            border-color: transparent !important;
        }

        .zonal-tab-link.nav-link.active {
            background-color: #006227 !important;
            color: #ffffff !important;
            border-color: #006227 !important;
        }

        /* Zonal Members Grid */
        .zonal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .zonal-member-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #006227;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .zonal-member-card:hover {
            border-color: #006227;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        .zonal-member-info {
            flex-grow: 1;
        }

        .zonal-member-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .zonal-member-designation {
            font-size: 11px;
            font-weight: 600;
            color: #006227;
            margin-bottom: 2px;
        }

        .zonal-member-position {
            font-size: 11px;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 8px;
        }

        .zonal-member-contacts {
            font-size: 11px;
            color: #475569;
            line-height: 1.4;
            border-top: 1px solid #f1f5f9;
            padding-top: 6px;
            text-align: center;
            width: 100%;
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
            height: auto;
            color: #334155;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
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
            .central-cell-container, .zonal-cell-container {
                padding: 20px;
            }
        }
    </style>

    <div class="complaint-page-wrapper padding-bottom-120 padding-top-80">
        <div class="container py-5">

            {{-- Central Customer Service & Complaint Management Cell --}}
            <div class="central-cell-container">
                <h4 class="complaint-section-title text-center">{{__('Central Customer Service & Complaint Management Cell')}}</h4>
                <div class="complaint-info-card-wrapper">
                    <div class="complaint-info-card">
                        <h4 class="info-card-title">{{ __('COMPLAINT CELL') }}</h4>
                        <div class="info-card-divider"></div>
                        
                        <div class="info-card-body">
                            <!-- Bank Name -->
                            <div class="info-item-row">
                                <div class="info-icon-circle">
                                    <!-- Bank Icon SVG -->
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                        <path d="M4 10h3v7H4zm6.5 0h3v7h-3zM2 19h20v3H2zm15-9h3v7h-3zm-5-9L2 6v2h20V6z"/>
                                    </svg>
                                </div>
                                <div class="info-texts">
                                    <span class="info-label">{{ __('BANK NAME') }}</span>
                                    <span class="info-value">{{ get_static_option('complaint_cell_bank_name') }}</span>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            @if(!empty(get_static_option('complaint_cell_email')))
                                <div class="info-item-row">
                                    <div class="info-icon-circle">
                                        <!-- Email Icon SVG -->
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                        </svg>
                                    </div>
                                    <div class="info-texts">
                                        <span class="info-label">{{ __('EMAIL OF COMPLAIN CELL') }}</span>
                                        <a href="mailto:{{ get_static_option('complaint_cell_email') }}" class="info-value link-value">
                                            {{ get_static_option('complaint_cell_email') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Phone -->
                            @if(!empty(get_static_option('complaint_cell_phone')))
                                <div class="info-item-row">
                                    <div class="info-icon-circle">
                                        <!-- Phone Icon SVG -->
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                            <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.57-.35-.11-.74-.03-1.01.24l-1.57 1.58c-2.83-1.44-5.15-3.75-6.59-6.59l1.58-1.57c.27-.27.35-.66.24-1.01-0.38-1.11-.58-2.3-.58-3.53 0-.55-.45-1-1-1H4.48C3.93 3 3.5 3.44 3.5 4c0 9.39 7.61 17 17 17 0 .55.44 1 1 1h3.51c.55 0 .99-.44.99-1v-5.62c0-.55-.44-1-1-1z"/>
                                        </svg>
                                    </div>
                                    <div class="info-texts">
                                        <span class="info-label">{{ __('PHONE NO OF COMPLAIN CELL') }}</span>
                                        <a href="tel:{{ get_static_option('complaint_cell_phone') }}" class="info-value link-value">
                                            {{ get_static_option('complaint_cell_phone') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="central-grid">
                    @forelse($central_members as $member)
                        <div class="member-card">
                            <div class="member-card-body">
                                <h5 class="member-name">{{$member->name}}</h5>
                                @if(!empty($member->designation))
                                    <div class="member-designation">{{$member->designation}}</div>
                                @endif
                                @if(!empty($member->position))
                                    <div class="member-position">{{$member->position}}</div>
                                @endif
                                
                                <div class="member-contacts">
                                    @php
                                        $contacts = explode("\n", $member->contact);
                                    @endphp
                                    @foreach($contacts as $contact)
                                        @if(trim($contact))
                                            @php
                                                $parts = explode(':', $contact, 2);
                                                $label = '';
                                                $value = '';
                                                if (count($parts) == 2) {
                                                    $label = trim($parts[0]);
                                                    $value = trim($parts[1]);
                                                } else {
                                                    $trimmed = trim($contact);
                                                    if (is_numeric($trimmed) || strpos($trimmed, '01') === 0 || strpos($trimmed, '+88') === 0) {
                                                        $label = __('Mobile');
                                                        $value = $trimmed;
                                                    } else if (filter_var($trimmed, FILTER_VALIDATE_EMAIL) || strpos($trimmed, '@') !== false) {
                                                        $label = __('Email');
                                                        $value = $trimmed;
                                                    } else {
                                                        $value = $trimmed;
                                                    }
                                                }
                                            @endphp
                                            <div class="contact-item">
                                                @if(!empty($label))
                                                    <strong>{{ $label }}:</strong>
                                                @endif
                                                
                                                @if(filter_var($value, FILTER_VALIDATE_EMAIL) || strpos($value, '@') !== false)
                                                    <a href="mailto:{{ $value }}" style="color: #006227; font-weight: 600;">{{ $value }}</a>
                                                @elseif(preg_match('/[0-9\-\+\s]{5,}/', $value))
                                                    @php
                                                        $clean_phone = preg_replace('/[^0-9\+]/', '', $value);
                                                    @endphp
                                                    <a href="tel:{{ $clean_phone }}" style="color: #006227; font-weight: 600;">{{ $value }}</a>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">{{__('No information available')}}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Zonal Customer Service & Complaint Management Cell --}}
            <div class="zonal-cell-container">
                <h4 class="complaint-section-title text-center">{{__('Zonal Customer Service & Complaint Management Cell')}}</h4>

                @if($zonal_members->count())
                    <!-- Quick scroll links -->
                    <ul class="nav zonal-tabs-list zonal-quick-links" style="border-bottom: none; margin-bottom: 10px;">
                        @foreach($zonal_members as $zone_name => $members)
                            <li class="nav-item zonal-tab-item">
                                <a class="nav-link zonal-tab-link" href="#zone-{{$loop->index}}">
                                    {{ str_replace(' Zone', '', $zone_name) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                    <!-- Zonal sections stacked vertically -->
                    <div class="zonal-sections-list">
                        @foreach($zonal_members as $zone_name => $members)
                            <div class="zone-section" id="zone-{{$loop->index}}" style="scroll-margin-top: 100px; margin-bottom: 40px;">
                                <h5 class="zone-title" style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 15px; padding-bottom: 6px; border-bottom: 2px solid #006227; display: inline-block;">
                                    {{ $zone_name }}
                                </h5>
                                <div class="zonal-grid">
                                    @foreach($members as $member)
                                        <div class="zonal-member-card">
                                            <div class="zonal-member-info">
                                                <h5 class="zonal-member-name">{{$member->name}}</h5>
                                                @if(!empty($member->designation))
                                                    <div class="zonal-member-designation">{{$member->designation}}</div>
                                                @endif
                                                @if(!empty($member->position))
                                                    <div class="zonal-member-position">{{$member->position}}</div>
                                                @endif
                                                
                                                <div class="zonal-member-contacts">
                                                    @php
                                                        $contacts = explode("\n", $member->contact);
                                                    @endphp
                                                    @foreach($contacts as $contact)
                                                        @if(trim($contact))
                                                            @php
                                                                $parts = explode(':', $contact, 2);
                                                                $label = '';
                                                                $value = '';
                                                                if (count($parts) == 2) {
                                                                    $label = trim($parts[0]);
                                                                    $value = trim($parts[1]);
                                                                } else {
                                                                    $trimmed = trim($contact);
                                                                    if (is_numeric($trimmed) || strpos($trimmed, '01') === 0 || strpos($trimmed, '+88') === 0) {
                                                                        $label = __('Mobile');
                                                                        $value = $trimmed;
                                                                    } else if (filter_var($trimmed, FILTER_VALIDATE_EMAIL) || strpos($trimmed, '@') !== false) {
                                                                        $label = __('Email');
                                                                        $value = $trimmed;
                                                                    } else {
                                                                        $value = $trimmed;
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="contact-item">
                                                                @if(!empty($label))
                                                                    <strong>{{ $label }}:</strong>
                                                                @endif
                                                                
                                                                @if(filter_var($value, FILTER_VALIDATE_EMAIL) || strpos($value, '@') !== false)
                                                                    <a href="mailto:{{ $value }}" style="color: #006227; font-weight: 600;">{{ $value }}</a>
                                                                @elseif(preg_match('/[0-9\-\+\s]{5,}/', $value))
                                                                    @php
                                                                        $clean_phone = preg_replace('/[^0-9\+]/', '', $value);
                                                                    @endphp
                                                                    <a href="tel:{{ $clean_phone }}" style="color: #006227; font-weight: 600;">{{ $value }}</a>
                                                                @else
                                                                    {{ $value }}
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">{{__('No information available')}}</p>
                @endif
            </div>

            {{-- Send Complaint Call to Action --}}
            <div class="row justify-content-center mt-5">
                <div class="col-lg-12 text-center">
                    <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; padding: 40px;">
                        <h4 style="font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 15px;">{{ __('Have any complaints or feedback?') }}</h4>
                        
                        <a href="{{ route('frontend.complain.send') }}" class="btn-submit-complaint" style="display: inline-block; width: auto; padding: 12px 40px; text-decoration: none;">
                            {{ __('Send Complaint') }}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

