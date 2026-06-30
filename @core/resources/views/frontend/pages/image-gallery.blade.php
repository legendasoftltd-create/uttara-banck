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
        z-index: 20;
    }

    .lightbox-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: none;
        font-size: 32px;
        padding: 18px 14px;
        cursor: pointer;
        z-index: 10;
        border-radius: 6px;
        transition: background 0.2s;
        line-height: 1;
    }
    .lightbox-btn:hover {
        background: rgba(255,255,255,0.35);
    }
    .lightbox-prev {
        left: 16px;
    }
    .lightbox-next {
        right: 16px;
    }
    .lightbox-counter {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 15px;
        background: rgba(0,0,0,0.5);
        padding: 6px 18px;
        border-radius: 20px;
        user-select: none;
        z-index: 20;
    }

    
</style>

@section('content')
<div class="my-5 padding-bottom-120 padding-top-120">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                
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

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                
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


<!-- LIGHTBOX OVERLAY — infinite slider (persists across AJAX) -->
<div class="lightbox-overlay" id="lightboxOverlay">
    <span class="lightbox-close" id="lightboxClose">&times;</span>
    <button class="lightbox-btn lightbox-prev" id="lightboxPrev">&#10094;</button>
    <img id="lightboxImg" src="" alt="">
    <button class="lightbox-btn lightbox-next" id="lightboxNext">&#10095;</button>
    <div class="lightbox-counter" id="lightboxCounter"></div>
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

        // LIGHTBOX — infinite-loop slider
        var overlay = document.getElementById('lightboxOverlay');
        var lightboxImg = document.getElementById('lightboxImg');
        var closeBtn = document.getElementById('lightboxClose');
        var prevBtn = document.getElementById('lightboxPrev');
        var nextBtn = document.getElementById('lightboxNext');
        var counterEl = document.getElementById('lightboxCounter');

        function closeLightbox() {
            overlay.classList.remove('active');
            lightboxImg.src = '';
        }

        function showSlide(index) {
            if (!galleryImages.length) return;
            galleryIndex = (index + galleryImages.length) % galleryImages.length;
            lightboxImg.src = galleryImages[galleryIndex];
            counterEl.textContent = (galleryIndex + 1) + ' / ' + galleryImages.length;
            overlay.classList.add('active');
        }

        function prevSlide() { showSlide(galleryIndex - 1); }
        function nextSlide() { showSlide(galleryIndex + 1); }

        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (overlay) overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeLightbox();
        });
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        document.addEventListener('keydown', function(e) {
            if (overlay.classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') prevSlide();
                if (e.key === 'ArrowRight') nextSlide();
            }
        });

    });

    // LIGHTBOX — open .test-popup-link (event delegation survives AJAX)
    var galleryImages = [];
    var galleryIndex = 0;

    document.addEventListener('click', function(e) {
        var link = e.target.closest('.test-popup-link');
        if (!link) return;

        e.preventDefault();

        var allLinks = document.querySelectorAll('#galleryWrapper .test-popup-link');
        galleryImages = [];

        allLinks.forEach(function(el, i) {
            var href = el.getAttribute('href');
            galleryImages.push(href);
            if (el === link) galleryIndex = i;
        });

        if (!galleryImages.length) return;

        document.getElementById('lightboxImg').src = galleryImages[galleryIndex];
        document.getElementById('lightboxCounter').textContent = (galleryIndex + 1) + ' / ' + galleryImages.length;
        document.getElementById('lightboxOverlay').classList.add('active');
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