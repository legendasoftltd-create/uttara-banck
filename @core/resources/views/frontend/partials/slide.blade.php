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
                            <h4>{{ $data->description }}</h4>
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
                    <div class="video-container">
                        <img src="{{ $image_details['img_url'] }}" alt="slider images" width="100">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
