@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
@endsection
@section('page-title')
    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('tender_page_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('tender_page_meta_tags') }}">
@endsection

@section('style')
<style>
    .tender-page-section { padding: 50px 0 80px; }

    /* ── Chevron breadcrumb year tabs ── */
    .tender-year-nav {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        flex-wrap: wrap;
        gap: 2px;
    }
    .tender-year-nav li a {
        display: block;
        padding: 10px 30px 10px 40px;
        background: #888;
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
    .tender-year-nav li:first-child a {
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
        padding-left: 22px;
    }
    .tender-year-nav li a:hover { background: #555; }
    .tender-year-nav li a.active { background: #008649; color: #fff; }

    /* ── Table ── */
    .tender-table-wrap { overflow-x: auto; }

    .tender-empty { text-align: center; padding: 40px; color: #777; font-size: 15px; }
</style>
@endsection

@section('content')
<section class="tender-page-section">
    <div class="container">
        <div class="empty-height-50"></div>

        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:500;">
                    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>

        {{-- ── Year chevron tabs ── --}}
        <ul class="tender-year-nav">
            @foreach($tab_years as $yr)
            <li>
                <a href="{{ url()->current() }}?year={{ $yr }}"
                   class="{{ $active_year == $yr ? 'active' : '' }}">
                    {{ $yr }}
                </a>
            </li>
            @endforeach
            <li>
                <a href="{{ url()->current() }}?year=archive"
                   class="{{ $active_year === 'archive' ? 'active' : '' }}">
                    Archive
                </a>
            </li>
        </ul>

        {{-- ── Tender table ── --}}
        @if($all_tenders->isEmpty())
            <div class="tender-empty">{{ __('No tenders found.') }}</div>
        @else
        <div class="tender-table-wrap">
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
                    @foreach($all_tenders as $key => $tender)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $tender->title }}</td>
                        <td class="text-center">
                            {{ $tender->notice_date ? \Carbon\Carbon::parse($tender->notice_date)->format('F d, Y') : '-' }}
                        </td>
                        <td class="text-center">
                            {{ $tender->expiry_date ? \Carbon\Carbon::parse($tender->expiry_date)->format('F d, Y') : '-' }}
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-view"
                               data-toggle="modal"
                               data-target="#tenderModal{{ $tender->id }}">View</a>
                            <a href="{{ $tender->file }}" class="btn btn-view" download>Download</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── Per-tender modals ── --}}
        @foreach($all_tenders as $tender)
        <div class="modal fade" id="tenderModal{{ $tender->id }}" tabindex="-1"
             role="dialog" aria-labelledby="tenderModalLabel{{ $tender->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                <div class="modal-content" style="width:100%; margin:0 auto;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tenderModalLabel{{ $tender->id }}">
                            {{ $tender->title }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body scroll-modal-body">
                        @if($tender->file)
                            @php $ext = strtolower(pathinfo($tender->file, PATHINFO_EXTENSION)); @endphp
                            @if($ext === 'pdf')
                                <iframe src="{{ asset('assets/uploads/tenders/' . basename($tender->file)) }}"
                                        width="100%" height="600px" style="border:none;"></iframe>
                            @else
                                <div style="text-align:center; padding:16px;">
                                    <img src="{{ $tender->file }}" alt="{{ $tender->title }}"
                                         style="max-width:100%; border:1px solid #ccc;">
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        @if($tender->file)
                            <a href="{{ $tender->file }}" class="btn btn-view" download>Download</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>
</section>
@endsection

@section('script')
@endsection
