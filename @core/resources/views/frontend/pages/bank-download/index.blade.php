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

@section('style')
    <style>
        /* Table General Styling */
        .download-pages table {
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 8px;
            overflow: hidden;
        }
        .download-pages table thead tr {
            background-color: #008649 !important;
        }
        .download-pages table th {
            padding: 14px 16px !important;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none !important;
        }
        .download-pages table td {
            padding: 12px 16px !important;
            border: 1px solid #f3f4f6 !important;
            font-size: 15px;
            vertical-align: middle;
        }

        /* Parent category row */
        tr.dropdown-parent {
            background-color: #ffffff !important;
            font-weight: 700;
            color: #111827;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        tr.dropdown-parent:hover {
            background-color: #f9fafb !important;
        }
        tr.dropdown-parent td:nth-child(2) {
            position: relative;
            padding-right: 40px !important;
            color: #0f172a;
        }
        /* Dropdown arrow on parent */
        tr.dropdown-parent td:nth-child(2)::after {
            content: "\f107"; /* FontAwesome Down Angle */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #94a3b8;
            transition: all 0.3s ease;
        }
        tr.dropdown-parent.dropdown-open {
            background-color: #f0fdf4 !important; /* soft green hint when open */
        }
        tr.dropdown-parent.dropdown-open td:nth-child(2) {
            color: #008649;
        }
        tr.dropdown-parent.dropdown-open td:nth-child(2)::after {
            transform: translateY(-50%) rotate(-180deg);
            color: #008649;
        }

        /* Child row styling (nested menu look) */
        tr.dropdown-child {
            background-color: #f8fafc !important; /* Slate grey background for contrast */
            border-left: 3px solid #008649 !important;
        }
        tr.dropdown-child td {
            border: 1px solid #e2e8f0 !important;
        }
        tr.dropdown-child td:nth-child(2) {
            padding-left: 45px !important;
            position: relative;
            color: #475569;
            font-weight: 500;
        }
        /* Sub-item connector line/arrow */
        tr.dropdown-child td:nth-child(2)::before {
            content: "↳";
            position: absolute;
            left: 22px;
            top: 48%;
            transform: translateY(-50%);
            color: #008649;
            font-weight: 700;
            font-size: 16px;
        }

        /* View Button Resizing */
        .download-pages table .btn-view {
            padding: 5px 14px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            border-radius: 4px !important;
            border: 1px solid #008649 !important;
            background-color: transparent !important;
            color: #008649 !important;
            width: auto !important;
            min-width: 65px;
            box-shadow: none !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            display: inline-block;
        }
        .download-pages table .btn-view:hover {
            background-color: #008649 !important;
            color: #ffffff !important;
        }
    </style>
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
