@extends('backend.admin-master')
@section('site-title')
    {{__('Edit Exchange Rate')}}
@endsection
@section('content')
    <div class="col-lg-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('Edit Exchange Rate')}}</h4>
                            <a href="{{route('admin.exchange.rate.all')}}" class="btn btn-primary">{{__('All Exchange Rates')}}</a>
                        </div>

                        <form action="{{route('admin.exchange.rate.update',$exchange_rate->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>{{__('Current PDF')}}</label>
                                @if($exchange_rate->pdf)
                                    <div class="d-flex align-items-center">
                                        <a href="{{asset('assets/uploads/exchange-rates/' . $exchange_rate->pdf)}}" target="_blank" class="btn btn-info btn-sm">{{__('View PDF')}}</a>
                                        <span class="ml-2 text-muted">{{$exchange_rate->pdf}}</span>
                                    </div>
                                @else
                                    <p class="text-muted">{{__('No PDF uploaded')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="pdf">{{__('Upload New PDF')}}</label>
                                <input type="file" accept=".pdf" class="form-control" id="pdf" name="pdf">
                            </div>
                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if($exchange_rate->status) selected @endif>{{__('Publish')}}</option>
                                    <option value="0" @if(!$exchange_rate->status) selected @endif>{{__('Draft')}}</option>
                                </select>
                            </div>

                            <div class="iconbox-repeater-wrapper">
                                @php $items = $exchange_rate->items ?? []; @endphp
                                @forelse($items as $index => $item)
                                    <div class="all-field-wrap">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Date')}}</label>
                                                    <input type="date" class="form-control" name="date[]" value="{{$item['date'] ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Currency Name')}}</label>
                                                    <input type="text" class="form-control" name="currency_name[]" value="{{$item['currency_name'] ?? ''}}" placeholder="{{__('e.g. USD, EUR, GBP')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Buying Rate')}}</label>
                                                    <input type="number" step="0.01" class="form-control" name="buying[]" value="{{number_format($item['buying'] ?? 0, 2)}}" placeholder="{{__('e.g. 110.50')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Selling Rate')}}</label>
                                                    <input type="number" step="0.01" class="form-control" name="selling[]" value="{{number_format($item['selling'] ?? 0, 2)}}" placeholder="{{__('e.g. 112.50')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action-wrap">
                                            <span class="add"><i class="ti-plus"></i></span>
                                            <span class="remove"><i class="ti-trash"></i></span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="all-field-wrap">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Date')}}</label>
                                                    <input type="date" class="form-control" name="date[]">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Currency Name')}}</label>
                                                    <input type="text" class="form-control" name="currency_name[]" placeholder="{{__('e.g. USD, EUR, GBP')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Buying Rate')}}</label>
                                                    <input type="number" step="0.01" class="form-control" name="buying[]" placeholder="{{__('e.g. 110.50')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('Selling Rate')}}</label>
                                                    <input type="number" step="0.01" class="form-control" name="selling[]" placeholder="{{__('e.g. 112.50')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action-wrap">
                                            <span class="add"><i class="ti-plus"></i></span>
                                            <span class="remove"><i class="ti-trash"></i></span>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Exchange Rate')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function($){
            "use strict";
            $(document).on('click','.all-field-wrap .action-wrap .add',function (e){
                e.preventDefault();
                var el = $(this);
                var parent = el.parent().parent();
                var container = $('.all-field-wrap');
                var clonedData = parent.clone();
                var containerLength = container.length;

                clonedData.find('input[type="date"], input[type="text"], input[type="number"]').each(function () {
                    $(this).val('');
                });

                parent.parent().append(clonedData);

                if (containerLength > 0){
                    parent.parent().find('.remove').show(300);
                }
            });

            $(document).on('click','.all-field-wrap .action-wrap .remove',function (e){
                e.preventDefault();
                var el = $(this);
                var parent = el.parent().parent();
                var container = $('.all-field-wrap');

                if (container.length > 1){
                    el.show(300);
                    parent.hide(300);
                    parent.remove();
                }else{
                    el.hide(300);
                }
            });
        })(jQuery);
    </script>
@endsection
