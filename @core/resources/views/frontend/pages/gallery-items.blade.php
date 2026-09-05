<style> 
/* custom card style */
    .card-height {
    height: 100%;
}

.card {
    height: 100%;
}

.custom-image-height {
    height: 173px;
    width: 100%;
    object-fit: cover;
}

.custom-card-text {
    color: #4a5c6a;
    font-weight: 500;
    line-height: 1.3;
    
    /* Max 3 lines */
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;

    overflow: hidden;
    text-overflow: ellipsis;

    /* Fixed height for 3 lines */
    min-height: 62px;
    max-height: 62px;
}

.year-badge-text {
    color: #2e7d4f;
    font-size: 1.3rem;
}

.year-badge-bg {
    background-color: #f4f4f4;
}

.gallery-image-courtesy-watermark {
    position: absolute;
    bottom: -1px;
    right: 5px;
    color: rgb(46 46 46 / 60%);
    opacity: 0.30;
    filter: blur(0.7px);
    font-size: 10px;
    font-weight: 400;
    line-height: 1.2;
    padding: 2px 6px;
    border-radius: 3px;
    letter-spacing: 0.3px;
    z-index: 5;
    pointer-events: none;
    user-select: none;
}
</style>


@if($all_gallery_images->isEmpty())
    <div class="col-12 text-center py-5">
        <p style="font-size: 18px; color: #888; ">No data found</p>
    </div>
@else
    @foreach($all_gallery_images as $data)
        @php
            $gallery_img = get_attachment_image_by_id($data->image, 'full', false);
            $img_url = $gallery_img['img_url'] ?? '';
        @endphp

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-0 h-100">

                <div class="position-relative">
                    <a href="{{ $img_url }}" class="test-popup-link" data-courtesy="{{ $data->image_courtesy ?? '' }}">
                        <img src="{{ $img_url }}"
                            class="custom-image-height rounded-0"
                            style="cursor: zoom-in;"
                            alt="{{ $data->title }}">
                    </a>

                    @if(!empty($data->image_courtesy))
                        <div class="gallery-image-courtesy-watermark">
                            {{ $data->image_courtesy }}
                        </div>
                    @endif

                    <div class="position-absolute rounded-circle year-badge-bg d-flex align-items-center justify-content-center shadow"
                        style="width:60px;height:60px;bottom:-20px;right:20px;z-index:10;">
                        <span class="year-badge-text">
                            {{ \Carbon\Carbon::parse($data->publish_date)->year ?? '' }}
                        </span>
                    </div>
                </div>

                <div class="card-body text-center pt-4 pb-4 px-4 d-flex align-items-center">
                    <h4 class="card-title custom-card-text w-100 mb-0">
                        {{ $data->title }}
                    </h4>
                </div>

            </div>
        </div>
        
    @endforeach

    <div class="col-12 text-center mt-4">
        <div class="blog-pagination" id="galleryPagination">
            {{ $all_gallery_images->links() }}
        </div>
    </div>
@endif

