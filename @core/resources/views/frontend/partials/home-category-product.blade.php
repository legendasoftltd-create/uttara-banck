@if ($category->title == 'Loan')
    <section class="container-fluid">
        <div class="swiper loanSlider">
            <div class="swiper-wrapper">
                @foreach (get_category_products($category->id) as $product)
                    <div class="swiper-slide">
                        <a href="{{ route('frontend.products.single', $product->slug) }}">
                            <div class="business-card">
                                @php
                                    $image_details = get_attachment_image_by_id($product->image, 'full');
                                @endphp
                                <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $product->title }}">
                                <div class="text-overlay">
                                    <h3>{{ $product->title }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@if ($category->title == 'Deposit')
    <section class="carousel-3D-swiper-section" style="position: relative;">
        <div>
            <div class="carousel-3D-swiper">
                <div class="swiper-wrapper" style="max-width: 1230px;">
                    @foreach (get_category_products($category->id) as $product)
                        <div class="swiper-slide">
                            <div class="image-wrapper aspect-video">
                                @php
                                    $image_details = get_attachment_image_by_id($product->image, 'full');
                                @endphp
                                <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $product->title }}">
                            </div>
                            <div class="details">
                                <h3>{{ $product->title }}</h3>
                                <a href="{{ route('frontend.products.single', $product->slug) }}">Learn More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
@endif
@if($category->title == 'Card')
    <section class="container-fluid">
            <div>
                <div class="about-menu-col">
                    <div class="seven-cols ">
                        @foreach (get_category_products($category->id) as $product)
                            <div class data-aos="fade-up" data-aos-duration="600" id="c-report">
                                <a href="{{ route('frontend.products.single', $product->slug) }}">
                                    <div class="business-card">
                                        @php
                                            $image_details = get_attachment_image_by_id($product->image, 'full');
                                        @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $product->title }}">
                                        <div class="text-overlay">
                                            <h3>{{ $product->title }}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
@endif


{{-- Product Slider --}}
{{-- <section class="container-fluid">
    <div class="swiper loneSlider">
        <div class="swiper-wrapper">
            @foreach (get_category_products($category->id) as $product)
                <div class="swiper-slide">
                    <a href="{{ route('frontend.products.single', $product->slug) }}">
                        <div class="business-card">
                            @php
                                $image_details = get_attachment_image_by_id($product->image, 'full');
                            @endphp
                            <img src="{{ $image_details['img_url'] ?? '' }}" alt="Business">
                            <div class="text-overlay">
                                <h3>{{ $product->title }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}
