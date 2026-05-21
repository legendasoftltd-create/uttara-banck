@include('frontend.partials.header')
@yield('content')
<div id="sticky-container">
    <div class="sticky">
        <div class="head-stk">
            <div class="left-head"> <span class="rotate">Exchange&nbsp;Rates</span></div>

            <div class="con-fild ">
                <p>
                    Thu, Oct 23, 2025 11:13 AM
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

                        <tr>
                            <td><b>USD</b></td>
                            <td>121.7500</td>
                            <td>122.7500</td>
                        </tr>
                        <tr>
                            <td><b>EUR</b></td>
                            <td>140.6230</td>
                            <td>143.1983</td>
                        </tr>
                        <tr>
                            <td><b>GBP</b></td>
                            <td>161.7171</td>
                            <td>164.6996</td>
                        </tr>

                    </tbody>
                </table>
                <span style="padding-left: 70px;">
                    <a href="#" target="_blank">View
                        complete
                        list</a>
                </span>
            </div>
        </div>
    </div>
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
        style="line-height: 1; position: fixed; height: 140px; left: -187px; z-index: 99; top: 30%;transition: all 0.4s ease-in-out;transition: all 0.4s ease-in-out;">
        <a class="Cell" href="{{ route('frontend.locations') }}?tab=branch" target="_blank"
            style=" width: 29px; height: 140px; display: block; z-index: 99; outline: none; position: absolute; top: 0px; right: -29px;  box-shadow: rgba(160, 192, 229, 0.55) 0px 0px 10px 0px; border-radius: 0 10px 10px 0;background: #FFF;"><span
                style="color: #008649; margin-top: 66px; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); -ms-transform: rotate(-90deg); -o-transform: rotate(-90deg); float: left; margin-left: -33px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; font-weight: 500;">Branches</span></a>
        <a style="border:none;" href="{{ route('frontend.locations') }}?tab=branch" target="_blank">
            <img width="187" height="140"
                src="{{ asset('assets/frontend/assets/images/icon/ubranch.jpg') }}">
        </a>
    </div>
    <div class="bankboooth-Ad"
        style="line-height: 1; position: fixed; height: 160px; left: -187px; z-index: 99; top: 50%;transition: all 0.4s ease-in-out;">
        <a class="bankboooth" href="{{ route('frontend.locations') }}?tab=sub_branch" target="_blank"
            style="width: 29px; height: 160px; display: block; z-index: 99; outline: none; position: absolute; top: 0px; right: -29px; box-shadow: rgba(160, 192, 229, 0.55) 0px 0px 10px 0px; border-radius: 0 10px 10px 0;background: #FFF;"><span
                style="color: #008649; margin-top: 73px; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); -ms-transform: rotate(-90deg); -o-transform: rotate(-90deg); float: left; margin-left: -54px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; font-weight: 500; width: 140px;">Sub
                Branchs</span> </a>
        <a style="border:none;" href="{{ route('frontend.locations') }}?tab=sub_branch" target="_blank">
            <img width="187" height="160"
                src="{{ asset('assets/frontend/assets/images/icon/ubanking-booth.jpg') }}">
        </a>
    </div>
</div>
@include('frontend.partials.footer')

