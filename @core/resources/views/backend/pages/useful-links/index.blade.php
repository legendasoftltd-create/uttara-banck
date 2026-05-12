@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/media-uploader.css') }}">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
        .link-logo-thumb { width: 80px; height: 50px; object-fit: contain; background: #f5f5f5; border: 1px solid #eee; border-radius: 4px; padding: 4px; }
        .link-logo-placeholder { width: 80px; height: 50px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 11px; }
    </style>
@endsection
@section('site-title')
    {{ __('Useful Links') }}
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
                            <h4 class="header-title">{{ __('Useful Links') }}</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.useful.links.new') }}" class="btn btn-primary btn-sm">
                                    <i class="ti-plus"></i> {{ __('Add New Link') }}
                                </a>
                                <a href="{{ route('admin.useful.links.page.settings') }}" class="btn btn-secondary btn-sm">
                                    <i class="ti-settings"></i> {{ __('Settings') }}
                                </a>
                            </div>
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

                        @if($all_links->isEmpty())
                            <div class="alert alert-info">{{ __('No useful links found. Add your first link.') }}</div>
                        @else
                        <ul class="nav nav-tabs" id="linkTab" role="tablist">
                            @php $i = 0; @endphp
                            @foreach($all_links as $lang_key => $links)
                                <li class="nav-item">
                                    <a class="nav-link @if($i == 0) active @endif"
                                       data-toggle="tab" href="#ltab_{{ $lang_key }}" role="tab">
                                        {{ get_language_by_slug($lang_key) }}
                                    </a>
                                </li>
                                @php $i++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40">
                            @php $j = 0; @endphp
                            @foreach($all_links as $lang_key => $links)
                                <div class="tab-pane fade @if($j == 0) show active @endif"
                                     id="ltab_{{ $lang_key }}" role="tabpanel">
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default" id="link_table_{{ $lang_key }}">
                                            <thead>
                                                <tr>
                                                    <th class="no-sort">
                                                        <input type="checkbox" class="all-checkbox">
                                                    </th>
                                                    <th>{{ __('Order') }}</th>
                                                    <th>{{ __('Logo') }}</th>
                                                    <th>{{ __('Title') }}</th>
                                                    <th>{{ __('URL') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($links as $link)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="bulk-checkbox" value="{{ $link->id }}">
                                                        </td>
                                                        <td>{{ $link->sort_order }}</td>
                                                        <td>
                                                            @if($link->image)
                                                                {!! render_image_markup_by_attachment_id($link->image, 'class="link-logo-thumb"') !!}
                                                            @else
                                                                <div class="link-logo-placeholder">{{ __('No Logo') }}</div>
                                                            @endif
                                                        </td>
                                                        <td>{{ $link->title }}</td>
                                                        <td>
                                                            <a href="{{ $link->url }}" target="_blank"
                                                               style="color:#007bff; font-size:13px; word-break:break-all;">
                                                                {{ Str::limit($link->url, 50) }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if($link->status === 'publish')
                                                                <span class="badge badge-success">{{ __('Published') }}</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ __('Draft') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.useful.links.edit', $link->id) }}"
                                                               class="btn btn-primary btn-sm">
                                                                <i class="ti-pencil"></i> {{ __('Edit') }}
                                                            </a>
                                                            <form action="{{ route('admin.useful.links.delete', $link->id) }}"
                                                                  method="post" style="display:inline-block;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('{{ __('Are you sure?') }}')">
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

    <form id="bulk_action_form" action="{{ route('admin.useful.links.bulk.action') }}" method="post">
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
            $('table[id^="link_table_"]').DataTable({
                responsive: true,
                language: { paginate: { previous: "<i class='ti-angle-left'>", next: "<i class='ti-angle-right'>" } },
                columnDefs: [{ orderable: false, targets: [0, 6] }],
                order: [[1, 'asc']]
            });
            $('.all-checkbox').on('change', function () {
                $(this).closest('.tab-pane').find('.bulk-checkbox').prop('checked', $(this).is(':checked'));
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
                ids.forEach(function (id) {
                    $('#bulk_ids').append('<input type="hidden" name="ids[]" value="' + id + '">');
                });
                $('#bulk_action_form').submit();
            });
        });
    </script>
@endsection
