@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('exchange_rate_page_'.$user_select_lang_slug.'_name') ?? __('Exchange Rates') }}
@endsection
@section('page-title')
    {{ get_static_option('exchange_rate_page_'.$user_select_lang_slug.'_name') ?? __('Exchange Rates') }}
@endsection

<style>
    
    .table thead th{
        background-color: #1b8f48;
        color: #fff;
        border-color: #1b8f48;
    }

    .table tbody td{
        color: #000;
    }

   .responsive-box {
        width: 70%;
        margin: 0 auto;
    }

    /* Medium devices (tablets and below) */
    @media (max-width: 991px) {
        .responsive-box {
            width: 70%;
            margin: 0 auto;
        }
    }

    /* Small devices (mobile) */
    @media (max-width: 767px) {
        .responsive-box {
            width: 100%;
            margin: 0;
        }
    }
</style>

@section('content')
<div class="container py-5">
    @if($exchange_rate)
        <div class="responsive-box">
            <h2 class="text-center" style="color: #25974a;">{{__('Exchange Rates')}}</h2>
            <p class="text-black text-center mb-2">{{ \Carbon\Carbon::parse($exchange_rate->updated_at)->format('D, M d, Y h:i A') }}</p>
            
            <div class="table-responsive mb-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{__('Currency')}}</th>
                            <th>{{__('Buying')}}</th>
                            <th>{{__('Selling')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exchange_rate->items ?? [] as $item)
                        <tr>
                            <td><b>{{ $item['currency_name'] ?? '' }}</b></td>
                            <td>{{ number_format($item['buying'] ?? 0, 2) }}</td>
                            <td>{{ number_format($item['selling'] ?? 0, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($exchange_rate->pdf)
        <hr>
        <h4>{{__('PDF Document')}}</h4>
        <div style="width:100%;">
            <embed src="{{ asset('assets/uploads/exchange-rates/' . $exchange_rate->pdf) }}" type="application/pdf" style="width:100%;height:80vh;border:1px solid #ddd;border-radius:4px;">
        </div>
        <div class="mt-3">
            <a href="{{ asset('assets/uploads/exchange-rates/' . $exchange_rate->pdf) }}" download class="btn btn-primary">
                <i class="fas fa-download"></i> {{__('Download PDF')}}
            </a>
        </div>
        @endif
    @else
        <p class="text-muted mt-3">{{__('No exchange rates available at this time.')}}</p>
    @endif
</div>
@endsection
