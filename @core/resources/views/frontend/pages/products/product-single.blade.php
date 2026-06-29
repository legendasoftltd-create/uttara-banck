@extends('frontend.frontend-page-master')
@section('site-title')
    {{ $product->title }}
@endsection
@section('style')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/toastr.css') }}">
@endsection
@section('page-title')
    {{ $product->title }}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{ $product->meta_description }}">
    <meta name="tags" content="{{ $product->meta_tags }}">
@endsection

@section('og-meta')
    <meta property="og:url" content="{{ route('frontend.products.single', $product->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $product->title }}" />
    {!! render_og_meta_image_by_attachment_id($product->image) !!}
    @php
        $post_img = null;
        $blog_image = get_attachment_image_by_id($product->image, 'full', false);
        $post_img = !empty($blog_image) ? $blog_image['img_url'] : '';
    @endphp
@endsection
@section('content')
    <section class="content-section pt-4 mt-4">
        <div class="container">
              {{--  <h2 class="title">{{ $product->title }}</h2>
                <p>{{$product->short_description}}</p>

                <br>
                <br> --}}

                {!! iFrameFilterInSummernoteAndRender($product->description) !!}
        </div>
    </section>

    <div class="empty-height-50"></div>
    @if (count($related_products) > 0 && !empty(get_static_option('product_single_related_products_status')))
        <section class="related-products">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center title-color">
                        RELATED PRODUCT
                    </h2>
                    <div class="title-seperator">
                    </div>
                </div>
            </div>
            <div class="empty-height-50"></div>
            <div class="product-grid">
            @foreach ($related_products as $data)
            
                <div class="{{ $data->category_id == 3 ? 'card-product' : 'product-card' }}">
                    <div class="image-container">
                    @php
                        $image_details = get_attachment_image_by_id($data->image, 'full');
                    @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $data->title }}" >
                    </div>
                    <div class="card-content">
                        <h3 class="product-name"><a href="{{route('frontend.products.single',$data->slug)}}">{{ $data->title }}</a></h3>
                    </div>
                </div>
            @endforeach
            </div>
        </section>
    @endif
@endsection
{{-- @section('scripts') --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="//use.fontawesome.com/5ac93d4ca8.js"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/js/bootstrap4-rating-input.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/toastr.min.js') }}"></script>
    {{-- @include('frontend.partials.ajax-login-form-js') --}}
{{-- @endsection --}}
