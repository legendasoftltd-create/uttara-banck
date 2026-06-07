@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
        }
    </style>
@endsection
@section('site-title')
    {{__('All Exchange Rates')}}
@endsection
@section('content')
    <div class="col-lg-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between mb-4">
                            <h4 class="header-title">{{__('All Exchange Rates')}}</h4>
                            <a href="{{route('admin.exchange.rate.new')}}" class="btn btn-primary">{{__('Add New Exchange Rate')}}</a>
                        </div>

                        <div class="bulk-delete-wrapper">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value="">{{__('Bulk Action')}}</option>
                                    <option value="delete">{{__('Delete')}}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                            </div>
                        </div>

                        <div class="table-wrap table-responsive">
                            <table class="table table-default" id="all_exchange_rates_table">
                                <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="mark-all-checkbox">
                                            <input type="checkbox" class="all-checkbox">
                                        </div>
                                    </th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Items')}}</th>
                                    <th>{{__('PDF')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_exchange_rates as $rate)
                                    <tr>
                                        <td>
                                            <div class="bulk-checkbox-wrapper">
                                                <input type="checkbox" class="bulk-checkbox" value="{{$rate->id}}">
                                            </div>
                                        </td>
                                        <td>{{$rate->id}}</td>
                                        <td>
                                            @php $items = $rate->items ?? []; @endphp
                                            @if(count($items))
                                                @foreach($items as $i => $item)
                                                    <span class="d-block">
                                                        {{$item['currency_name'] ?? ''}} —
                                                        Buy: {{number_format($item['buying'] ?? 0, 2)}} /
                                                        Sell: {{number_format($item['selling'] ?? 0, 2)}}
                                                        @if($item['date'] ?? null)
                                                            <small class="text-muted">({{ \Carbon\Carbon::parse($item['date'])->format('d M, Y') }})</small>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">{{__('No items')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($rate->pdf)
                                                <a href="{{asset('assets/uploads/exchange-rates/' . $rate->pdf)}}" target="_blank" class="btn btn-info btn-xs mb-3 mr-1">
                                                    <i class="ti-file"></i> {{__('View PDF')}}
                                                </a>
                                            @else
                                                <span class="text-muted">{{__('No PDF')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($rate->status)
                                                <span class="alert alert-success" style="display:inline-block;">{{__('Publish')}}</span>
                                            @else
                                                <span class="alert alert-warning" style="display:inline-block;">{{__('Draft')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <x-delete-popover :url="route('admin.exchange.rate.delete',$rate->id)"/>
                                            <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.exchange.rate.edit',$rate->id)}}">
                                                <i class="ti-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            {{$all_exchange_rates->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#all_exchange_rates_table').DataTable({
                order: [[1, 'desc']],
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });

            $(document).on('click', '#bulk_delete_btn', function (e) {
                e.preventDefault();

                var bulkOption = $('#bulk_option').val();
                var allIds = [];

                $('.bulk-checkbox:checked').each(function () {
                    allIds.push($(this).val());
                });

                if (allIds.length && bulkOption === 'delete') {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('admin.exchange.rate.bulk.action')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            ids: allIds
                        },
                        success: function () {
                            location.reload();
                        }
                    });
                }
            });

            $('.all-checkbox').on('change', function () {
                $('.bulk-checkbox').prop('checked', $(this).is(':checked'));
            });
        });
    </script>
@endsection
