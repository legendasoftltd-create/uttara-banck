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
    .notice-page-section { padding: 50px 0 80px; }

    /* ── Filter bar ── */
    .year-filter-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin: 0 auto 25px;
        max-width: 1230px;
        width: 100%;
    }
    .year-filter-label {
        font-size: 15px;
        font-weight: 600;
        color: #333333;
        white-space: nowrap;
    }
    .year-filter-select {
        width: auto;
        min-width: 160px;
        padding: 8px 36px 8px 16px;
        font-size: 15px;
        font-weight: 600;
        color: #008649;
        border: 2px solid #008649;
        border-radius: 4px;
        background-color: transparent;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23008649' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        outline: none;
        box-shadow: none;
        transition: all 0.2s ease;
    }
    .year-filter-select:focus {
        border-color: #005a30;
        color: #005a30;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23005a30' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
    }
    .year-filter-select option {
        background: #ffffff;
        color: #333333;
        font-weight: 500;
        padding: 12px;
    }

    /* ── Table ── */
    .notice-table-wrap { overflow-x: auto; }
    .notice-table-wrap .btn-cell { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }
    .notice-table-wrap .btn-cell a.btn { width: auto; min-width: 80px; }

    .notice-empty { text-align: center; padding: 40px; color: #777; font-size: 15px; }
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

        {{-- ── Filter dropdown ── --}}
        <div class="year-filter-bar">
            <span class="year-filter-label">Filter by Year:</span>
            <select class="year-filter-select" onchange="window.location.href='{{ url()->current() }}?year='+this.value">
                @foreach($tab_years as $yr)
                <option value="{{ $yr }}" {{ $active_year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
                <option value="archive" {{ $active_year === 'archive' ? 'selected' : '' }}>Archive</option>
            </select>
        </div>

        {{-- ── Notice table ── --}}
        @if($all_notices->isEmpty())
            <div class="notice-empty">{{ __('No notices found.') }}</div>
        @else
        <div class="notice-table-wrap">
            <table width="100%" class="auction-table" cellspacing="0" cellpadding="5"
                   bordercolor="#DDDDDD" border="1" align="center"
                   style="border-collapse: collapse; max-width:1230px;">
                <thead>
                    <tr bgcolor="#008649">
                        <th class="text-center"><font color="#ffffff"><b>Sl No.</b></font></th>
                        <th class="text-center"><font color="#ffffff"><b>Title</b></font></th>
                        <th class="text-center"><font color="#ffffff"><b>Entry Date</b></font></th>
                        <th class="text-center"><font color="#ffffff"><b>Expiry Date</b></font></th>
                        <th class="text-center"><font color="#ffffff"><b>View</b></font></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_notices as $key => $notice)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $notice->title }}</td>
                        <td class="text-center">
                            {{ $notice->notice_date ? \Carbon\Carbon::parse($notice->notice_date)->format('F d, Y') : '-' }}
                        </td>
                        <td class="text-center">
                            {{ $notice->expiry_date ? \Carbon\Carbon::parse($notice->expiry_date)->format('F d, Y') : '-' }}
                        </td>
                        <td class="text-center">
                            @if($notice->image)
                            @php $noticeFile = get_attachment_image_by_id($notice->image); @endphp
                            <div class="btn-cell">
                                <a href="#" class="btn btn-view"
                                   data-toggle="modal"
                                   data-target="#noticeModal{{ $notice->id }}">View</a>
                                <a href="{{ $noticeFile['img_url'] ?? '#' }}" class="btn btn-view" download>Download</a>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── Per-notice modals ── --}}
        @foreach($all_notices as $notice)
        @if($notice->image)
        @php
            $noticeFile = get_attachment_image_by_id($notice->image);
            $noticeUrl  = $noticeFile['img_url'] ?? '';
            $noticePath = $noticeFile['path'] ?? '';
            $noticeExt  = strtolower(pathinfo($noticePath, PATHINFO_EXTENSION));
        @endphp
        <div class="modal fade" id="noticeModal{{ $notice->id }}" tabindex="-1"
             role="dialog" aria-labelledby="noticeModalLabel{{ $notice->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                <div class="modal-content" style="width:100%; margin:0 auto;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noticeModalLabel{{ $notice->id }}">
                            {{ $notice->title }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body scroll-modal-body">
                        @if($noticeExt === 'pdf')
                            <iframe src="{{ $noticeUrl }}" width="100%" height="600px" style="border:none;"></iframe>
                        @else
                            <div style="text-align:center; padding:16px;">
                                {!! render_image_markup_by_attachment_id($notice->image) !!}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="{{ $noticeUrl }}" class="btn btn-view" download>Download</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @endif

    </div>
</section>
@endsection

@section('script')
@endsection
