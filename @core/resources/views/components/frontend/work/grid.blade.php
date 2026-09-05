<div class="single-case-studies-item">
    <div class="thumb" style="position: relative;">
        {!! render_image_markup_by_attachment_id($work->image) !!}
        @if(!empty($work->image_courtesy))
            <div class="work-image-courtesy-watermark">
                {{ $work->image_courtesy }}
            </div>
        @endif
    </div>
    <div class="cart-icon">
        <h4 class="title"><a href="{{route('frontend.work.single',$work->slug)}}"> {{$work->title}}</a></h4>
    </div>
</div>