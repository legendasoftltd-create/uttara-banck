

<!-- @if($all_gallery_images->isEmpty())
    <div class="col-12 text-center py-5">
        <p style="font-size: 18px; color: #888;">No data found</p>
    </div>
@else
    @foreach($all_gallery_images as $data)
        @php
            $gallery_img = get_attachment_image_by_id($data->image, 'full', false);
            $img_url = $gallery_img['img_url'] ?? '';
        @endphp

        <div class="item">
            <a href="#">
                <img src="{{ $img_url }}" alt="{{ $data->title }}">
                <h3>{{ $data->title }}</h3>

                <div class="short-title">
                <p>{{ \Carbon\Carbon::parse($data->publish_date)->year ?? '' }}</p>
            </div>
            </a>
        </div>
    @endforeach
@endif -->



@if($all_gallery_images->isEmpty())
    <div class="col-12 text-center py-5">
        <p style="font-size: 18px; color: #888;">No data found</p>
    </div>
@else
    @foreach($all_gallery_images as $data)
        @php
            $gallery_img = get_attachment_image_by_id($data->image, 'full', false);
            $img_url = $gallery_img['img_url'] ?? '';
        @endphp

        <div class="item">
            <a href="{{ $img_url }}" class="test-popup-link">
                <img src="{{ $img_url }}" alt="{{ $data->title }}" >
                <h3>{{ $data->title }}</h3>
                <div class="short-title">
                    <p>{{ \Carbon\Carbon::parse($data->publish_date)->year ?? '' }}</p>
                </div>
            </a>
        </div>
    @endforeach
@endif

<style>
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

<div class="lightbox-overlay" id="lightboxOverlay">
    <span class="lightbox-close" id="lightboxClose">&times;</span>
    <img id="lightboxImg" src="" alt="">
</div>

<script>
    (function() {
        var overlay = document.getElementById('lightboxOverlay');
        var lightboxImg = document.getElementById('lightboxImg');
        var closeBtn = document.getElementById('lightboxClose');

        document.addEventListener('click', function(e) {
            var link = e.target.closest('.test-popup-link');
            if (link) {
                e.preventDefault();
                var imgUrl = link.getAttribute('href');
                if (imgUrl && imgUrl !== '#') {
                    lightboxImg.src = imgUrl;
                    overlay.classList.add('active');
                }
            }
        });

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
    })();
</script>