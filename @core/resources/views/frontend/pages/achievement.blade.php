@extends('frontend.frontend-page-master')

@section('site-title')
    {{__('Our Achievement')}}
@endsection
@section('page-title')
    {{__('Our Achievement')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{__('Our Achievement, Awards, Success')}}">
    <meta name="tags" content="{{__('achievement, awards, success, bank')}}">
@endsection
@section('content')

<style>
    /* Section Background - Off-white helps the white cards pop */
    .achievement-section {
        background-color: #fbfbfb;
        padding: 60px 0;
    }

    /* Refined Card Container */
    .achievement-card {
        background-color: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #eaeaea; /* Subtle border for clean definition */
        border-radius: 8px; /* Soft corporate corners */
        padding: 30px; /* Inner padding creates a framed document look */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    /* Elegant Hover State */
    .achievement-card:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06); 
        transform: translateY(-2px);
    }

    /* 1. Title on Top */
    .achievement-title {
        color: #008649; /* Deep Green */
        font-size: 1.4rem; 
        font-weight: 700;
        margin-bottom: 1.25rem;
        line-height: 1.4;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0; /* Underline separator adds structure */
    }

    /* 2. Image in the Middle */
    .achievement-image-wrapper {
        width: 100%;
        height: auto; 
        margin-bottom: 1.5rem;
        border-radius: 4px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .achievement-image-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover; 
        object-position: top center; /* Focuses on the top of certificates/photos */
    }

    /* 3. Description on Bottom */
    .achievement-desc {
        color: #000000; /* High contrast dark gray */
        font-size: 15px; 
        line-height: 1.7;
        margin: 0;
        text-align: justify; /* Aligns text cleanly like a formal document */
    }

</style>

<section class="achievement-section">
    <div class="container"> 
        @if($all_achievements->count())
            <div class="row g-4 justify-content-center">
                @foreach($all_achievements as $item)
                    <div class="col-12 col-lg-6">
                        <article class="achievement-card">
                            
                            <h3 class="achievement-title">
                                {{ $item->title }}
                            </h3>

                            <div class="achievement-image-wrapper">
                                {!! render_image_markup_by_attachment_id($item->image) !!}
                            </div>

                            @if($item->description)
                                <div class="achievement-desc flex-grow-1">
                                    {{ $item->description }}
                                </div>
                            @endif

                        </article>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted py-5">{{ __('No achievements found.') }}</p>
        @endif
        @if($all_achievements->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $all_achievements->links() }}
            </div>
        @endif
    </div>
</section>
@endsection