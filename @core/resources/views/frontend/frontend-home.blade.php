@extends('frontend.frontend-master')

@section('content')
    {{-- @php
    $page_partial = 'home-'.get_static_option('home_page_variant');
    if (!empty(get_static_option('home_page_page_builder_status'))){
        $page_partial = 'page-builder';
    }
    @endphp --}}
    {{-- @include('frontend.home-pages.'.$page_partial) --}}
    <div class="content-body">
        <div class="news-bar">
            <div class="news-title">
                LATEST NEWS
            </div>
            <div class="news-text">
                <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();"
                    onmouseout="this.start();">
                    @foreach ($all_blog as $data)
                        <a href="{{ route('frontend.news.single', $data->slug) }}">{{ $data->title }}</a> ||
                    @endforeach
                </marquee>
            </div>
        </div>
        {{-- Carousel --}}
        @include('frontend.partials.slide')
        <!-- Carousel Start-->
        <div class="empty-height-50"></div>
        @include('frontend.partials.whatsNew')
        @foreach ($categories as $category)
            <div class="empty-height-50"></div>
            <section id="retail" class=" background-white relative-positioned">
                <div class="text-center">
                    <p class="subtitle fancy">
                        <span class="skl-bar-2"></span>
                        <span class="title-color text-uppercase">
                            <a class="text-decoration-none title-color text-uppercase"
                                href="{{ route('frontend.products.category', ['id' => $category->id, 'any' => $category->title]) }}">
                                {{ $category->title }}
                            </a>
                        </span>
                        <span class="skl-bar-1"></span>
                    </p>
                    <br>
                    <br>
                </div>
            </section>
            @include('frontend.partials.home-category-product')
        @endforeach

        <div class="empty-height-50"></div>
        <section id="wholesale" class=" background-white relative-positioned">
            <div class="text-center">
                <p class="subtitle fancy">
                    <span class="skl-bar-2"></span>
                    <span class="title-color text-uppercase">
                        <a class="text-decoration-none title-color text-uppercase" href="{{ route('frontend.service') }}">
                            Services
                        </a>
                    </span>
                    <span class="skl-bar-1"></span>
                </p>
                <br>
                <br>
            </div>
        </section>

        <section class="container">
            <div>
                <div class="about-menu-col">
                    <div class="seven-cols">
                        @foreach ($all_service as $service)
                            <div class="floatingMenu  floatingMenuMargin" data-aos="fade-up" data-aos-duration="500"
                                id="c-profile">
                                <div class="text-center about-nav dropdown">
                                    <a class="radius-icon" style="color: black"
                                        href="{{ route('frontend.services.single', $service->slug) }}">
                                        <div class="producticon">
                                            @php $image_details = get_attachment_image_by_id($service->image, 'full'); @endphp
                                            <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $service->title }}"
                                                class="img-responsive">
                                        </div>
                                    </a>
                                    <p class="m-0">
                                        <a
                                            href="{{ route('frontend.services.single', $service->slug) }}">{{ $service->title }}</a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <div class="floatingMenu  floatingMenuMargin" data-aos="fade-up" data-aos-duration="1400"
                            id="c-report">
                            <div class="text-center about-nav dropdown">
                                <a class="radius-icon" style="color: black" href="{{ route('frontend.service') }}">
                                    <div class="producticon">
                                        <img src="{{ asset('/assets/frontend/assets/images/icon/more.png') }}"
                                            alt="More" class="img-responsive">
                                    </div>
                                </a>
                                <p class="m-0">
                                    <a href="{{ route('frontend.service') }}">More</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="empty-height-50"></div>
        @include('frontend.partials.activities')

        <div class="empty-height-50"></div>
        <section>
            <div class="container-fluid">
                <div class="text-center">
                    <p class="subtitle fancy">
                        <span class="skl-bar-2"></span>
                        <a href="{{ route('frontend.news') }}" class="title-color text-uppercase">
                            <span class="title-color text-uppercase">
                                News
                            </span>
                        </a>
                        <span class="skl-bar-1"></span>
                    </p>
                    <br>
                    <br>
                </div>
                <div class="swiper blog-grid">
                    <div class="swiper-wrapper">
                        @foreach ($all_recent_blogs as $blog)
                            <div class="swiper-slide">
                                <div class="blog-wraper" style="box-shadow: 0 0  20px #ddd;">
                                    <div class="position-relative" style="height: 320px; overflow: hidden;">
                                        @php $image_details = get_attachment_image_by_id($blog->image, 'full'); @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $blog->title }}">
                                        <div class="blog-text px-3 py-4">
                                            <div class="mt-2 d-flex justify-content-between">
                                                {{-- <a href="{{ route('frontend.news.category', ['id' => $blog->blog_categories_id, 'any' => Str::slug($blog->category->name, '-', null)]) }}"
                                                class="pl-2 text-white"
                                                style="border-left: 3px solid #9B5DE5;"><small> {{Str::slug($blog->category->name, '-', "Uncategorized")}}</small></a> --}}
                                                <a href="{{ route('frontend.news.single', $blog->slug) }}"
                                                    class="text-white"><small>{{ $blog->author }}</small></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 card-footer">
                                        <h3 class="h6 excerpt">
                                            <a href="{{ route('frontend.news.single', $blog->slug) }}"
                                                style="line-height: 1.6;">
                                                {{ $blog->excerpt }}
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center mr-4">
                                            <svg height="16px" class="mr-2" version="1.1" id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 300.988 300.988"
                                                style="enable-background:new 0 0 300.988 300.988;" xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M150.494,0.001C67.511,0.001,0,67.512,0,150.495s67.511,150.493,150.494,150.493s150.494-67.511,150.494-150.493
                                                                S233.476,0.001,150.494,0.001z M150.494,285.987C75.782,285.987,15,225.206,15,150.495S75.782,15.001,150.494,15.001
                                                                s135.494,60.782,135.494,135.493S225.205,285.987,150.494,285.987z" />
                                                        <polygon
                                                            points="142.994,142.995 83.148,142.995 83.148,157.995 157.994,157.995 157.994,43.883 142.994,43.883 		" />
                                                    </g>
                                            </svg>
                                            <small class="mt-1"
                                                style="color: #9B5DE5;">{{ timeAgo($blog->created_at) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <div class="empty-height-50"></div>

        <section id="important" class=" background-white relative-positioned">
            <div class="text-center">
                <p class="subtitle fancy">
                    <span class="skl-bar-2"></span>
                    <span class="title-color text-uppercase">
                        Important Information
                    </span>
                    <span class="skl-bar-1"></span>
                </p>
                <br>
                <br>
            </div>
            <div class="container-fluid">
                <div class="col-md-10 col-sm-6 col-xs-12" style="display: contents;">
                    <div class="information-wrap">
                        <div data-aos="fade-up" data-aos-duration="500" class="information-card">
                            <h3 class="h3">Important Information</h3>
                            <ul>
                                @foreach ($all_work_category as $data)
                                    <hr style="margin-top: .5rem; margin-bottom: .5rem;">
                                    <a href="{{ route('frontend.works.category', ['id' => $data->id, 'any' => $data->name]) }}"
                                        target="_blank">
                                        <li><i class="fa-regular fa-circle-dot"></i>
                                            {{ $data->name }}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                        @foreach($all_download_categories->chunk(8) as $chunk)
                        <div data-aos="fade-up" data-aos-duration="600" class="information-card">
                            <a href="{{ route('frontend.bank.downloads') }}" class="title-color text-uppercase">
                                <h3 class="h3">Bank Downloads</h3>
                            </a>
                            {{-- <h3 class="h3">Important Downloads</h3> --}}
                            <ul>
                                @forelse($chunk as $category)
                                    <hr style="margin-top: .5rem; margin-bottom: .5rem;">
                                    {{-- @php
                                                    $firstFile = is_array($download->files) ? ($download->files[0] ?? null) : null;
                                                @endphp --}}
                                    <a href="{{ route('frontend.bank.downloads.category', ['id' => $category->id, 'any' => $category->title]) }}"
                                        target="_blank">
                                        <li><i class="fa-regular fa-circle-dot"></i>
                                            {{ $category->title }}</li>
                                    </a>
                                @empty
                                    <li>{{ __('No downloads found') }}</li>
                                @endforelse
                            </ul>
                        </div>
                        @endforeach
                        

                        {{-- <div data-aos="fade-up" data-aos-duration="700" class="information-card">
                            <ul>
                                <a href="#download/Notice-of-the-21st-AGM.jpg" target="_blank">
                                    <li><i class="fa-regular fa-circle-dot"></i>
                                        Notice of the
                                        Twenty-First
                                        Annual General
                                        Meeting
                                        of
                                        Uttara Bank PLC</li>
                                </a>
                                <a href="#en/bida">
                                    <li><i class="fa-regular fa-circle-dot"></i>
                                        The Bangladesh
                                        Investment
                                        Development
                                        Authority
                                        (BIDA)</li>
                                </a>

                                <a href="#download/Uttara Bank PLC E-commerce Merchant List.pdf" target="_blank">
                                    <li><i class="fa-regular fa-circle-dot"></i>
                                        Uttara Bank PLC
                                        E-commerce
                                        Merchant List</li>
                                </a>

                                <a href>
                                    <li class="title video-btn" data-toggle="modal" data-src data-target="#myModal"><i
                                            class="fa-regular fa-circle-dot"></i>
                                        Fake
                                        Notes
                                        Prevention
                                        Video</li>
                                </a>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>

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
            <div class="Robi-Ad" style="line-height: 1; position: fixed; height: 140px; right: -100px;">
                <a class="handle" href="{{ route('frontend.locations') }}?tab=atm" target="_blank"
                    style="background: url('{{ asset('assets/frontend/assets/images/icon/atmIcon.png') }}') no-repeat; width: 42px; height: 50px; display: block; text-indent: -99999px; outline: none; position: absolute; top: 0px; left: -33px;">atms</a>
                <a href="{{ route('frontend.locations') }}?tab=atm" target="_blank"><img
                        src="{{ asset('assets/frontend/assets/images/icon/utarra_atm.png') }}" height="70"
                        width="147"></a>
            </div>
            <!--pop up    -->
            <div class="Cell-Ad"
                style="line-height: 1; position: fixed; height: 140px; left: -187px; z-index: 99; top: 20%;transition: all 0.4s ease-in-out;transition: all 0.4s ease-in-out;">
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
    </div>
@endsection
