@extends('frontend.frontend-page-master')
@php
    $page_name = get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_name');
    $isCategoryPage = isset($current_category);
@endphp
@section('site-title')
    {{ $page_name }}
@endsection
@section('page-title')
    {{ $page_name ?? 'Bank Downloads' }}
    {{ isset($current_category) ? ': ' . $current_category->title : (isset($current_subcategory) ? ': ' . $current_subcategory->title : '') }}
@endsection
@section('page-meta-data')
    <meta name="description"
        content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_tags') }}">
    {!! render_og_meta_image_by_attachment_id(
        get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_image'),
    ) !!}
@endsection

@php
    if (!function_exists('bank_download_first_file')) {
        function bank_download_first_file($download)
        {
            $files = is_array($download->files) ? $download->files : [];
            return count($files) ? $files[0] : null;
        }
    }
@endphp

@section('content')
    <section class="bank-downloads-page padding-top-60 padding-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @if ($isCategoryPage)
                        <div id="scroll-down"></div>
                        <div class="empty-height-50"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center title-color">
                                    {{ $current_category->title }}
                                </h2>
                                <div class="title-seperator"></div>
                            </div>
                        </div>
                    @else
                        <div id="scroll-down"></div>
                        <div class="empty-height-50"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center title-color">
                                    {{ $page_title ?? 'Important Downloads' }}
                                </h2>
                                <div class="title-seperator"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($isCategoryPage)
                <div class="download-pages">
                    <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center"
                        style="border-collapse: collapse; max-width:1230px;">
                        <thead>
                            <tr bgcolor="#008649">
                                <th class="text-center">
                                    <font color="#ffffff"><b>Sl No.</b></font>
                                </th>
                                <th width="70%" class="text-center">
                                    <font color="#ffffff"><b>Title</b></font>
                                </th>
                                <th class="text-center">
                                    <font color="#ffffff"><b>View</b></font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($all_categories as $key => $category) --}}
                                <tr class="dropdown-parent" data-dropdown="{{ $current_category->id }}">
                                    <td class="text-center">{{ 1 }}</td>
                                    <td>{{ $current_category->title }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-view dropdown-toggle-parent" href="#" data-toggle="modal"
                                            data-target="#exampleModalCenter">View</a>
                                    </td>
                                </tr>
                                @foreach ($current_category->downloads as $download_key => $download)
                                    @php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; @endphp
                                    @php $file = $files[0] ?? null; @endphp
                                    <tr class=" dropdown-child" data-parent="{{ $current_category->id }}">
                                        <td class="text-center">{{ $download_key + 1 }}</td>
                                        <td>{{ $download->title }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                data-title="{{ $download->title }}"
                                                data-file="{{ $file ? asset('assets/uploads/bank-downloads/' . $file['name']) : '' }}">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($current_category->subcategories as $subcategory_key => $subcategory)
                                    <tr class="dropdown-child dropdown-parent" data-parent="{{ $current_category->id }}"
                                        data-dropdown="s-{{ $subcategory_key }}">
                                        <td class="text-center"></td>
                                        <td>{{ $subcategory->title }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-view dropdown-toggle-parent" href="#">View</a>
                                            {{-- <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter" data-title="{{ $subcategory->title }}" data-file="{{ asset($subcategory->file) }}">View</a> --}}
                                        </td>
                                    </tr>

                                    @foreach ($subcategory->downloads as $sdownload_key => $download)
                                        @php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; @endphp
                                        @php $file = $files[0] ?? null; @endphp
                                        <tr class="dropdown-child" data-parent="s-{{ $subcategory_key }}">
                                            <td class="text-center">{{ $sdownload_key + 1 }}</td>
                                            <td>{{ $download->title }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                    data-title="{{ $download->title }}"
                                                    data-file="{{ $file ? asset('assets/uploads/bank-downloads/' . $file['name']) : '' }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                        </tbody>
                    </table>
                </div>

                <br><br>
                <div class="row">
                    <div class="col-md-12">
                         <a class="btn btn-secoundary btn-block" href="{{ route('frontend.bank.downloads') }}">View All Downloads</a>
                    </div>
                </div>
                
            @else  
                <div class="download-pages">
                    <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center"
                        style="border-collapse: collapse; max-width:1230px;">
                        <thead>
                            <tr bgcolor="#008649">
                                <th class="text-center">
                                    <font color="#ffffff"><b>Sl No.</b></font>
                                </th>
                                <th width="70%" class="text-center">
                                    <font color="#ffffff"><b>Title</b></font>
                                </th>
                                <th class="text-center">
                                    <font color="#ffffff"><b>View</b></font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_categories as $key => $category)
                                <tr class="dropdown-parent" data-dropdown="{{ $key }}">
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-view dropdown-toggle-parent" href="#" data-toggle="modal"
                                            data-target="#exampleModalCenter">View</a>
                                    </td>
                                </tr>
                                @foreach ($category->downloads as $download_key => $download)
                                    @php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; @endphp
                                    @php $file = $files[0] ?? null; @endphp
                                    <tr class=" dropdown-child" data-parent="{{ $key }}">
                                        <td class="text-center">{{ $download_key + 1 }}</td>
                                        <td>{{ $download->title }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                data-title="{{ $download->title }}"
                                                data-file="{{ $file ? asset('assets/uploads/bank-downloads/' . $file['name']) : '' }}">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($category->subcategories as $subcategory_key => $subcategory)
                                    <tr class="dropdown-child dropdown-parent" data-parent="{{ $key }}"
                                        data-dropdown="s-{{ $subcategory_key }}">
                                        <td class="text-center"></td>
                                        <td>{{ $subcategory->title }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-view dropdown-toggle-parent" href="#">View</a>
                                            {{-- <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter" data-title="{{ $subcategory->title }}" data-file="{{ asset($subcategory->file) }}">View</a> --}}
                                        </td>
                                    </tr>

                                    @foreach ($subcategory->downloads as $sdownload_key => $download)
                                        @php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; @endphp
                                        @php $file = $files[0] ?? null; @endphp
                                        <tr class="dropdown-child" data-parent="s-{{ $subcategory_key }}">
                                            <td class="text-center">{{ $sdownload_key + 1 }}</td>
                                            <td>{{ $download->title }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                    data-title="{{ $download->title }}"
                                                    data-file="{{ $file ? asset('assets/uploads/bank-downloads/' . $file['name']) : '' }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" style="overflow-y: scroll !important;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;">
            <div class="modal-content" style="background-color: #FFF; max-width: 991px; width: 100%; margin: 0 auto;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
