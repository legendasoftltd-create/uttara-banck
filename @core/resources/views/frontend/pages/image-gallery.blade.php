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
    .gallery-filter-row {
        padding: 0 75px;
    }

    @media (max-width: 991px) {
        .gallery-filter-row {
            padding: 0 5px;
            ;
        }
    }


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

    /* custom card style */
    .custom-card-text {
        color: #4a5c6a;
        /* Slate blue/brownish text */
        font-weight: 500;
        line-height: 1.3;
    }

    .year-badge-text {
        color: #008b8b;
        /* Teal color for the year */
        font-size: 1.3rem;
    }

    .year-badge-bg {
        background-color: #f4f4f4;
        /* Slightly off-white to match the image */
    }
</style>

@section('content')
<div class="contact-section padding-bottom-120 padding-top-120">


    <div class="container ">
        <!-- style="padding:0px 75px;" -->
        <div class="row gap-3 gallery-filter-row">
            <div class="col-md-6 col-sm-6 mb-3 mb-sm-0">
                <!-- <select id="categoryFilter" class="form-control">
                <option value="">Select Category</option>
                @foreach($all_category as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->title }}
                    </option>
                @endforeach
            </select> -->

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
                <!-- <select id="yearFilter" class="form-control">
                    <option value="">Select Year</option>
                    @foreach($all_years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select> -->
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

    <!-- <div class="container">
            <div class="grid-section">
                @foreach($all_gallery_images as $data)
                    <div class="item">
                        <a href="#">
                            @php
                                $gallery_img = get_attachment_image_by_id($data->image,'full',false);
                                $img_url = !empty($gallery_img) ? $gallery_img['img_url'] : '';
                            @endphp
                            <img src="{{$img_url}}" alt="{{$data->title}}">
                            <h3>{{$data->title}}</h3>`
                            
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="empty-height-50"></div> -->

</div>


<!-- AJAX GALLERY -->
<div class="container mt-4">

    <div class="row g-4">

        <!-- Card 1 -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-0 h-100">

                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        class="card-img-top rounded-0"
                        alt="Team meeting">

                    <div class="position-absolute rounded-circle year-badge-bg d-flex align-items-center justify-content-center shadow"
                        style="width: 60px; height: 60px; bottom: -20px; right: 20px; z-index: 10;">
                        <span class="year-badge-text">2019</span>
                    </div>
                </div>

                <div class="card-body text-center pt-4 pb-4 px-4">
                    <h4 class="card-title custom-card-text">
                        Can curiosity may end shameless explained
                    </h4>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="container mt-4">
    <div class="grid-section" id="galleryWrapper">
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
    document.addEventListener("DOMContentLoaded", () => {

        const dropdown = document.querySelector(".category-dropdown");
        const chevron = document.getElementById("category-chevron");

        window.showCategoryMenu = function(event) {
            event.stopPropagation();
            dropdown.classList.toggle("active");

            if (chevron) {
                chevron.classList.toggle("rotated");
            }
        };

        // close when click outside
        window.addEventListener("click", (event) => {
            if (!event.target.closest(".category-dropdown")) {
                dropdown.classList.remove("active");

                if (chevron) {
                    chevron.classList.remove("rotated");
                }
            }
        });

        // select item
        document.querySelectorAll(".category-dropdown-link").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();

                dropdown.querySelector("button").childNodes[0].textContent = this.textContent;

                dropdown.classList.remove("active");
                chevron.classList.remove("rotated");
            });
        });

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

    });

    function loadGallery(page) {

        page = page || 1;

        const category = document.getElementById('categoryFilter').value;
        const year = document.getElementById('yearFilter').value;

        const url = new URL("{{ route('frontend.image.gallery.filter') }}");
        url.searchParams.append('page', page);
        url.searchParams.append('category', category);
        url.searchParams.append('year', year);

        document.getElementById('galleryWrapper').innerHTML = '<p>Loading...</p>';

        fetch(url)
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                document.getElementById('galleryWrapper').innerHTML = data.html;
            })
            .catch(function(err) {
                console.error('Error:', err);
                document.getElementById('galleryWrapper').innerHTML = '<p>Something went wrong.</p>';
            });
    }
</script>