{{-- @php
    if(empty($popup_details)) {return;}
        $popup_class = '';
        if ($popup_details->type == 'notice'){
            $popup_class = 'notice-modal';
        }elseif($popup_details->type == 'only_image'){
            $popup_class = 'only-image-modal';
        }elseif($popup_details->type == 'promotion'){
            $popup_class = 'promotion-modal';
        }else{
            $popup_class = 'discount-modal';
        }
@endphp
<div class="nx-popup-backdrop"></div>
<div class="nx-popup-wrapper {{$popup_class}}">
    <div class="nx-modal-content-wrapper">
        @if ($popup_details->type == 'notice')
            <div class="nx-modal-inner-content-wrapper">
                <div class="nx-popup-close">×</div>
                <div class="nx-modal-content">
                    <div class="notice-modal-content-wrapper">
                        <div class="right-side-content">
                            <h4 class="title">{{$popup_details->title}}</h4>
                            <p>{{$popup_details->description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($popup_details->type == 'only_image')
            <div class="nx-modal-inner-content-wrapper"
                 {!! render_background_image_markup_by_attachment_id($popup_details->only_image) !!}
            >
                <div class="nx-popup-close">×</div>
                <div class="nx-modal-content"></div>
            </div>
        @elseif($popup_details->type == 'promotion')
            <div class="nx-modal-inner-content-wrapper"
                {!! render_background_image_markup_by_attachment_id($popup_details->background_image) !!}
            >
                <div class="nx-popup-close">×</div>
                <div class="nx-modal-content">
                    <div class="promotional-modal-content-wrapper">
                        <div class="left-content-warp">
                            {!! render_image_markup_by_attachment_id($popup_details->only_image) !!}
                        </div>
                        <div class="right-content-warp">
                            <div class="right-content-inner-wrap">
                                <h4 class="title">{{$popup_details->title}}</h4>
                                <p>{{$popup_details->description}}</p>
                                @if (!empty($popup_details->btn_status))
                                <div class="btn-wrapper">
                                    <a href="{{$popup_details->button_link}}" rel="canonical" class="btn-boxed">{{$popup_details->button_text}}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="nx-modal-inner-content-wrapper"
                {!! render_background_image_markup_by_attachment_id($popup_details->background_image) !!}
            >
                <div class="nx-popup-close">×</div>
                <div class="nx-modal-content">
                    <div class="discount-modal-content-wrapper">
                        <div class="left-content-warp">
                            {!! render_image_markup_by_attachment_id($popup_details->only_image) !!}
                        </div>
                        <div class="right-content-warp">
                            <div class="right-content-inner-wrap">
                                <h4 class="title">{{$popup_details->title}}</h4>
                                <p>{{$popup_details->description}}</p>
                                <div class="countdown-wrapper">
                                    <div id="countdown"></div>
                                </div>
                                @if (!empty($popup_details->btn_status))
                                    <div class="btn-wrapper">
                                        <a rel="canonical"  href="{{$popup_details->button_link}}" class="btn-boxed">{{$popup_details->button_text}}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
 --}}
<!-- Start of popup window -->
@if (!empty(get_static_option('popup_enable_status') && !empty(get_static_option('popup_selected_' . $user_select_lang_slug . '_id'))))
    @php
        $popup_details = \App\PopupBuilder::get();
    @endphp
    
    <div class="modal fade home-popup" id="whats-news-3" tabindex="-1" role="dialog" aria-labelledby="us1BillionModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content" style>
                <div class="skl-modal-body modal-body" style>
                    <span class="skl-modal-close-button_02 close" data-dismiss="modal" style="z-index: 999"
                        aria-label="Close">
                        <img src="https://www.legacy.bracbank.com/client_end/img/icon/skl-close.png" alt>
                    </span>
                    <div id="carouselExampleControls" class="carousel slide popup" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($popup_details as $data)
                                @php
                                    $popup_type = $data->type ?? null;
                                @endphp
                                @if ($popup_type === 'notice')
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <div class="bg-white p-4 rounded shadow-sm news-card">
                                            <h4 class="news-title rounded">{{ $data->title }}</h4>
                                            <p class="news-desc">{{ $data->description }}</p>
                                        </div>
                                    </div>
                                @elseif($popup_type === 'only_image')
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        @php
                                            $bolg_image_details = get_attachment_image_by_id($data->only_image, 'full');
                                        @endphp
                                        <img class="d-block w-100 rounded" src="{{$bolg_image_details['img_url']}}" alt="slider 02">
                                    </div>
                                @elseif($popup_type === 'promotion')
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        @php
                                            $bolg_image_details = get_attachment_image_by_id($data->only_image, 'full');
                                        @endphp
                                        <img class="d-block w-100 rounded" src="{{$bolg_image_details['img_url']}}" alt="slider 02">
                                    </div>
                                @else
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        @php
                                            $bolg_image_details = get_attachment_image_by_id($data->only_image, 'full');
                                        @endphp
                                        <img class="d-block w-100 rounded" src="{{$bolg_image_details['img_url']}}" alt="slider 02">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="prev-extended-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class=" next-extended-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<!--End of popup-->
