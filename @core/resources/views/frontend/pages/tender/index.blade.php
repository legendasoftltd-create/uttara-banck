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

    /* ── Filter bar ── */
    .year-filter-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 18px;
    }
    .year-filter-label {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }
    .year-filter-select {
        padding: 7px 32px 7px 12px;
        font-size: 14px;
        font-weight: 600;
        color: #008649;
        border: 2px solid #008649;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23008649' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        outline: none;
        transition: border-color 0.2s;
    }
    .year-filter-select:focus { border-color: #005a30; }

    /* ── Table ── */
    .tender-table-wrap { overflow-x: auto; }
    .tender-table-wrap .btn-cell { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }
    .tender-table-wrap .btn-cell a.btn { width: auto; min-width: 80px; }

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

        {{-- ── Filter dropdown ── --}}
        <div class="year-filter-bar">
            <span class="year-filter-label">Filter:</span>
            <select class="year-filter-select" onchange="window.location.href='{{ url()->current() }}?year='+this.value">
                @foreach($tab_years as $yr)
                <option value="{{ $yr }}" {{ $active_year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
                <option value="archive" {{ $active_year === 'archive' ? 'selected' : '' }}>Archive</option>
            </select>
        </div>

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
                            <div class="btn-cell">
                                <a href="#" class="btn btn-view"
                                   data-toggle="modal"
                                   data-target="#tenderModal{{ $tender->id }}">View</a>
                                <a href="{{ $tender->file }}" class="btn btn-view" download>Download</a>
                            </div>
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
