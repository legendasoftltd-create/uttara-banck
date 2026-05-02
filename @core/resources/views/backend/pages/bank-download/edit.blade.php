@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
@endsection
@section('site-title')
    {{__('Edit Bank Download')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
            </div>
            <div class="col-lg-12">
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('Edit Bank Download')}}</h4>
                            <a href="{{route('admin.bank.download')}}" class="btn btn-primary">{{__('All Downloads')}}</a>
                        </div>
                        <form action="{{route('admin.bank.download.update', $download->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$download->id}}">
                            
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$download->title}}" required>
                            </div>

                            <div class="d-flex">
                                <div class="form-group d-flex align-items-baseline">
                                    <label class="form-control-label pr-4" for="category_id">{{__('Category')}}:</label>
                                    <select name="category_id" id="category_id" class="form-control nice-select" required onchange="loadSubcategories()">
                                        <option value="">{{__('Select Category')}}</option>
                                        @foreach($all_categories as $category)
                                            <option value="{{ $category->id }}" @if($download->category_id == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group d-flex align-items-baseline">
                                    <label class="form-control-label pr-4 pl-4 ml-4" for="subcategory_id">{{__('Sub Category')}}:</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control nice-select">
                                        <option value="">{{__('Select Subcategory')}}</option>
                                        @foreach($all_subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" @if($download->subcategory_id == $subcategory->id) selected @endif>{{ $subcategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <textarea name="description" id="description" class="form-control">{{ $download->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>{{__('Current File')}}</label>
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-body">
                                        @php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; @endphp
                                        @if(count($files) > 0)
                                            @php $file = $files[0]; @endphp
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-2"><strong>{{ $file['original_name'] }}</strong></p>
                                                    <p class="mb-0 text-muted">
                                                        {!! get_file_type_badge($file['original_name']) !!}
                                                        <span class="ml-2">{{ isset($file['size']) ? number_format($file['size'] / 1024, 2) . ' KB' : 'N/A' }}</span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <a href="{{ asset('assets/uploads/bank-downloads/' . $file['name']) }}" class="btn btn-info btn-sm" download>{{__('Download')}}</a>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-muted">{{__('No file uploaded yet')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="file">{{__('Change File')}}</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt,.csv">
                                <small class="form-text text-muted">{{__('Supported formats: Images (JPG, PNG, GIF, WebP), Documents (PDF, DOC, DOCX, XLS, XLSX), Archives (ZIP, RAR), Text & CSV. Max 100MB. Upload a new file to replace the current one')}}</small>
                            </div>

                            <div class="form-group">
                                <label for="publish_date">{{__('Publish Date')}}</label>
                                <input type="text" name="publish_date" id="publish_date" class="form-control publish-date-picker" value="{{ optional($download->publish_date)->format('Y-m-d') }}" placeholder="yyyy-mm-dd" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="publish" @if($download->status == 'publish') selected @endif>{{__('Publish')}}</option>
                                    <option value="draft" @if($download->status == 'draft') selected @endif>{{__('Draft')}}</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Download')}}</button>
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
                        const currentSubcategoryId = '{{ $download->subcategory_id }}';
                        subcategorySelect.innerHTML = '<option value="">{{__('Select Subcategory')}}</option>';
                        data.subcategories.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.title;
                            if (sub.id == currentSubcategoryId) option.selected = true;
                            subcategorySelect.appendChild(option);
                        });
                    });
            }
        }
    </script>
@endsection
