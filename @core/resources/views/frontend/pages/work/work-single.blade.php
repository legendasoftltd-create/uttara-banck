@extends('frontend.frontend-page-master')

@section('page-meta-data')
    <meta name="description" content="{{$work_item->meta_description}}">
    <meta name="tags" content="{{$work_item->meta_tag}}">
@endsection
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.work.single',$work_item->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$work_item->title}}" />
    {!! render_og_meta_image_by_attachment_id($work_item->image) !!}
@endsection
@section('site-title')
    {{$work_item->title}} - {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
     {{$work_item->title}}
@endsection
@section('content')
    {{-- <div class="work-details-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="portfolio-details-item">
                        <div class="thumb">
                          {!! render_image_markup_by_attachment_id($work_item->image) !!}
                        </div>
                        <div class="post-description">
                            {!! iFrameFilterInSummernoteAndRender($work_item->description) !!}
                        </div>

                        @php $gallery_item = $work_item->gallery ? explode('|',$work_item->gallery) : []; @endphp
                        @if(!empty($gallery_item))
                        
                        <div class="case-study-gallery-wrapper">
                            <h2 class="main-title">{{get_static_option('case_study_'.$user_select_lang_slug.'_gallery_title')}}</h2>
                            <div class="case-study-gallery-carousel global-carousel-init"
                                 data-loop="true"
                                 data-desktopitem="1"
                                 data-mobileitem="1"
                                 data-tabletitem="1"
                                 data-nav="true"
                                 data-autoplay="true"
                                 data-margin="0"
                            >
                                @foreach($gallery_item as $gall)
                                <div class="single-gallery-item">
                                    {!! render_image_markup_by_attachment_id($gall) !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="project-widget">
                        <div class="widget-nav-menu margin-bottom-30">
                            <ul>
                                <li>
                                    <div class="service-widget">
                                        <div class="service-icon style-01">
                                            <i class="far fa-user"></i>
                                        </div>
                                        <div class="service-title">
                                        <span>{{__('Client')}}</span>
                                            <h6 class="title">{{$work_item->clients}}</h6>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="service-widget">
                                        <div class="service-icon style-02">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <div class="service-title">
                                            <span>{{__('Budget')}}</span>
                                            <h6 class="title">{{$work_item->budget}}</h6>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="service-widget border-bottom">
                                        <div class="service-icon style-04">
                                            <i class="far fa-clock"></i>
                                        </div>
                                        <div class="service-title">
                                            <span>{{__('Duration')}}</span>
                                            <h6 class="title">{{$work_item->duration}}</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        {!! App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('case_study',['column' => false]) !!}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="related-work-area padding-top-100">
                        <div class="section-title margin-bottom-30">
                            <h2 class="title">{{get_static_option('case_study_'.$user_select_lang_slug.'_related_title')}}</h2>
                        </div>
                            <div class="related-case-study-carousel global-carousel-init"
                                 data-loop="true"
                                 data-desktopitem="3"
                                 data-mobileitem="1"
                                 data-tabletitem="1"
                                 data-nav="true"
                                 data-autoplay="true"
                                 data-margin="40"
                            >
                            @foreach($related_works as $data)
                                <div class="single-related-case-study-item">
                                    <div class="thumb">
                                        {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('frontend.work.single',$data->slug)}}"> {{$data->title}}</a></h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="scroll-down"></div>
                    <div class="empty-height-50"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center title-color">
                                1st Quarter Statement
                            </h2>
                            <div class="title-seperator">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center" style="border-collapse: collapse; max-width:1230px;">
                            <thead>
                                <tr bgcolor="#008649">
                                    <th width="10%" class="text-center"><font color="#ffffff"><b>Sl No.</b></font></th>
                                    <th width="20%" class="text-center"><font color="#ffffff"><b>Date</b></font></th>
                                    <th width="70%" class="text-center"><font color="#ffffff"><b>Title</b></font></th>
                                    <th width="10%" class="text-center"><font color="#ffffff"><b>View</b></font></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">March 31, 2025</td>
                                    <td>1st Quarter Statement 2025</td>
                                    <td class="text-center"><a href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter">View</a></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">March 31, 2024</td>
                                    <td>1st Quarter Statement (Un-Audited) 2024</td>
                                    <td class="text-center"><a href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter">View</a></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">March 31, 2023</td>
                                    <td>1st Quarter Statement (Un-Audited) 2023</td>
                                    <td class="text-center"><a href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="empty-height-50"></div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;">
                        <div class="modal-content" style="background-color: #FFF; max-width: 991px; width: 100%; margin: 0 auto;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Market Disclosure 2024</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <embed src="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" type="application/pdf" width="100%" height="600px">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" type="button" class="btn btn-view" download>Save changes</a>
                        </div>
                        </div>
                    </div>
                </div>
@endsection

