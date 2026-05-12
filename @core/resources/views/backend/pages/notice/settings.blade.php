@extends('backend.admin-master')
@section('site-title')
    {{ __('Notice Page Settings') }}
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
                        <div class="header-wrap d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">{{ __('Notice Page Settings') }}</h4>
                            <a href="{{ route('admin.notice.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Notices') }}
                            </a>
                        </div>
                        <form action="{{ route('admin.notice.page.settings.update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('Page Slug') }}</label>
                                <input type="text" name="notice_page_slug" class="form-control"
                                       value="{{ get_static_option('notice_page_slug') ?? 'notice' }}">
                                <small class="text-muted">{{ __('URL slug for the notice listing page (e.g. "notice")') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Page Title') }}</label>
                                <input type="text" name="notice_page_title" class="form-control"
                                       value="{{ get_static_option('notice_page_title') ?? 'Notice' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Meta Description') }}</label>
                                <textarea name="notice_page_meta_description" class="form-control" rows="3">{{ get_static_option('notice_page_meta_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Meta Tags') }}</label>
                                <input type="text" name="notice_page_meta_tags" class="form-control"
                                       value="{{ get_static_option('notice_page_meta_tags') }}"
                                       placeholder="{{ __('comma separated tags') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">{{ __('Save Settings') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
