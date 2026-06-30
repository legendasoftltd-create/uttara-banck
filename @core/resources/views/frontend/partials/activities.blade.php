<section class="out-acivment">
    <div class="container">
        <div class="text-center">
            <p class="subtitle fancy">
                <span class="skl-bar-2"></span>
                <span class="title-color text-uppercase">
                    Our Activities
                </span>
                <span class="skl-bar-1"></span>
            </p>
            <br>
            <br>
        </div>

        <div class="grid-container">
            <div class="grid-item box-1-billion" data-aos="fade-up" data-aos-duration="500">
                @if ($add_query->where('type', 'image')->where('id', 1)->first())
                    @php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 1)->first()->image, 'full'); @endphp
                    <a href="{{ $add_query->where('type', 'image')->where('id', 1)->first()->redirect_url ?? '#' }}"
                        target="_blank">
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $add_query->where('type', 'image')->where('id', 1)->first()->title }}">
                    </a>
                @endif
            </div>

            <div class="img-card box-man" data-aos="fade-up" data-aos-duration="600">
                <div class="grid-item">
                    @if ($add_query->where('type', 'image')->where('id', 2)->first())
                        @php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 2)->first()->image, 'full'); @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $add_query->where('type', 'image')->where('id', 2)->first()->title }}">
                        <div class="app-hover-overlay">
                            <p class="overlay-text">
                                {{ $add_query->where('type', 'image')->where('id', 2)->first()->title ?? '' }}</p>
                            <a href="{{ $add_query->where('type', 'image')->where('id', 2)->first()->redirect_url ?? '#' }}"
                                target="_blank" class="know-more">Know More</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid-item box-bengali" data-aos="fade-up" data-aos-duration="700">
                @if ($add_query->where('type', 'image')->where('id', 3)->first())
                    @php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 3)->first()->image, 'full'); @endphp
                    <a href="{{ $add_query->where('type', 'image')->where('id', 3)->first()->redirect_url ?? '#' }}"
                        target="_blank"><img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $add_query->where('type', 'image')->where('id', 3)->first()->title }}"></a>
                @endif
            </div>
            <div class="img-card box-woman" data-aos="fade-up" data-aos-duration="800">
                <div class="grid-item">
                    @if ($add_query->where('type', 'image')->where('id', 4)->first())
                        @php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 4)->first()->image, 'full'); @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $add_query->where('type', 'image')->where('id', 4)->first()->title ?? '' }}">
                        <div class="app-hover-overlay">
                            <p class="overlay-text">
                                {{ $add_query->where('type', 'image')->where('id', 4)->first()->title ?? '' }}</p>
                            <a href="{{ $add_query->where('type', 'image')->where('id', 4)->first()->redirect_url ?? '#' }}"
                                target="_blank" class="know-more">Know More</a>
                        </div>
                    @endif
                </div>
            </div>

            @php
                $ad_item_5 = $add_query->where('id', 5)->first();
                $image_details_5 = $ad_item_5 ? get_attachment_image_by_id($ad_item_5->image, 'full') : null;
                $bg_img_url = !empty($image_details_5['img_url']) ? $image_details_5['img_url'] : asset('assets/images/image_video_thumnail_1_image.png');
                $video_url = '';
                if ($ad_item_5 && preg_match('/src="([^"]+)"/', $ad_item_5->embed_code, $match)) {
                    $video_url = $match[1];
                }
            @endphp
            <div class="grid-item box-sme" onclick="openVideo('{{ $video_url }}')"
                style="background-image: url('{{ $bg_img_url }}'); background-position: center; background-size: cover;"
                data-aos="fade-up" data-aos-duration="900">
                <div class="background-overlay"></div>
                <div class="play-btn"></div>
                <!-- <h1
                    style="position: absolute; right: 20px; bottom: 20px; color: white; text-align: right; line-height: 1;">
                    {{ $ad_item_5->title ?? '' }}
                </h1> -->
            </div>
            
            <div class="img-card box-wings" data-aos="fade-up" data-aos-duration="1000">
                <div class="grid-item">
                    @if ($add_query->where('type', 'image')->where('id', 6)->first())
                        @php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 6)->first()->image, 'full'); @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $add_query->where('type', 'image')->where('id', 6)->first()->title }}">
                    @endif
                    <div class="app-hover-overlay">
                        <p class="overlay-text">
                            {{ $add_query->where('type', 'image')->where('id', 6)->first()->title ?? '' }}</p>
                        <a href="{{ $add_query->where('type', 'image')->where('id', 6)->first()->redirect_url ?? '#' }}"
                            target="_blank" class="know-more">Know More</a>
                    </div>
                </div>
            </div>

            <div class="grid-item box-app" data-aos="fade-up" data-aos-duration="1100">
                @if ($add_query->where('type', 'image')->where('id', 7)->first())
                    @php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 7)->first()->image, 'full'); @endphp
                    <a href="{{ $add_query->where('type', 'image')->where('id', 7)->first()->redirect_url ?? '#' }}"
                        target="_blank">
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $add_query->where('type', 'image')->where('id', 7)->first()->title }}">
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Video Modal -->
    <div id="videoModal" class="video-modal">
        <div class="video-content">
    
            <span class="close-btn" onclick="closeVideo()">&times;</span>
    
            <iframe
                id="videoFrame"
                width="100%"
                height="500"
                src=""
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
    
        </div>
    </div>

</section>
