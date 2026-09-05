@extends('frontend.frontend-page-master')
@php
    $page_name = get_static_option('work_page_' . $user_select_lang_slug . '_name');
@endphp
@section('site-title')
    {{ $page_name }} : {{ $category_name }}
@endsection
@section('page-title')
    {{ $page_name }} : {{ $category_name }}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('work_page_' . $user_select_lang_slug . '_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('work_page_' . $user_select_lang_slug . '_meta_tags') }}">
    {!! render_og_meta_image_by_attachment_id(
        get_static_option('work_page_' . $user_select_lang_slug . '_meta_image'),
    ) !!}
@endsection
@section('content')
    {{-- <div class="page-content portfolio padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                @forelse($all_work as $data)
                    <div class="col-lg-6 col-md-6 margin-bottom-40">
                        <x-frontend.work.grid :work="$data" />
                    </div>
                @empty
                      <div class="col-lg-12">
                          <div class="alert alert-warning">{{__('No ')}} {{$page_name}} {{__('Found')}} {{__('In')}} {{$category_name}}</div>
                      </div>
                @endforelse
                <div class="col-lg-12">
                    <div class="post-pagination-wrapper">
                        {{$all_work->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div id="scroll-down"></div>
    <div class="empty-height-50"></div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center title-color">
               {{ $category_name }}
            </h2>
            <div class="title-seperator">
            </div>
        </div>
    </div>
    <div class="">
        <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center"
            style="border-collapse: collapse; max-width:1230px;">
            <thead>
                <tr bgcolor="#008649">
                    <th width="10%" class="text-center">
                        <font color="#ffffff"><b>Sl No.</b></font>
                    </th>
                    <th width="20%" class="text-center">
                        <font color="#ffffff"><b>Date</b></font>
                    </th>
                    <th width="70%" class="text-center">
                        <font color="#ffffff"><b>Title</b></font>
                    </th>
                    <th width="10%" class="text-center">
                        <font color="#ffffff"><b>View</b></font>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($all_work as $key=>$data)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">{{ $data->created_at->format('Y-m-d') }}</td>
                        <td>{{ $data->title }}</td>
                        @php $file_details = get_attachment_image_by_id($data->image, 'full'); @endphp
                        <td class="text-center"><a href="{{ !empty($file_details) ? ($file_details['img_url'] ?? '') : '' }}" class="btn btn-view"
                                data-toggle="modal" data-target="#open-file-{{ $data->id }}">View</a></td>
                        <!-- Modal -->
                        <div class="modal fade" id="open-file-{{ $data->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;">
                                <div class="modal-content"
                                    style="background-color: #FFF; max-width: 991px; width: 100%; margin: 0 auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="open-file-{{ $data->id }}">{{ $data->title }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="max-height: 80vh; overflow-y: auto;"> 
                                        {{-- <embed src="{{ !empty($file_details) ? ($file_details['img_url'] ?? '') : '' }}" type="application/pdf" width="100%"
                                            height="600px"> --}}

                                            @php
                                                $url = $file_details['img_url'] ?? '';
                                                $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
                                            @endphp

                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <div style="position: relative; display: inline-block; width: 100%;">
                                                    <img src="{{ $url }}" class="img-fluid w-100" alt="">
                                                    @if(!empty($data->image_courtesy))
                                                        <div class="work-image-courtesy-watermark">
                                                            {{ $data->image_courtesy }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif($extension === 'pdf')
                                                <embed src="{{ $url }}" type="application/pdf" width="100%" height="600px">
                                            @endif
                                            
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ !empty($file_details) ? ($file_details['img_url'] ?? '') : '' }}" type="button" class="btn btn-view"
                                            download>Save changes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">No Data Found</td>
                        {{-- <td class="text-center">March 31, 2024</td>
                                    <td>1st Quarter Statement (Un-Audited) 2024</td>
                                    <td class="text-center"><a href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter">View</a></td> --}}
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="empty-height-50"></div>
    </div>

<style>
.work-image-courtesy-watermark {
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
@endsection
