@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
    </style>
@endsection
@section('site-title')
    {{ __('All Auction Notices') }}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">{{ __('All Auction Notices') }}</h4>
                            <a href="{{ route('admin.auction.new') }}" class="btn btn-primary btn-sm">
                                <i class="ti-plus"></i> {{ __('Add New') }}
                            </a>
                        </div>

                        <div class="bulk-delete-wrapper mb-3">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value="">{{ __('Bulk Action') }}</option>
                                    <option value="delete">{{ __('Delete') }}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{ __('Apply') }}</button>
                            </div>
                        </div>

                        @if($all_auctions->isEmpty())
                            <div class="alert alert-info">{{ __('No auction notices found.') }}</div>
                        @else
                        <ul class="nav nav-tabs" id="auctionTab" role="tablist">
                            @php $i = 0; @endphp
                            @foreach($all_auctions as $lang_key => $auctions)
                                <li class="nav-item">
                                    <a class="nav-link @if($i == 0) active @endif" data-toggle="tab" href="#tab_{{ $lang_key }}" role="tab">
                                        {{ get_language_by_slug($lang_key) }}
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40">
                            @php $j = 0; @endphp
                            @foreach($all_auctions as $lang_key => $auctions)
                                <div class="tab-pane fade @if($j == 0) show active @endif" id="tab_{{ $lang_key }}" role="tabpanel">
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default" id="auction_table_{{ $lang_key }}">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">
                                                        <div class="mark-all-checkbox">
                                                            <input type="checkbox" class="all-checkbox">
                                                        </div>
                                                    </th>
                                                    <th>{{ __('ID') }}</th>
                                                    <th>{{ __('Title') }}</th>
                                                    <th>{{ __('Notice Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($auctions as $auction)
                                                    <tr>
                                                        <td>
                                                            <div class="bulk-checkbox-wrapper">
                                                                <input type="checkbox" class="bulk-checkbox" value="{{ $auction->id }}">
                                                            </div>
                                                        </td>
                                                        <td>{{ $auction->id }}</td>
                                                        <td>{{ $auction->title }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($auction->notice_date)->format('M d, Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($auction->expiry_date)->format('M d, Y') }}</td>
                                                        <td>
                                                            @if($auction->status === 'publish')
                                                                <span class="badge badge-success">{{ __('Published') }}</span>
                                                            @elseif($auction->status === 'archive')
                                                                <span class="badge badge-warning">{{ __('Archive') }}</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ __('Draft') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.auction.edit', $auction->id) }}" class="btn btn-primary btn-sm">
                                                                <i class="ti-pencil"></i> {{ __('Edit') }}
                                                            </a>
                                                            <form action="{{ route('admin.auction.delete', $auction->id) }}" method="post" style="display:inline-block;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                                    <i class="ti-trash"></i> {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @php $j++; @endphp
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="bulk_action_form" action="{{ route('admin.auction.bulk.action') }}" method="post">
        @csrf
        <input type="hidden" name="action" id="bulk_action_value">
        <div id="bulk_ids"></div>
    </form>
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('table[id^="auction_table_"]').DataTable({ responsive: true, language: { paginate: { previous: "<i class='ti-angle-left'>", next: "<i class='ti-angle-right'>" } }, columnDefs: [{ orderable: false, targets: [0, 6] }] });

            $('.all-checkbox').on('change', function () {
                var checked = $(this).is(':checked');
                $(this).closest('.tab-pane').find('.bulk-checkbox').prop('checked', checked);
            });

            $('#bulk_delete_btn').on('click', function () {
                var action = $('#bulk_option').val();
                if (!action) { alert('{{ __('Please select a bulk action') }}'); return; }
                var ids = [];
                $('.bulk-checkbox:checked').each(function () { ids.push($(this).val()); });
                if (ids.length === 0) { alert('{{ __('Please select at least one item') }}'); return; }
                if (!confirm('{{ __('Are you sure?') }}')) return;
                $('#bulk_action_value').val(action);
                $('#bulk_ids').html('');
                ids.forEach(function (id) { $('#bulk_ids').append('<input type="hidden" name="ids[]" value="' + id + '">'); });
                $('#bulk_action_form').submit();
            });
        });
    </script>
@endsection
