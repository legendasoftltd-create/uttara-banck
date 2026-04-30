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
    <meta name="description" content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_description') }}">
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

                        @php
                            $tableSections = collect([
                                [
                                    'title' => $current_category->title,
                                    'items' => $all_downloads,
                                    'is_subcategory' => false,
                                ],
                            ]);

                            if (!empty($subcategory_sections)) {
                                $tableSections = $tableSections->merge(
                                    $subcategory_sections->map(function ($subcategory) {
                                        return [
                                            'title' => $subcategory->title,
                                            'items' => $subcategory->downloads,
                                            'is_subcategory' => true,
                                        ];
                                    }),
                                );
                            }
                        @endphp

                        @foreach ($tableSections as $sectionIndex => $section)
                            @if ($sectionIndex > 0)
                                <div class="empty-height-50"></div>
                            @endif

                            @if ($section['is_subcategory'])
                                <div class="downloads-section-heading">
                                    <h3>{{ $section['title'] }}</h3>
                                </div>
                            @endif

                            <div class="downloads-table-wrapper">
                                <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1"
                                    align="center" class="downloads-table">
                                    <thead>
                                        <tr>
                                            <th width="10%" class="text-center">{{ __('Sl No.') }}</th>
                                            <th width="20%" class="text-center">{{ __('Date') }}</th>
                                            <th width="50%" class="text-center">{{ __('Title') }}</th>
                                            <th width="20%" class="text-center">{{ __('View') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($section['items'] as $key => $download)
                                            @php
                                                $firstFile = bank_download_first_file($download);
                                                $fileUrl = $firstFile ? asset('assets/uploads/bank-downloads/' . $firstFile['name']) : route('frontend.bank.downloads.single', $download->slug);
                                                $fileName = $firstFile['original_name'] ?? $download->title;
                                                $modalId = 'bank-download-preview-' . $sectionIndex . '-' . $download->id;
                                                $isPdf = $firstFile && \Illuminate\Support\Str::endsWith(strtolower($firstFile['name']), '.pdf');
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ optional($download->publish_date ?? $download->created_at)->format('Y-m-d') }}</td>
                                                <td>{{ $download->title }}</td>
                                                <td class="text-center">
                                                    @if ($firstFile)
                                                        <a href="{{ $fileUrl }}" class="btn btn-view" data-toggle="modal"
                                                            data-target="#{{ $modalId }}">
                                                            {{ __('View') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('frontend.bank.downloads.single', $download->slug) }}"
                                                            class="btn btn-view">
                                                            {{ __('Details') }}
                                                        </a>
                                                    @endif
                                                </td>No Data Found
                                            </tr>

                                            @if ($firstFile)
                                                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="{{ $modalId }}-title" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                                        style="max-width: 100%;">
                                                        <div class="modal-content download-preview-modal">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="{{ $modalId }}-title">
                                                                    {{ $download->title }}
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if ($isPdf)
                                                                    <embed src="{{ $fileUrl }}" type="application/pdf"
                                                                        width="100%" height="600px">
                                                                @else
                                                                    <div class="preview-fallback text-center">
                                                                        <p>{{ __('Preview is not available for this file type.') }}</p>
                                                                        <a href="{{ $fileUrl }}" class="btn btn-view"
                                                                            target="_blank" rel="noopener">
                                                                            {{ __('Open File') }}
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    {{ __('Close') }}
                                                                </button>
                                                                <a href="{{ $fileUrl }}" class="btn btn-view"
                                                                    download="{{ $fileName }}">
                                                                    {{ __('Download') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="4">{{ __('No Data Found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="downloads-header">
                            <h3>{{ $page_title ?? 'Bank Downloads' }}</h3>
                            @if (isset($search_term))
                                <p class="text-muted">{{ __('Search results for') }}: <strong>{{ $search_term }}</strong></p>
                            @endif
                        </div>

                        @if ($all_downloads->count() > 0)
                            <div class="downloads-grid">
                                @foreach ($all_downloads as $download)
                                    <div class="download-card">
                                        <div class="download-header">
                                            <h5 class="download-title">
                                                <a href="{{ route('frontend.bank.downloads.single', $download->slug) }}">
                                                    {{ $download->title }}
                                                </a>
                                            </h5>
                                            <div class="download-meta">
                                                @if ($download->category)
                                                    <span class="category-badge">{{ $download->category->title }}</span>
                                                @endif
                                                @if ($download->subcategory)
                                                    <span class="subcategory-badge">{{ $download->subcategory->title }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="download-body">
                                            @if ($download->description)
                                                <p class="download-description">{{ \Illuminate\Support\Str::limit($download->description, 100) }}</p>
                                            @endif
                                        </div>

                                        <div class="download-footer">
                                            <div class="download-date">
                                                <small class="text-muted">
                                                    {{ optional($download->publish_date)->format('M d, Y') }}
                                                </small>
                                            </div>
                                            <a href="{{ route('frontend.bank.downloads.single', $download->slug) }}"
                                                class="btn btn-sm btn-primary">
                                                {{ __('Download') }} <i class="icon-download-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($all_downloads instanceof \Illuminate\Contracts\Pagination\Paginator)
                                <div class="mt-4">
                                    {{ $all_downloads->links() }}
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                {{ __('No downloads found') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .downloads-sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            position: sticky;
            top: 20px;
        }

        .sidebar-title {
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }

        .category-list {
            line-height: 2;
        }

        .category-item {
            display: block;
            color: #495057;
            text-decoration: none;
            padding: 8px 0 8px 10px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .category-item:hover,
        .category-item.active {
            color: #007bff;
            border-left-color: #007bff;
        }

        .subcategory-list {
            margin-left: 15px;
            margin-top: 5px;
            border-left: 2px solid #dee2e6;
            padding-left: 0;
        }

        .subcategory-item {
            display: block;
            font-size: 0.9rem;
            color: #6c757d;
            text-decoration: none;
            padding: 6px 0 6px 15px;
            transition: all 0.3s ease;
        }

        .subcategory-item:hover,
        .subcategory-item.active {
            color: #007bff;
        }

        .downloads-header {
            margin-bottom: 30px;
        }

        .downloads-header h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .downloads-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .download-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .download-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #007bff;
        }

        .download-header {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .download-title {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .download-title a {
            color: #212529;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .download-title a:hover {
            color: #007bff;
        }

        .download-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .category-badge,
        .subcategory-badge {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            background: #e7f3ff;
            color: #0066cc;
        }

        .subcategory-badge {
            background: #f0f0f0;
            color: #666;
        }

        .download-body {
            padding: 15px;
            flex-grow: 1;
        }

        .download-description {
            color: #6c757d;
            margin-bottom: 0;
            line-height: 1.6;
        }

        .download-footer {
            padding: 15px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .downloads-section-heading {
            margin: 35px 0 20px;
        }

        .downloads-section-heading h3 {
            color: #008649;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .downloads-table-wrapper {
            overflow-x: auto;
        }

        .downloads-table {
            border-collapse: collapse;
            max-width: 1230px;
            width: 100%;
            background: #fff;
        }

        .downloads-table thead tr {
            background: #008649;
        }

        .downloads-table th {
            color: #fff;
            font-weight: 700;
            padding: 14px 10px;
        }

        .downloads-table td {
            padding: 12px 10px;
            vertical-align: middle;
        }

        .btn-view {
            background: #008649;
            color: #fff;
            border: 1px solid #008649;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-block;
        }

        .btn-view:hover {
            color: #fff;
            background: #006d3a;
            border-color: #006d3a;
        }

        .download-preview-modal {
            background-color: #fff;
            max-width: 991px;
            width: 100%;
            margin: 0 auto;
        }

        .preview-fallback {
            padding: 60px 20px;
        }

        @media (max-width: 991px) {
            .downloads-sidebar {
                position: static;
            }
        }

        @media (max-width: 767px) {
            .downloads-grid {
                grid-template-columns: 1fr;
            }

            .downloads-header h3,
            .downloads-section-heading h3 {
                font-size: 22px;
            }

            .downloads-table th,
            .downloads-table td {
                font-size: 14px;
            }
        }
    </style>
@endsection
