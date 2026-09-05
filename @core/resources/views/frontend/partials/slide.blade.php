<section class="banner-section">
    <!-- Carousel Start-->
    <div class="container">
        <div class="banner-carousel owl-carousel owl-theme">
            @foreach ($all_header_slider as $data)
                @php
                    $image_details = get_attachment_image_by_id($data->image, 'full');
                @endphp
                <div class="slide-item d-md-flex justify-content-between align-items-center">
                    <div class="promo-banner">
                        <div class="header-group">
                            @if (!empty($data->title))
                                <h1 class="title-primary">{{ $data->title }}</h1>
                            @endif
                            @if (!empty($data->subtitle))
                                <h2 class="title-secondary">{{ $data->subtitle }}</h2>
                            @endif
                        </div>

                        <div class="description">
                            <p>{{ $data->description }}</p>
                        </div>

                        <div class="button-wrapper">
                            <a class="btn-cta" href="{{ !empty($data->btn_01_url) ? $data->btn_01_url : '#' }}">
                                {{ $data->btn_01_text }}
                                <svg class="arrow-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.22 19.03a.75.75 0 0 1 0-1.06L18.19 13H3.75a.75.75 0 0 1 0-1.5h14.44l-4.97-4.97a.749.749 0 0 1 .326-1.275.749.749 0 0 1 .734.215l6.25 6.25a.75.75 0 0 1 0 1.06l-6.25 6.25a.75.75 0 0 1-1.06 0Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="video-container" style="position: relative;">
                        <img src="{{ isset($image_details['img_url']) ? $image_details['img_url'] : '' }}" alt="slider images" width="100">
                        @if (!empty($data->image_courtesy))
                            <div class="slider-image-courtesy-watermark">
                                {{ $data->image_courtesy }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.slider-image-courtesy-watermark {
    position: absolute;
    bottom: -1px;
    right: 5px;
    color: rgb(46 46 46 / 60%);
    opacity: 0.30;
    filter: blur(0.7px);
    font-size: 10px;
    font-weight: 400;
    line-height: 1.2;
    padding: 2px 6px;
    border-radius: 3px;
    letter-spacing: 0.3px;
    z-index: 5;
    pointer-events: none;
    user-select: none;
}
</style>
