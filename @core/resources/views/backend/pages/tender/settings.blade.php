@extends('backend.admin-master')
@section('site-title')
    {{ __('Tender Page Settings') }}
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
                            <h4 class="header-title">{{ __('Tender Page Settings') }}</h4>
                            <a href="{{ route('admin.tender.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Tenders') }}
                            </a>
                        </div>
                        <form action="{{ route('admin.tender.page.settings.update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('Page Slug') }}</label>
                                <input type="text" name="tender_page_slug" class="form-control"
                                       value="{{ get_static_option('tender_page_slug') ?? 'tender' }}">
                                <small class="text-muted">{{ __('URL slug for the tender listing page (e.g. "tender")') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Page Title') }}</label>
                                <input type="text" name="tender_page_title" class="form-control"
                                       value="{{ get_static_option('tender_page_title') ?? 'Tender Notice' }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Meta Description') }}</label>
                                <textarea name="tender_page_meta_description" class="form-control" rows="3">{{ get_static_option('tender_page_meta_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Meta Tags') }}</label>
                                <input type="text" name="tender_page_meta_tags" class="form-control"
                                       value="{{ get_static_option('tender_page_meta_tags') }}"
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
