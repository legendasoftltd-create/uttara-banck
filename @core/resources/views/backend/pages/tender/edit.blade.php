@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/nice-select.css') }}">
@endsection
@section('site-title')
    {{ __('Edit Tender') }}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">{{ __('Edit Tender') }}</h4>
                            <a href="{{ route('admin.tender.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Tenders') }}
                            </a>
                        </div>

                        <form action="{{ route('admin.tender.update', $tender->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('Tender Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title', $tender->title) }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Notice Date') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="notice_date" class="form-control"
                                               value="{{ old('notice_date', $tender->notice_date ? $tender->notice_date->format('Y-m-d') : '') }}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Expiry / Last Date') }}</label>
                                        <input type="date" name="expiry_date" class="form-control"
                                               value="{{ old('expiry_date', $tender->expiry_date ? $tender->expiry_date->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Current file --}}
                            @if($tender->file)
                                <div class="form-group">
                                    <label>{{ __('Current File') }}</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ asset('assets/uploads/tenders/' . $tender->file) }}"
                                           target="_blank" class="btn btn-info btn-sm">
                                            <i class="ti-eye"></i> {{ __('View Current File') }}
                                        </a>
                                        <span class="text-muted ml-2" style="font-size:12px;">
                                            {{ $tender->file }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>{{ __('Replace File (PDF)') }}</label>
                                <input type="file" name="file" class="form-control"
                                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                <small class="text-muted">{{ __('Upload a new file to replace the existing one. Max 20MB.') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Additional Description') }}</label>
                                <textarea name="description" id="description"
                                          class="form-control summernote">{{ old('description', $tender->description) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control nice-select">
                                            <option value="publish"  {{ old('status', $tender->status) == 'publish'  ? 'selected' : '' }}>{{ __('Publish') }}</option>
                                            <option value="draft"    {{ old('status', $tender->status) == 'draft'    ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                            <option value="archive"  {{ old('status', $tender->status) == 'archive'  ? 'selected' : '' }}>{{ __('Archive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Language') }}</label>
                                        <input type="text" class="form-control"
                                               value="{{ $tender->lang }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">
                                {{ __('Update Tender') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/backend/js/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/backend/js/nice-select.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({ height: 200 });
            $('.nice-select').niceSelect();
        });
    </script>
@endsection
