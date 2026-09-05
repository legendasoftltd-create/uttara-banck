<style>
@media (max-width: 767px) {
    .custom-height-for-mobile-deposit {
        height: 370px !important;
        object-fit: contain !important;.
        object-position: center !important;
        width: 100% !important;
    }
}
</style>

@if ($category->title == 'Loan')
    <section class="container">
        <div class="swiper loanSlider">
            <div class="swiper-wrapper">
                @foreach (get_category_products($category->id) as $product)
                    <div class="swiper-slide">
                        <a href="{{ route('frontend.products.single', $product->slug) }}">
                            <div class="business-card" style="position: relative;">
                                @php
                                    $image_details = get_attachment_image_by_id($product->image, 'full');
                                @endphp
                                <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $product->title }}">
                                @if(!empty($product->image_courtesy))
                                    <div class="product-image-courtesy-watermark">
                                        {{ $product->image_courtesy }}
                                    </div>
                                @endif
                                <div class="text-overlay">
                                    <p>{{ $product->title }}</p>
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
    <section class="carousel-3D-swiper-section container "  style="position: relative;">
        <div class="carousel-3D-swiper-section container">
            <div class="carousel-3D-swiper">
                <div class="swiper-wrapper custom-height-for-mobile-deposit" style="max-width: 1230px;">
                    @foreach (get_category_products($category->id) as $product)
                        <div class="swiper-slide">
                            <div class="image-wrapper aspect-video" style="position: relative;">
                                @php
                                    $image_details = get_attachment_image_by_id($product->image, 'full');
                                @endphp
                                <img class="custom-height-for-mobile-deposit" src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $product->title }}">
                                @if(!empty($product->image_courtesy))
                                    <div class="product-image-courtesy-watermark">
                                        {{ $product->image_courtesy }}
                                    </div>
                                @endif
                            </div>
                            <div class="details">
                                <p>{{ $product->title }}</p>
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
    <section class="container">
            <div>
                <div class="about-menu-col">
                    <div class="seven-cols ">
                        @foreach (get_category_products($category->id) as $product)
                            <div class data-aos="fade-up" data-aos-duration="600" id="c-report">
                                <a href="{{ route('frontend.products.single', $product->slug) }}">
                                    <div class="business-card" style="position: relative;">
                                        @php
                                            $image_details = get_attachment_image_by_id($product->image, 'full');
                                        @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $product->title }}">
                                        @if(!empty($product->image_courtesy))
                                            <div class="product-image-courtesy-watermark">
                                                {{ $product->image_courtesy }}
                                            </div>
                                        @endif
                                        <div class="text-overlay">
                                            <p>{{ $product->title }}</p>
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

<style>
.product-image-courtesy-watermark {
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
                                <p>{{ $product->title }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}
