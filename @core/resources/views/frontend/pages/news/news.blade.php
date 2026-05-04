@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('blog_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('blog_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('blog_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('blog_page_'.$user_select_lang_slug.'_meta_tags')}}">
    {!! render_og_meta_image_by_attachment_id(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection
@section('content')

    {{-- <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @foreach($all_blogs as $data)
                        <x-frontend.blog.grid :blog="$data" :margin="true"/>
                    @endforeach
                    <nav class="pagination-wrapper" aria-label="Page navigation ">
                       {{$all_blogs->links()}}
                    </nav>
                </div>
                <div class="col-lg-4">
                   @include('frontend.pages.blog.sidebar')
                </div>
            </div>
        </div>
    </section> --}}

    <section class="news-section">
            <div class="container">
                <div class="empty-height-50"></div>
                <div class="top-grid">
                    <article class="main-feature">
                        @if(!empty($recent_last_blogs))
                            <div class="feature-content">
                                <a href="{{route('frontend.news.single',$recent_last_blogs->slug)}}">
                                @php $image_details = get_attachment_image_by_id($recent_last_blogs->image, 'full'); @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $recent_last_blogs->title }}" class="main-img">
                                </a>
                            </div>
                            <div class="feature-text">
                                <a href="{{route('frontend.news.single',$recent_last_blogs->slug)}}">
                                    <h2>{{ $recent_last_blogs->title }}</h2>
                                </a>
                                    <p>{{ $recent_last_blogs->excerpt }}</p>
                                <p class="news-time">{{ timeAgo($recent_last_blogs->created_at) }}</p>
                            </div>
                        @endif
                    </article>

                    <aside class="sidebar-news">
                        @foreach($recent_last_blogs_skip_last as $data)
                            <div class="side-item">
                                <div class="side-text">
                                    <a href="{{route('frontend.news.single',$data->slug)}}">
                                        <h3>{{ $data->title }}</h3>
                                    </a>
                                    <p class="news-time">{{ timeAgo($data->created_at) }}</p>
                                </div>
                                <div class="side-img-wrapper">
                                    <a href="{{route('frontend.news.single',$data->slug)}}">
                                        @php $image_details = get_attachment_image_by_id($data->image, 'full'); @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $data->title }}">
                                    </a>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </aside>
                </div>

                <section class="bottom-grid">
                    @foreach($all_blogs as $data)
                        <article class="card">
                            <a href="{{route('frontend.news.single',$data->slug)}}">
                                @php $image_details = get_attachment_image_by_id($data->image, 'full'); @endphp
                                <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $data->title }}">
                            </a>
                            <div class="card-body">
                                <a href="{{route('frontend.news.single',$data->slug)}}">
                                    <h3>{{ $data->title }}</h3>
                                </a>
                                <p class="news-time">{{ timeAgo($data->created_at) }}</p>
                            </div>
                        </article>
                    @endforeach
                </section>
                <div class="pagination-container">
                {{$all_blogs->links()}}
                </div>
            </div>
        </section>
@endsection
