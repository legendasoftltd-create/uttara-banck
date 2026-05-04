@extends('frontend.frontend-page-master')
@section('page-title')
    {{-- {{__('Category:')}}  --}}
    {{ $category_name }}
@endsection
@section('site-title')
    {{ __('Category:') }} {{ $category_name }}
@endsection
@section('page-meta-data')
    <meta name="description"
        content="{{ get_static_option('product_page_' . $user_select_lang_slug . '_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('product_page_' . $user_select_lang_slug . '_meta_tags') }}">
    {!! render_og_meta_image_by_attachment_id(
        get_static_option('product_page_' . $user_select_lang_slug . '_meta_image'),
    ) !!}
@endsection
@section('content')
    {{-- <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                @foreach ($all_products as $data)
                    <div class="col-lg-3 col-md-6">
                        <x-frontend.product.grid :product="$data" :margin="true"/>
                    </div>
                @endforeach
                <div class="col-lg-12 text-center">
                    <nav class="pagination-wrapper " aria-label="Page navigation ">
                        {{$all_products->links()}}
                    </nav>
                </div>
            </div>
        </div>
    </section> --}}
    <div class="empty-height-50"></div>
    <div id="loan-products" class="category-section active">
        <div class="container">
            <!-- <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center title-color">
                        {{ $category_name }}
                    </h2>
                    <div class="title-seperator">
                    </div>
                </div>
            </div> -->
            <section class="grid-section mt-4">
                @foreach ($all_products as $product)
                    <div>
                        <div class="cards-container">
                            <div class="card">
                                <div class="card-image">
                                    <img src="{{ get_attachment_image_by_id($product->image, 'full', false)['img_url'] ?? '' }}" alt="{{ $product->title }}">
                                </div>
                                <div class="card-content">
                                    <h3>{{ $product->title }}</h3>
                                    <div class="card-buttons">
                                        <a href="{{ route('frontend.products.single', $product->slug) }}" class="btn">Explore
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        <div class="empty-height-50"></div>
        </div>
    </div>
@endsection
