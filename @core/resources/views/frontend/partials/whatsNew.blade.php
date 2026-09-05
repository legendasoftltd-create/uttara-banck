<section id="whats-new">
    <div class="container">
        <div class="text-center mb-4">
            <p class="subtitle fancy">
                <span class="skl-bar-2"></span>
                <span class="title-color text-uppercase">WHAT’S NEW</span>
                <span class="skl-bar-1"></span>
            </p>
        </div>

        <div id="whatseNewCarousel" class="carousel slide pt-4 mt-4" data-ride="carousel" data-interval="3000">
            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                @foreach ($latest_products as $data)
                    @php
                        $bolg_image_details = get_attachment_image_by_id($data->image, 'full');
                    @endphp
                    <div class="carousel-item active col-md-3 mt-4">
                        <div class="overflow-hidden" style="position: relative;">
                            {{-- {!! render_background_image_markup_by_attachment_id($data->image,'large') !!} --}}
                            <img class="img-fluid mx-auto d-block zoom" src="{{ $bolg_image_details['img_url'] ?? '' }}"
                                width="100%" alt="Flexi Platinum Whats new">
                            @if(!empty($data->image_courtesy))
                                <div class="product-image-courtesy-watermark">
                                    {{ $data->image_courtesy }}
                                </div>
                            @endif
                        </div>
                        <div class="whats-text-bg" data-toggle="modal" data-target="#">
                            <p><a href="{{route('frontend.products.single',$data->slug)}}" target="_blank">{{$data->title}}</a></p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#whatseNewCarousel" role="button" data-slide="prev">
                <span class="prev-extended-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next text-faded" href="#whatseNewCarousel" role="button" data-slide="next">
                <span class=" next-extended-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    @include('frontend.partials.popup')
</section>

<style>
.product-image-courtesy-watermark {
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
