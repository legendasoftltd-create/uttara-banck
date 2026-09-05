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
                @php $item1 = $add_query->where('type', 'image')->where('id', 1)->first(); @endphp
                @if ($item1)
                    @php $image_details = get_attachment_image_by_id($item1->image, 'full'); @endphp
                    <a href="{{ $item1->redirect_url ?? '#' }}"
                        target="_blank" style="position: relative; display: block;">
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $item1->title }}">
                        @if(!empty($item1->image_courtesy))
                            <div class="activity-image-courtesy-watermark">
                                {{ $item1->image_courtesy }}
                            </div>
                        @endif
                    </a>
                @endif
            </div>

            <div class="img-card box-man" data-aos="fade-up" data-aos-duration="600">
                <div class="grid-item" style="position: relative;">
                    @php $item2 = $add_query->where('type', 'image')->where('id', 2)->first(); @endphp
                    @if ($item2)
                        @php $image_details = get_attachment_image_by_id($item2->image, 'full'); @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $item2->title }}">
                        @if(!empty($item2->image_courtesy))
                            <div class="activity-image-courtesy-watermark">
                                {{ $item2->image_courtesy }}
                            </div>
                        @endif
                        <div class="app-hover-overlay">
                            <p class="overlay-text">
                                {{ $item2->title ?? '' }}</p>
                            <a href="{{ $item2->redirect_url ?? '#' }}"
                                target="_blank" class="know-more">Know More</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid-item box-bengali" data-aos="fade-up" data-aos-duration="700">
                @php $item3 = $add_query->where('type', 'image')->where('id', 3)->first(); @endphp
                @if ($item3)
                    @php $image_details = get_attachment_image_by_id($item3->image, 'full'); @endphp
                    <a href="{{ $item3->redirect_url ?? '#' }}"
                        target="_blank" style="position: relative; display: block;">
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $item3->title }}">
                        @if(!empty($item3->image_courtesy))
                            <div class="activity-image-courtesy-watermark">
                                {{ $item3->image_courtesy }}
                            </div>
                        @endif
                    </a>
                @endif
            </div>
            <div class="img-card box-woman" data-aos="fade-up" data-aos-duration="800">
                <div class="grid-item" style="position: relative;">
                    @php $item4 = $add_query->where('type', 'image')->where('id', 4)->first(); @endphp
                    @if ($item4)
                        @php $image_details = get_attachment_image_by_id($item4->image, 'full'); @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $item4->title ?? '' }}">
                        @if(!empty($item4->image_courtesy))
                            <div class="activity-image-courtesy-watermark">
                                {{ $item4->image_courtesy }}
                            </div>
                        @endif
                        <div class="app-hover-overlay">
                            <p class="overlay-text">
                                {{ $item4->title ?? '' }}</p>
                            <a href="{{ $item4->redirect_url ?? '#' }}"
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
                if ($ad_item_5) {
                    if (!empty($ad_item_5->redirect_url)) {
                        $raw_url = html_entity_decode($ad_item_5->redirect_url);
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts|live)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $raw_url, $match)) {
                            $video_url = "https://www.youtube.com/embed/" . $match[1];
                        } else {
                            $video_url = $raw_url;
                        }
                    } elseif (!empty($ad_item_5->embed_code) && preg_match('/src="([^"]+)"/', $ad_item_5->embed_code, $match)) {
                        $video_url = $match[1];
                    }
                }
            @endphp
            <div class="grid-item box-sme" onclick="openVideo('{{ $video_url }}')"
                style="background-image: url('{{ $bg_img_url }}'); background-position: center; background-size: cover; position: relative;"
                data-aos="fade-up" data-aos-duration="900">
                <div class="background-overlay"></div>
                <div class="play-btn"></div>
                @if(!empty($ad_item_5->image_courtesy))
                    <div class="activity-image-courtesy-watermark">
                        {{ $ad_item_5->image_courtesy }}
                    </div>
                @endif
                <!-- <h1
                    style="position: absolute; right: 20px; bottom: 20px; color: white; text-align: right; line-height: 1;">
                    {{ $ad_item_5->title ?? '' }}
                </h1> -->
            </div>
            
            <div class="img-card box-wings" data-aos="fade-up" data-aos-duration="1000">
                <div class="grid-item" style="position: relative;">
                    @php $item6 = $add_query->where('type', 'image')->where('id', 6)->first(); @endphp
                    @if ($item6)
                        @php $image_details = get_attachment_image_by_id($item6->image, 'full'); @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $item6->title }}">
                        @if(!empty($item6->image_courtesy))
                            <div class="activity-image-courtesy-watermark">
                                {{ $item6->image_courtesy }}
                            </div>
                        @endif
                    @endif
                    <div class="app-hover-overlay">
                        <p class="overlay-text">
                            {{ $item6->title ?? '' }}</p>
                        <a href="{{ $item6->redirect_url ?? '#' }}"
                            target="_blank" class="know-more">Know More</a>
                    </div>
                </div>
            </div>

            <div class="grid-item box-app" data-aos="fade-up" data-aos-duration="1100">
                @php $item7 = $add_query->where('type', 'image')->where('id', 7)->first(); @endphp
                @if ($item7)
                    @php $image_details = get_attachment_image_by_id($item7->image, 'full'); @endphp
                    <a href="{{ $item7->redirect_url ?? '#' }}"
                        target="_blank" style="position: relative; display: block;">
                        <img src="{{ $image_details['img_url'] ?? '' }}"
                            alt="{{ $item7->title }}">
                        @if(!empty($item7->image_courtesy))
                            <div class="activity-image-courtesy-watermark">
                                {{ $item7->image_courtesy }}
                            </div>
                        @endif
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

<style>
.activity-image-courtesy-watermark {
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
