@extends('backend.admin-master')
@section('site-title')
    {{__('Board of Directors')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 0 !important;
        }
        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
            display: inline-block;
        }
    </style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- messages -->
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Member List --}}
            <div class="@if(check_page_permission_by_string('Board of Director Create') || check_page_permission_by_string('Team Members')) col-lg-8 @else col-lg-12 @endif mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Board of Director Members')}}</h4>
                        @if(check_page_permission_by_string('Board of Director Delete') || check_page_permission_by_string('Team Members'))
                        <div class="bulk-delete-wrapper">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value="">{{__('Bulk Action')}}</option>
                                    <option value="delete">{{__('Delete')}}</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                            </div>
                        </div>
                        @endif

                        {{-- Language Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a = 0; @endphp
                            @foreach($all_members as $langKey => $group)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"
                                       data-toggle="tab" href="#bod_tab_{{$langKey}}" role="tab">
                                        {{get_language_by_slug($langKey)}}
                                    </a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>

                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b = 0; @endphp
                            @foreach($all_members as $langKey => $group)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="bod_tab_{{$langKey}}" role="tabpanel">
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default">
                                            <thead>
                                                @if(check_page_permission_by_string('Board of Director Delete') || check_page_permission_by_string('Team Members'))
                                                <th class="no-sort">
                                                    <div class="mark-all-checkbox">
                                                        <input type="checkbox" class="all-checkbox">
                                                    </div>
                                                </th>
                                                @endif
                                                <th>{{__('ID')}}</th>
                                                <th>{{__('Image')}}</th>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Designation')}}</th>
                                                <th>{{__('Order')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </thead>
                                            <tbody>
                                            @foreach($group->sortBy(function($m){ return $m->order_by ?: 999999; }) as $data)
                                                @php $img_url = ''; @endphp
                                                <tr>
                                                    @if(check_page_permission_by_string('Board of Director Delete') || check_page_permission_by_string('Team Members'))
                                                    <td>
                                                        <div class="bulk-checkbox-wrapper">
                                                            <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                        </div>
                                                    </td>
                                                    @endif
                                                    <td>{{$data->id}}</td>
                                                    <td>
                                                        @php $brand_img = get_attachment_image_by_id($data->image, null, true); @endphp
                                                        @if(!empty($brand_img))
                                                            <div class="attachment-preview">
                                                                <div class="thumbnail">
                                                                    <div class="centered">
                                                                        <img class="avatar user-thumb" src="{{$brand_img['img_url']}}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php $img_url = $brand_img['img_url']; @endphp
                                                        @endif
                                                    </td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->designation}}</td>
                                                    <td>{{$data->order_by ?? 0}}</td>
                                                    <td>
                                                        @if(check_page_permission_by_string('Board of Director Delete') || check_page_permission_by_string('Team Members'))
                                                            <x-delete-popover :url="route('admin.board.of.director.delete', $data->id)"/>
                                                        @endif
                                                        @if(check_page_permission_by_string('Board of Director Edit') || check_page_permission_by_string('Team Members'))
                                                            <a href="#"
                                                               data-toggle="modal"
                                                               data-target="#bod_edit_modal"
                                                               class="btn btn-primary btn-xs mb-3 mr-1 bod_edit_btn"
                                                               data-id="{{$data->id}}"
                                                               data-action="{{route('admin.board.of.director.update')}}"
                                                               data-name="{{$data->name}}"
                                                               data-imageid="{{$data->image}}"
                                                               data-image="{{$img_url}}"
                                                               data-designation="{{$data->designation}}"
                                                               data-description="{{$data->description}}"
                                                               data-lang="{{$data->lang}}"
                                                               data-iconOne="{{$data->icon_one}}"
                                                               data-iconTwo="{{$data->icon_two}}"
                                                               data-iconThree="{{$data->icon_three}}"
                                                               data-iconOneUrl="{{$data->icon_one_url}}"
                                                               data-iconTwoUrl="{{$data->icon_two_url}}"
                                                               data-iconThreeUrl="{{$data->icon_three_url}}"
                                                               data-order_by="{{$data->order_by}}">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @php $b++; @endphp
                            @endforeach

                            @if($all_members->isEmpty())
                                <div class="text-center py-4 text-muted">{{__('No board members found. Add one on the right.')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(check_page_permission_by_string('Board of Director Create') || check_page_permission_by_string('Team Members'))
            {{-- Add Form --}}
            <div class="col-lg-4 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Board Member')}}</h4>
                        <form action="{{route('admin.board.of.director')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="bod_lang">{{__('Language')}}</label>
                                <select name="lang" class="form-control" id="bod_lang">
                                    @foreach($all_languages as $lang)
                                        <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bod_name">{{__('Name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bod_name" name="name" placeholder="{{__('Full Name')}}">
                            </div>
                            <div class="form-group">
                                <label for="bod_designation">{{__('Designation')}} <span class="text-danger">*</span></label>
                                <select name="designation" id="bod_designation" class="form-control">
                                    <option value="">{{__('-- Select Designation --')}}</option>
                                    @foreach($all_designations as $desig)
                                        <option value="{{$desig->name}}">{{$desig->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    <a href="{{route('admin.designation')}}" target="_blank">{{__('+ Manage Designations')}}</a>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="bod_order_by">{{__('Order By')}}</label>
                                <select name="order_by" id="bod_order_by" class="form-control">
                                    <option value="">{{__('-- Select Order --')}}</option>
                                    @for($o = 1; $o <= 100; $o++)
                                        <option value="{{$o}}">{{$o}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bod_description">{{__('Description / Bio')}}</label>
                                <input type="hidden" name="description" id="bod_description">
                                <div class="summernote"></div>
                            </div>

                            {{-- Social One --}}
                            <div class="form-group">
                                <label class="d-block">{{__('Social Profile One')}}</label>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary iconpicker-component"><i class="fab fa-linkedin"></i></button>
                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fab fa-linkedin" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                                <input type="hidden" id="bod_icon_one" value="fab fa-linkedin" name="icon_one">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="icon_one_url" placeholder="{{__('Social Profile One URL')}}">
                            </div>

                            {{-- Social Two --}}
                            <div class="form-group">
                                <label class="d-block">{{__('Social Profile Two')}}</label>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary iconpicker-component"><i class="fab fa-twitter"></i></button>
                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fab fa-twitter" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                                <input type="hidden" id="bod_icon_two" value="fab fa-twitter" name="icon_two">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="icon_two_url" placeholder="{{__('Social Profile Two URL')}}">
                            </div>

                            {{-- Social Three --}}
                            <div class="form-group">
                                <label class="d-block">{{__('Social Profile Three')}}</label>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary iconpicker-component"><i class="fab fa-facebook-f"></i></button>
                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fab fa-facebook-f" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                                <input type="hidden" id="bod_icon_three" value="fab fa-facebook-f" name="icon_three">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="icon_three_url" placeholder="{{__('Social Profile Three URL')}}">
                            </div>

                            {{-- Image --}}
                            <div class="form-group">
                                <label>{{__('Photo')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="image">
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                            data-btntitle="{{__('Select Photo')}}"
                                            data-modaltitle="{{__('Upload Photo')}}"
                                            data-toggle="modal"
                                            data-target="#media_upload_modal">
                                        {{__('Upload Photo')}}
                                    </button>
                                </div>
                                <small>{{__('Recommended: 270x280')}}</small>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 btn-block">{{__('Add Board Member')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="bod_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Board Member')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="#" id="bod_edit_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="bod_edit_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Language')}}</label>
                                    <select name="lang" class="form-control" id="bod_edit_lang">
                                        @foreach($all_languages as $lang)
                                            <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Order By')}}</label>
                                    <select name="order_by" id="bod_edit_order_by" class="form-control">
                                        <option value="">{{__('-- Select Order --')}}</option>
                                        @for($o = 1; $o <= 100; $o++)
                                            <option value="{{$o}}">{{$o}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{__('Name')}}</label>
                            <input type="text" class="form-control" id="bod_edit_name" name="name">
                        </div>
                        <div class="form-group">
                            <label>{{__('Designation')}}</label>
                            <select name="designation" id="bod_edit_designation" class="form-control">
                                <option value="">{{__('-- Select Designation --')}}</option>
                                @foreach($all_designations as $desig)
                                    <option value="{{$desig->name}}">{{$desig->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{__('Description / Bio')}}</label>
                            <input type="hidden" name="description" id="bod_edit_description">
                            <div class="summernote"></div>
                        </div>

                        {{-- Edit Social Icons --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">{{__('Social One')}}</label>
                                    <div class="btn-group edit_icon_one">
                                        <button type="button" class="btn btn-primary iconpicker-component"><i class="fas fa-exclamation-triangle"></i></button>
                                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input type="hidden" id="bod_edit_icon_one" name="icon_one" value="">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="bod_edit_icon_one_url" name="icon_one_url" placeholder="URL">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">{{__('Social Two')}}</label>
                                    <div class="btn-group edit_icon_two">
                                        <button type="button" class="btn btn-primary iconpicker-component"><i class="fas fa-exclamation-triangle"></i></button>
                                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input type="hidden" id="bod_edit_icon_two" name="icon_two" value="">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="bod_edit_icon_two_url" name="icon_two_url" placeholder="URL">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">{{__('Social Three')}}</label>
                                    <div class="btn-group edit_icon_three">
                                        <button type="button" class="btn btn-primary iconpicker-component"><i class="fas fa-exclamation-triangle"></i></button>
                                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input type="hidden" id="bod_edit_icon_three" name="icon_three" value="">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="bod_edit_icon_three_url" name="icon_three_url" placeholder="URL">
                                </div>
                            </div>
                        </div>

                        {{-- Edit Image --}}
                        <div class="form-group">
                            <label>{{__('Photo')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" id="bod_edit_image" name="image" value="">
                                <button type="button" class="btn btn-info media_upload_form_btn"
                                        data-btntitle="{{__('Select Photo')}}"
                                        data-modaltitle="{{__('Upload Photo')}}"
                                        data-toggle="modal"
                                        data-target="#media_upload_modal">
                                    {{__('Upload Photo')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/codemirror.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script>
        $(document).ready(function () {

            // Bulk delete
            $('#bulk_delete_btn').on('click', function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allIds = [];
                $('.bulk-checkbox:checked').each(function () {
                    allIds.push($(this).val());
                });
                if (allIds.length && bulkOption === 'delete') {
                    $(this).text('{{__('Deleting...')}}');
                    $.ajax({
                        type: 'POST',
                        url: "{{route('admin.board.of.director.bulk.action')}}",
                        data: { _token: "{{csrf_token()}}", ids: allIds },
                        success: function () { location.reload(); }
                    });
                }
            });

            // Select All
            $('.all-checkbox').on('change', function () {
                var checked = $(this).is(':checked');
                $(this).closest('table').find('.bulk-checkbox').prop('checked', checked);
            });

            // Edit modal populate
            $(document).on('click', '.bod_edit_btn', function () {
                var el = $(this);
                var form = $('#bod_edit_form');

                form.attr('action', el.data('action'));
                form.find('#bod_edit_id').val(el.data('id'));
                form.find('#bod_edit_name').val(el.data('name'));
                form.find('#bod_edit_designation').val(el.data('designation')).trigger('change');
                form.find('#bod_edit_order_by').val(el.data('order_by'));
                form.find('#bod_edit_description').val(el.data('description'));
                form.find('#bod_edit_description').next('.summernote').summernote('code', el.data('description') || '');
                form.find('#bod_edit_icon_one').val(el.data('iconone'));
                form.find('#bod_edit_icon_two').val(el.data('icontwo'));
                form.find('#bod_edit_icon_three').val(el.data('iconthree'));
                form.find('#bod_edit_icon_one_url').val(el.data('icononeurl'));
                form.find('#bod_edit_icon_two_url').val(el.data('icontwourl'));
                form.find('#bod_edit_icon_three_url').val(el.data('iconthreeurl'));
                form.find('#bod_edit_lang option[value="' + el.data('lang') + '"]').attr('selected', true);

                // Icon pickers
                form.find('.edit_icon_one .icp-dd').attr('data-selected', el.data('iconone'));
                form.find('.edit_icon_one .iconpicker-component i').attr('class', el.data('iconone'));
                form.find('.edit_icon_two .icp-dd').attr('data-selected', el.data('icontwo'));
                form.find('.edit_icon_two .iconpicker-component i').attr('class', el.data('icontwo'));
                form.find('.edit_icon_three .icp-dd').attr('data-selected', el.data('iconthree'));
                form.find('.edit_icon_three .iconpicker-component i').attr('class', el.data('iconthree'));

                // Image preview
                var imageid = el.data('imageid');
                var image   = el.data('image');
                if (imageid) {
                    form.find('.media-upload-btn-wrapper .img-wrap').html(
                        '<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="' + image + '"></div></div></div>'
                    );
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Photo');
                }
            });

            // Icon picker init
            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function (e) {
                $(this).parent().parent().children('input[type="hidden"]').val(e.iconpickerValue);
            });

            function syncContent(editor, contents) {
                let final = typeof iFrameFilterInSummernote === 'function' ? iFrameFilterInSummernote(contents) : contents;
                $(editor).prev('input').val(final);
            }

            $('.summernote').summernote({
                disableDragAndDrop: true,
                height: 250,
                codeviewFilter: false,
                codeviewIframeFilter: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'hr']],
                    ['history', ['undo', 'redo']],
                    ['view', ['fullscreen', 'codeview']],
                ],
                codemirror: { theme: 'default', mode: 'text/html', lineNumbers: true, lineWrapping: true },
                callbacks: {
                    onChange: function(contents) { syncContent(this, contents); },
                    onChangeCodeview: function(contents) { syncContent(this, contents); },
                    onBlurCodeview: function(contents) { syncContent(this, contents); }
                }
            });
        });
    </script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.table-wrap > table').DataTable({
                "order": [[1, "desc"]],
                columnDefs: [{ targets: 'no-sort', orderable: false }]
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
