@include('frontend.partials.header')
{{-- @include('frontend.partials.navbar-variant.navbar-'.get_static_option('navbar_variant')) --}}
@include('frontend.partials.breadcrumb')
@if(isset($all_header_slider) && $all_header_slider->count() > 0)
    @include('frontend.partials.slide')
@endif
@yield('content')

<div id="sticky-container">
    <div class="sticky">
        <div class="head-stk">
            <div class="left-head"> <span class="rotate">Exchange&nbsp;Rates</span></div>

            <div class="con-fild ">
                @php $items = $exchange_rate->items ?? []; @endphp
                <p>
                    {{ $exchange_rate ? \Carbon\Carbon::parse($exchange_rate->updated_at)->format('D, M d, Y h:i A') : '' }}
                </p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Buying</th>
                            <th>Selling</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td><b>{{ $item['currency_name'] ?? '' }}</b></td>
                            <td>{{ number_format($item['buying'] ?? 0, 2) }}</td>
                            <td>{{ number_format($item['selling'] ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted">{{__('No rates available')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <span style="padding-left: 70px;">
                    <a href="{{ route('frontend.exrate') }}" target="_blank">View
                        complete
                        list</a>
                </span>
            </div>
        </div>
    </div>
        @if(request()->routeIs('frontend.complain') || request()->routeIs('frontend.complain.*') || request()->is('complain') || request()->is('complain/*'))
        <div class="sticky-complain">
            <a href="{{ route('frontend.complain.send') }}">
            <div class="complain-stk initially-open">
                <div class="left-head-complain">
                    <span class="rotate-complain">Complain&nbsp;Cell</span>
                </div>
                <div class="con-fild-complain">
                        <img src="{{ asset('assets/frontend/assets/images/icon/complain-icon.jpg') }}" alt="Complain Cell">
                    </div>
                </div>
            </a>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    var el = document.querySelector('.sticky-complain .complain-stk');
                    if (el) {
                        el.classList.remove('initially-open');
                    }
                }, 2000);
            });
        </script>
        @endif
        <!-- floating calculator widget -->
        <!-- <a href="{{ route('deposit.calculator') }}" class="calculator-widget">
            <div class="calc-tooltip">Deposit Calculator</div>
            <div class="calc-icon-container">
                <img style="width: 35px;height: 50px;" src="{{ asset('assets/frontend/assets/images/icon/calculator.png') }}" alt="Calculator Icon" width="57"
                    height="24">
            </div>
        </a>
        <a href="{{ route('emi.calculator') }}" class="calculator-widget" style="top: calc(55% + 70px);">
            <div class="calc-tooltip">EMI Calculator</div>
            <div class="calc-icon-container">
                <img style="width: 35px;height: 50px;" src="{{ asset('assets/frontend/assets/images/icon/calculator.png') }}" alt="EMI Calculator" width="57"
                    height="24">
            </div>
        </a> -->
</div>
<div class="content">
    <div class="Robi-Ad" style="line-height: 1; position: fixed; height: 140px; left: -149px;">
        <a class="handle" href="{{ route('frontend.locations') }}?tab=atm" target="_blank"
            style="background: url('{{ asset('assets/frontend/assets/images/icon/atmIcon.png') }}') no-repeat; width: 42px; height: 50px; display: block; text-indent: -99999px; outline: none; position: absolute; top: 0px; right: -57px;">atms</a>
        <a href="{{ route('frontend.locations') }}?tab=atm" target="_blank"><img
                src="{{ asset('assets/frontend/assets/images/icon/utarra_atm.png') }}" height="70"
                width="147"></a>
    </div>
    <!--pop up    -->
    <div class="Cell-Ad"
        style="line-height: 1; position: fixed; height: 140px; left: -187px; z-index: 99; top: 35%;transition: all 0.4s ease-in-out;transition: all 0.4s ease-in-out;">
        <a class="Cell" href="{{ route('frontend.locations') }}?tab=branch" target="_blank"
            style=" width: 29px; height: 140px; display: block; z-index: 99; outline: none; position: absolute; top: 0px; right: -29px;  box-shadow: rgba(160, 192, 229, 0.55) 0px 0px 10px 0px; border-radius: 0 10px 10px 0;background: #FFF;"><span
                style="color: #008649; margin-top: 66px; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); -ms-transform: rotate(-90deg); -o-transform: rotate(-90deg); float: left; margin-left: -33px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; font-weight: 500;">Branches</span></a>
        <a style="border:none;" href="{{ route('frontend.locations') }}?tab=branch" target="_blank">
            <img width="187" height="140"
                src="{{ asset('assets/frontend/assets/images/icon/ubranch.jpg') }}">
        </a>
    </div>
    <div class="bankboooth-Ad"
        style="line-height: 1; position: fixed; height: 160px; left: -187px; z-index: 99; top: 60%;transition: all 0.4s ease-in-out;">
        <a class="bankboooth" href="{{ route('frontend.locations') }}?tab=sub_branch" target="_blank"
            style="width: 29px; height: 160px; display: block; z-index: 99; outline: none; position: absolute; top: 0px; right: -29px; box-shadow: rgba(160, 192, 229, 0.55) 0px 0px 10px 0px; border-radius: 0 10px 10px 0;background: #FFF;"><span
                style="color: #008649; margin-top: 67px; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); -ms-transform: rotate(-90deg); -o-transform: rotate(-90deg); float: left; margin-left: -57px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; font-weight: 500; width: 140px;">Sub
                Branchs</span> </a>
        <a style="border:none;" href="{{ route('frontend.locations') }}?tab=sub_branch" target="_blank">
            <img width="187" height="160"
                src="{{ asset('assets/frontend/assets/images/icon/ubanking-booth.jpg') }}">
        </a>
    </div>
</div>



@include('frontend.partials.footer')


