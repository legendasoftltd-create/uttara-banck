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

                            <div class="form-group">
                                <label for="category_id">{{__('Category')}}</label>
                                <select name="category_id" id="category_id" class="form-control nice-select" required onchange="loadSubcategories()">
                                    <option value="">{{__('Select Category')}}</option>
                                    @foreach($all_categories as $category)
                                        <option value="{{ $category->id }}" @if($download->category_id == $category->id) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subcategory_id">{{__('Subcategory')}}</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control nice-select">
                                    <option value="">{{__('Select Subcategory')}}</option>
                                    @foreach($all_subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" @if($download->subcategory_id == $subcategory->id) selected @endif>{{ $subcategory->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <textarea name="description" id="description" class="form-control">{{ $download->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>{{__('Current Files')}}</label>
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-body">
                                        @php $files = is_array($download->files) ? $download->files : []; @endphp
                                        @if(count($files) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>{{__('File Name')}}</th>
                                                            <th>{{__('Size')}}</th>
                                                            <th>{{__('Action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($files as $file)
                                                            <tr>
                                                                <td>{{ $file['original_name'] }}</td>
                                                                <td>{{ isset($file['size']) ? number_format($file['size'] / 1024, 2) . ' KB' : 'N/A' }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-xs" onclick="deleteFile('{{ $file['name'] }}')">{{__('Delete')}}</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">{{__('No files uploaded yet')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="files">{{__('Add More Files')}}</label>
                                <input type="file" name="files[]" id="files" class="form-control" multiple>
                                <small class="info-text">{{__('You can add more files to this download')}}</small>
                            </div>

                            <div class="form-group">
                                <label for="publish_date">{{__('Publish Date')}}</label>
                                <input type="datetime-local" name="publish_date" id="publish_date" class="form-control" value="{{ optional($download->publish_date)->format('Y-m-d\TH:i') }}">
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

        function deleteFile(fileName) {
            if (confirm('{{__('Are you sure?')}}')) {
                fetch('{{ route("admin.bank.download.delete.file") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        download_id: '{{ $download->id }}',
                        file_name: fileName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    </script>
@endsection
