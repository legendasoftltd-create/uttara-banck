@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('notice_page_title') ?? __('Notice') }}
@endsection

@section('page-title')
    {{ get_static_option('notice_page_title') ?? __('Notice') }}
@endsection

@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('notice_page_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('notice_page_meta_tags') }}">
@endsection

@section('style')
<style>
    .notice-page-section {
        padding: 50px 0 80px;
    }

    /* ── Chevron breadcrumb year tabs ── */
    .notice-year-nav {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        flex-wrap: wrap;
        gap: 2px;
    }
    .notice-year-nav li a {
        display: block;
        padding: 10px 30px 10px 40px;
        background: #555;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%, 14px 50%);
        transition: background 0.2s;
        white-space: nowrap;
    }
    .notice-year-nav li:first-child a {
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
        padding-left: 22px;
    }
    .notice-year-nav li a:hover,
    .notice-year-nav li a.active {
        background: #222;
        color: #fff;
    }

    /* ── Column header ── */
    .notice-list-header {
        display: flex;
        justify-content: flex-end;
        padding: 6px 50px 6px 16px;
        margin-bottom: 2px;
    }
    .notice-list-header span {
        color: #e00;
        font-size: 14px;
        font-weight: 700;
    }

    /* ── Notice rows ── */
    .notice-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .notice-list-item {
        border-bottom: 1px solid #e5e5e5;
    }
    .notice-list-item:last-child {
        border-bottom: none;
    }
    .notice-row-trigger {
        display: flex;
        align-items: center;
        padding: 10px 8px 10px 0;
        cursor: pointer;
        gap: 8px;
    }
    .notice-row-label {
        flex: 1;
        color: #2e7d32;
        font-size: 14px;
        font-weight: 500;
        pointer-events: none;
    }
    .notice-expiry-col {
        min-width: 130px;
        text-align: right;
        color: #2e7d32;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        padding-right: 10px;
    }
    .notice-expiry-col.no-date { color: #777; }

    .notice-toggle-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #2e7d32;
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
        line-height: 1;
    }
    .notice-toggle-btn:hover { background: #1b5e20; }
    .notice-toggle-btn .chev {
        display: inline-block;
        transition: transform 0.25s;
    }
    .notice-toggle-btn.open .chev { transform: rotate(180deg); }

    /* ── Accordion body ── */
    .notice-accordion-body {
        display: none;
        padding: 18px 10px 22px;
        border-top: 1px solid #e5e5e5;
        background: #fafafa;
    }
    .notice-accordion-body.show { display: block; }
    .notice-img-wrap { text-align: center; margin-bottom: 16px; }
    .notice-img-wrap img { max-width: 100%; border: 1px solid #ccc; }
    .notice-body-text { font-size: 14px; line-height: 1.8; color: #333; }
    .notice-view-link { margin-top: 12px; text-align: right; }
    .notice-view-link a {
        color: #2e7d32; font-size: 13px; font-weight: 600; text-decoration: none;
    }
    .notice-view-link a:hover { text-decoration: underline; }

    .notice-empty {
        text-align: center; padding: 40px; color: #777; font-size: 15px;
    }
</style>
@endsection

@section('content')
<section class="notice-page-section">
    <div class="container">

        <div class="empty-height-50"></div>
        
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:700;">
                    {{ get_static_option('notice_page_title') ?? __('Notice') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>
        {{-- Page heading --}}

        <div style="position: relative;">
            <div class="auction-dropdown">
                <button type="button" onclick="showMenu(event)" class="auction-dropdown-button">
                    Select
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="auction-chevron" class="auction-chevron-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="auction-dropdown-content">
                    <a href="#" class="auction-dropdown-link">2026</a>
                    <a href="#" class="auction-dropdown-link">2025</a>
                    <a href="#" class="auction-dropdown-link">2024</a>
                </div>
            </div>
            @if($all_notices->isEmpty())
                <div class="notice-empty">{{ __('No notices found.') }}</div>
            @else
            <div style="overflow-x: auto;">
                <table width="100%" class="auction-table" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center" style="border-collapse: collapse; max-width:1230px;">
                    <thead>
                        <tr bgcolor="#008649">
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Sl
                                        No.</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Title</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Entry
                                        Date</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Expiry
                                        Date</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>View</b></font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_notices as $key => $notice)
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td>{{ $notice->title }} ({{ \Carbon\Carbon::parse($notice->notice_date)->format('F, d, Y') }})</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($notice->notice_date)->format('F, d, Y') }}</td>
                            <td class="text-center">{{ $notice->expiry_date ? \Carbon\Carbon::parse($notice->expiry_date)->format('F, d, Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Modal -->
        @foreach($all_notices as $notice)
        <div class="modal fade" id="exampleModalCenter" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"
                role="document" style="max-width: 100%;">
                <div class="modal-content"
                    style="background-color: #FFF; width: 100%; margin: 0 auto;">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalCenterTitle">{{$notice->title}}</h5>
                        <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body scroll-modal-body">
                        @if($notice->image)
                            @php
                                $file = get_attachment_image_by_id($notice->image);

                                $fileUrl = $file['img_url'] ?? '';
                                $filePath = $file['path'] ?? '';

                                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                                $isPdf = $extension === 'pdf';
                            @endphp

                            @if($isPdf)

                                {{-- Show PDF --}}
                                <iframe 
                                    src="{{ $fileUrl }}" 
                                    width="100%" 
                                    height="600px"
                                    style="border:none;">
                                </iframe>

                            @else

                                {{-- Show Image --}}
                                {!! render_image_markup_by_attachment_id($notice->image) !!}

                            @endif
                        @endif
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                        @if($notice->image)
                        <a href="{{ get_attachment_image_by_id($notice->image)['img_url'] }}"
                        type="button" class="btn btn-view"
                        download>Save File</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Year tabs --}}
        <!-- @if(!empty($tab_years))
        <ul class="notice-year-nav">
           @foreach($tab_years as $yr)
               <li>
                   <a href="{{ route('frontend.notice') }}?year={{ $yr }}"
                      class="{{ (string)$active_year === (string)$yr && $selected_year !== 'archive' ? 'active' : '' }}">
                        {{ $yr }}
                   </a>
                </li>
            @endforeach
            <li>
                <a href="{{ route('frontend.notice') }}?year=archive"
                  class="{{ $selected_year === 'archive' ? 'active' : '' }}">
                   {{ __('ARCHIVE') }}
                </a>
           </li>
        </ul>
        @endif -->

        {{-- Expiry Date header --}}
        <!--<div class="notice-list-header">-->
        <!--    <span>{{ __('Expiry Date') }}</span>-->
        <!--</div>-->

        {{-- List --}}
        <!--@if($all_notices->isEmpty())-->
        <!--    <div class="notice-empty">{{ __('No notices found.') }}</div>-->
        <!--@else-->
        <!--<ul class="notice-list">-->
        <!--    @foreach($all_notices as $notice)-->
        <!--    <li class="notice-list-item">-->
        <!--        <div class="notice-row-trigger" onclick="toggleNotice({{ $notice->id }})">-->
        <!--            <span class="notice-row-label">-->
        <!--                {{ __('Notice') }} ({{ \Carbon\Carbon::parse($notice->notice_date)->format('F, d, Y') }})-->
        <!--            </span>-->
        <!--            <span class="notice-expiry-col {{ $notice->expiry_date ? '' : 'no-date' }}">-->
        <!--                {{ $notice->expiry_date ? \Carbon\Carbon::parse($notice->expiry_date)->format('F, d, Y') : '-' }}-->
        <!--            </span>-->
        <!--            <button class="notice-toggle-btn" id="nbtn-{{ $notice->id }}" aria-label="Toggle">-->
        <!--                <span class="chev">&#8964;</span>-->
        <!--            </button>-->
        <!--        </div>-->

        <!--        <div class="notice-accordion-body" id="nbody-{{ $notice->id }}">-->
        <!--            @if($notice->image)-->
        <!--                <div class="notice-img-wrap">-->
        <!--                    {!! render_image_markup_by_attachment_id($notice->image) !!}-->
        <!--                </div>-->
        <!--            @endif-->
        <!--            @if($notice->description)-->
        <!--                <div class="notice-body-text">-->
        <!--                    {!! $notice->description !!}-->
        <!--                </div>-->
        <!--            @endif-->
        <!--            <div class="notice-view-link">-->
        <!--                <a href="{{ route('frontend.notice.single', $notice->slug) }}">-->
        <!--                    {{ __('View Full Notice') }} &rarr;-->
        <!--                </a>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </li>-->
        <!--    @endforeach-->
        <!--</ul>-->
        <!--@endif-->

    </div>
</section>
@endsection

@section('script')
<script>
    function toggleNotice(id) {
        var body = document.getElementById('nbody-' + id);
        var btn  = document.getElementById('nbtn-'  + id);
        if (!body) return;
        var wasOpen = body.classList.contains('show');
        document.querySelectorAll('.notice-accordion-body.show').forEach(function(el){ el.classList.remove('show'); });
        document.querySelectorAll('.notice-toggle-btn.open').forEach(function(el){ el.classList.remove('open'); });
        if (!wasOpen) {
            body.classList.add('show');
            btn.classList.add('open');
        }
    }
</script>
@endsection
