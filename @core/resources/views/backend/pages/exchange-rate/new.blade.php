@extends('backend.admin-master')
@section('site-title')
    {{__('Add New Exchange Rate')}}
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
                            <h4 class="header-title">{{__('Add New Exchange Rate')}}</h4>
                            <a href="{{route('admin.exchange.rate.all')}}" class="btn btn-primary">{{__('All Exchange Rates')}}</a>
                        </div>

                        <form action="{{route('admin.exchange.rate.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="pdf">{{__('Upload PDF (single file for all entries)')}}</label>
                                <input type="file" accept=".pdf" class="form-control" id="pdf" name="pdf">
                            </div>
                            <div class="iconbox-repeater-wrapper">
                                <div class="all-field-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">{{__('Date')}}</label>
                                                <input type="date" class="form-control" name="date[]" value="{{old('date.0')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency_name">{{__('Currency Name')}}</label>
                                                <input type="text" class="form-control" name="currency_name[]" value="{{old('currency_name.0')}}" placeholder="{{__('e.g. USD, EUR, GBP')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="buying">{{__('Buying Rate')}}</label>
                                                <input type="number" step="0.01" class="form-control" name="buying[]" value="{{old('buying.0')}}" placeholder="{{__('e.g. 110.50')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="selling">{{__('Selling Rate')}}</label>
                                                <input type="number" step="0.01" class="form-control" name="selling[]" value="{{old('selling.0')}}" placeholder="{{__('e.g. 112.50')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-wrap">
                                        <span class="add"><i class="ti-plus"></i></span>
                                        <span class="remove"><i class="ti-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add Exchange Rates')}}</button>
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
