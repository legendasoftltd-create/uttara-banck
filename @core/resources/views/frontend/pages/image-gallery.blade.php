@extends('frontend.frontend-page-master')
@section('site-title')
{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
<meta name="description" content="{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_meta_description')}}">
<meta name="tags" content="{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_meta_tags')}}">
{!! render_og_meta_image_by_attachment_id(get_static_option('image_gallery_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection

<style>
    
    .custom-select-wrapper {
        position: relative;
        width: 100%;
        user-select: none;
    }

    .custom-select-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #2e7d4f;
        /* green color — change to your brand color */
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 10px 16px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    .custom-select-btn:hover {
        background-color: #256040;
    }

    .custom-select-chevron {
        transition: transform 0.25s ease;
        flex-shrink: 0;
    }

    /* Rotate chevron when open */
    .custom-select-wrapper.open .custom-select-chevron {
        transform: rotate(180deg);
    }

    .custom-select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        width: 100%;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        padding: 6px 0;
        margin: 0;
        list-style: none;
        z-index: 9999;
        max-height: 220px;
        overflow-y: auto;
    }

    /* Show menu when open */
    .custom-select-wrapper.open .custom-select-menu {
        display: block;
    }

    .custom-select-item {
        padding: 10px 16px;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        transition: background 0.15s;
    }

    .custom-select-item:hover {
        background-color: #f0f7f3;
        color: #2e7d4f;
    }

    .custom-select-item.selected {
        font-weight: 600;
        color: #2e7d4f;
        background-color: #e8f5ee !important;
    }

    .page-item.active .page-link {
        background-color: #2e7d4f !important;
        border-color: #2e7d4f !important;
        color: #fff !important;
        padding: 8px 14px !important;
        border: 1px solid #ddd !important;
        font-size: 14px !important;
        border-radius: 4px !important;
        transition: all 0.2s ease;
    }

    .lightbox-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 99999;
        justify-content: center;
        align-items: center;
        cursor: zoom-out;
    }
    .lightbox-overlay.active {
        display: flex;
    }
    .lightbox-overlay img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 4px;
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
    }
    .lightbox-close {
        position: absolute;
        top: 20px; right: 30px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
    }

    
</style>

@section('content')
<div class="contact-section padding-bottom-120 padding-top-120">


    <div class="container ">
        <div class="row gap-3 gallery-filter-row">
            <div class="col-md-6 col-sm-6 mb-3 mb-sm-0">
                
                <div class="custom-select-wrapper" id="categoryDropdown">
                    <button class="custom-select-btn" onclick="toggleDropdown('categoryDropdown')">
                        <span class="custom-select-label">Select Category</span>
                        <svg class="custom-select-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                    </button>
                    <ul class="custom-select-menu">
                        <li class="custom-select-item" data-value="" onclick="selectOption('categoryDropdown', '', 'Select Category')">
                            Select Category
                        </li>
                        @foreach($all_category as $category)
                        <li class="custom-select-item" data-value="{{ $category->id }}" onclick="selectOption('categoryDropdown', '{{ $category->id }}', '{{ $category->title }}')">
                            {{ $category->title }}
                        </li>
                        @endforeach
                    </ul>
                    {{-- Hidden input to hold actual value --}}
                    <input type="hidden" id="categoryFilter" name="category" value="">
                </div>

            </div>

            <div class="col-md-6 col-sm-6 mb-3 mb-sm-0 w-100">
                
                <div class="custom-select-wrapper" id="yearDropdown">
                    <button class="custom-select-btn" onclick="toggleDropdown('yearDropdown')">
                        <span class="custom-select-label">Select Year</span>
                        <svg class="custom-select-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                    </button>
                    <ul class="custom-select-menu">
                        <li class="custom-select-item" data-value="" onclick="selectOption('yearDropdown', '', 'Select Year')">
                            Select Year
                        </li>
                        @foreach($all_years as $year)
                        <li class="custom-select-item" data-value="{{ $year }}" onclick="selectOption('yearDropdown', '{{ $year }}', '{{ $year }}')">
                            {{ $year }}
                        </li>
                        @endforeach
                    </ul>
                    {{-- Hidden input to hold actual value --}}
                    <input type="hidden" id="yearFilter" name="year" value="">
                </div>
            </div>
        </div>
    </div>

</div>


<!-- LIGHTBOX OVERLAY (persists across AJAX) -->
<div class="lightbox-overlay" id="lightboxOverlay">
    <span class="lightbox-close" id="lightboxClose">&times;</span>
    <img id="lightboxImg" src="" alt="">
</div>

<!-- AJAX GALLERY -->
<div class="container mt-4">
    <div class="row g-4" id="galleryWrapper">
        @include('frontend.pages.gallery-items')
    </div>
</div>

</div>

@endsection



<script>
    // Toggle open/close
    function toggleDropdown(id) {
        const wrapper = document.getElementById(id);
        const isOpen = wrapper.classList.contains('open');

        // Close all dropdowns first
        document.querySelectorAll('.custom-select-wrapper').forEach(el => el.classList.remove('open'));

        // Open this one if it was closed
        if (!isOpen) wrapper.classList.add('open');
    }

    // Select an option
    function selectOption(wrapperId, value, label) {
        const wrapper = document.getElementById(wrapperId);
        const input = wrapper.querySelector('input[type="hidden"]');
        const btnLabel = wrapper.querySelector('.custom-select-label');

        // Update label & value
        btnLabel.textContent = label;
        input.value = value;

        // Mark selected item
        wrapper.querySelectorAll('.custom-select-item').forEach(li => {
            li.classList.toggle('selected', li.dataset.value == value);
        });

        // Close dropdown
        wrapper.classList.remove('open');

        // Trigger gallery reload
        loadGallery(1);
    }

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-select-wrapper')) {
            document.querySelectorAll('.custom-select-wrapper').forEach(el => el.classList.remove('open'));
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        // ON CHANGE FILTER
        document.getElementById('categoryFilter').addEventListener('change', function() {
            loadGallery(1);
        });
        document.getElementById('yearFilter').addEventListener('change', function() {
            loadGallery(1);
        });

        // PAGINATION CLICK DELEGATION
        document.addEventListener('click', function(e) {
            var link = e.target.closest('#galleryPagination .page-link');
            if (!link) return;

            e.preventDefault();

            var href = link.getAttribute('href');
            var page = 1;

            if (href) {
                var match = href.match(/[?&]page=(\d+)/);
                if (match) {
                    page = match[1];
                }
            }

            loadGallery(page);
        });

        // LIGHTBOX — close handlers
        var overlay = document.getElementById('lightboxOverlay');
        var lightboxImg = document.getElementById('lightboxImg');
        var closeBtn = document.getElementById('lightboxClose');

        function closeLightbox() {
            overlay.classList.remove('active');
            lightboxImg.src = '';
        }

        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (overlay) overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeLightbox();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });

    });

    // LIGHTBOX — open on .test-popup-link click (event delegation survives AJAX)
    document.addEventListener('click', function(e) {
        var link = e.target.closest('.test-popup-link');
        if (!link) return;

        e.preventDefault();
        var imgUrl = link.getAttribute('href');
        if (imgUrl && imgUrl !== '#') {
            document.getElementById('lightboxImg').src = imgUrl;
            document.getElementById('lightboxOverlay').classList.add('active');
        }
    });

    function loadGallery(page) {

        page = page || 1;

        const category = document.getElementById('categoryFilter').value;
        const year = document.getElementById('yearFilter').value;

        const url = new URL("{{ route('frontend.image.gallery.filter') }}");
        url.searchParams.append('page', page);
        url.searchParams.append('category', category);
        url.searchParams.append('year', year);

        document.getElementById('galleryWrapper').innerHTML = '<p class="col-12 text-center py-5">Loading...</p>';

        fetch(url)
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                document.getElementById('galleryWrapper').innerHTML = data.html;
            })
            .catch(function(err) {
                console.error('Error:', err);
                document.getElementById('galleryWrapper').innerHTML = '<p class="col-12 text-center py-5">Something went wrong.</p>';
            });
    }
</script>