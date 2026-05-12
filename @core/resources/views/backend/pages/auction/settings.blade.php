@extends('backend.admin-master')
@section('site-title')
    {{ __('Auction Page Settings') }}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">{{ __('Auction Page Settings') }}</h4>
                        <form action="{{ route('admin.auction.page.settings.update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('Page Slug') }}</label>
                                <input type="text" name="auction_page_slug" class="form-control" value="{{ get_static_option('auction_page_slug') ?? 'auction' }}">
                                <small class="text-muted">{{ __('e.g. auction') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Page Title') }}</label>
                                <input type="text" name="auction_page_title" class="form-control" value="{{ get_static_option('auction_page_title') ?? 'Auction Notice' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Meta Description') }}</label>
                                <textarea name="auction_page_meta_description" class="form-control" rows="3">{{ get_static_option('auction_page_meta_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Meta Tags') }}</label>
                                <input type="text" name="auction_page_meta_tags" class="form-control" value="{{ get_static_option('auction_page_meta_tags') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">{{ __('Save Settings') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
