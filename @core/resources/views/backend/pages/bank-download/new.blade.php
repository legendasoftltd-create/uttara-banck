@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
@endsection
@section('site-title')
    {{__('New Bank Download')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
            </div>
            <div class="col-lg-12">
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('New Bank Download')}}</h4>
                            <a href="{{route('admin.bank.download')}}" class="btn btn-primary">{{__('All Downloads')}}</a>
                        </div>

                        <form action="{{route('admin.bank.download.new')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}" required>
                            </div>
                            <div class="d-flex">
                                <div class="form-group d-flex align-items-baseline">
                                    <label class="form-control-label pr-4" for="category_id">{{__('Category')}}:</label>
                                    <select name="category_id" id="category_id" class="form-control nice-select" required onchange="loadSubcategories()">
                                        <option value="">{{__('Select Category')}}</option>
                                        @foreach($all_categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group d-flex align-items-baseline">
                                    <label class="form-control-label pr-4 pl-4 ml-4" for="subcategory_id">{{__('Sub Category')}}:</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control nice-select">
                                        <option value="">{{__('Select Subcategory')}}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <textarea name="description" id="description" class="form-control" placeholder="{{__('Description')}}"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="file">{{__('File')}}</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt,.csv">
                                <small class="form-text text-muted">{{__('Supported formats: Images (JPG, PNG, GIF, WebP), Documents (PDF, DOC, DOCX, XLS, XLSX), Archives (ZIP, RAR), Text & CSV. Max 100MB')}}</small>
                            </div>

                            <div class="form-group">
                                <label for="publish_date">{{__('Publish Date')}}</label>
                                <input type="text" name="publish_date" id="publish_date" class="form-control publish-date-picker" value="{{old('publish_date')}}" placeholder="yyyy-mm-dd" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="publish">{{__('Publish')}}</option>
                                    <option value="draft">{{__('Draft')}}</option>
                                </select>
                            </div>

                            <div class="form-group" hidden>
                                <label for="lang">{{__('Language')}}</label>
                                <select name="lang" id="lang" class="form-control">
                                    @foreach($all_languages as $language)
                                        <option value="{{ $language->slug }}" @if($language->default) selected @endif>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add Download')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.publish-date-picker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom'
            });
        });

        function loadSubcategories() {
            const categoryId = document.getElementById('category_id').value;
            if (categoryId) {
                fetch('{{ route("admin.bank.download.subcategories.by.category", ":id") }}'.replace(':id', categoryId))
                    .then(response => response.json())
                    .then(data => {
                        const subcategorySelect = document.getElementById('subcategory_id');
                        subcategorySelect.innerHTML = '<option value="">{{__('Select Subcategory')}}</option>';
                        data.subcategories.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.title;
                            subcategorySelect.appendChild(option);
                        });
                    });
            }
        }
    </script>
@endsection
