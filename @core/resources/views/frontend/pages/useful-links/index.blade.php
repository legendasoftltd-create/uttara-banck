@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('useful_links_page_title') ?? __('Useful Links') }}
@endsection
@section('page-title')
    {{ get_static_option('useful_links_page_title') ?? __('Useful Links') }}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('useful_links_page_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('useful_links_page_meta_tags') }}">
@endsection

@section('style')
<style>
    .useful-links-section {
        padding: 50px 0 80px;
    }

    /* ── Link list ── */
    .useful-link-list {
        list-style: none;
        padding: 0;
        margin: 0;
        border-top: 1px solid #e0e0e0;
    }

    .useful-link-item {
        display: flex;
        align-items: center;
        padding: 18px 16px;
        border-bottom: 1px solid #e0e0e0;
        gap: 24px;
        transition: background 0.15s;
        text-decoration: none;
    }
    .useful-link-item:hover {
        background: #f9fffc;
        text-decoration: none;
    }

    /* Logo column */
    .useful-link-logo {
        width: 160px;
        min-width: 160px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .useful-link-logo img {
        max-width: 150px;
        max-height: 70px;
        width: auto;
        height: auto;
        object-fit: contain;
    }
    .useful-link-logo-placeholder {
        width: 60px;
        height: 60px;
        background: #f0f0f0;
        border: 1px solid #ddd;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .useful-link-logo-placeholder i {
        font-size: 22px;
        color: #bbb;
    }

    /* Title column */
    .useful-link-title {
        flex: 1;
        color: #1a6e32;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
    }

    .useful-links-empty {
        text-align: center;
        padding: 60px 20px;
        color: #999;
        font-size: 15px;
    }
</style>
@endsection

@section('content')
<section class="useful-links-section">
    <div class="container">

        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:700;">
                    {{ get_static_option('useful_links_page_title') ?? __('Useful Links') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                @if($links->isEmpty())
                    <div class="useful-links-empty">
                        {{ __('No useful links available.') }}
                    </div>
                @else
                <ul class="useful-link-list">
                    @foreach($links as $link)
                    <li>
                        <a class="useful-link-item"
                           href="{{ $link->url }}"
                           target="_blank"
                           rel="noopener noreferrer">

                            {{-- Logo --}}
                            <div class="useful-link-logo">
                                @if($link->image)
                                    {!! render_image_markup_by_attachment_id($link->image) !!}
                                @else
                                    <div class="useful-link-logo-placeholder">
                                        <i class="ti-link"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Title --}}
                            <span class="useful-link-title">{{ $link->title }}</span>

                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif

            </div>
        </div>

    </div>
</section>
@endsection
