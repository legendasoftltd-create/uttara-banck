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
    <div class="empty-height-50"></div>
    @if(!empty($product->updated_date_status))
        <div class="container mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-updated-date-wrap text-right" style="font-size: 14px; color: #4b5563; font-weight: 500; padding: 6px 12px; background: #f8fafc; border-left: 4px solid #008649; border-radius: 4px; display: inline-block; float: right; margin-bottom: 20px;">
                        <i class="fas fa-calendar-alt text-success mr-1"></i> {{__('Last Updated:')}} <span class="text-dark font-weight-bold">{{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->format('d-M-Y') : '' }}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endif
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
                    <div class="image-container" style="position: relative;">
                    @php
                        $image_details = get_attachment_image_by_id($data->image, 'full');
                    @endphp
                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $data->title }}" >
                        @if(!empty($data->image_courtesy))
                            <div class="product-image-courtesy-watermark">
                                {{ $data->image_courtesy }}
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="product-name"><a href="{{route('frontend.products.single',$data->slug)}}">{{ $data->title }}</a></h3>
                    </div>
                </div>
            @endforeach
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
@endsection
{{-- @section('scripts') --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="//use.fontawesome.com/5ac93d4ca8.js"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/js/bootstrap4-rating-input.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/toastr.min.js') }}"></script>
    {{-- @include('frontend.partials.ajax-login-form-js') --}}
{{-- @endsection --}}
