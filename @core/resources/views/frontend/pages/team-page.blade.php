@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('team_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('team_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('team_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('team_page_'.$user_select_lang_slug.'_meta_tags')}}">
    {!! render_og_meta_image_by_attachment_id(get_static_option('team_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection
@section('style')
<style>
    .committee-tab-area {
        background: #f5f7fa;
        padding: 60px 0 80px;
    }
    .committee-nav-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        border-bottom: 3px solid #0a4275;
        padding-bottom: 0;
        margin-bottom: 40px;
    }
    .committee-nav-tabs .nav-item {
        margin-bottom: -3px;
    }
    .committee-nav-tabs .nav-link {
        border: 1px solid #dde3ec;
        border-bottom: none;
        background: #fff;
        color: #444;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 4px 4px 0 0;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .committee-nav-tabs .nav-link:hover {
        background: #e8eff7;
        color: #0a4275;
    }
    .committee-nav-tabs .nav-link.active {
        background: #0a4275;
        color: #fff;
        border-color: #0a4275;
    }
    .member-card {
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        transition: box-shadow 0.2s;
        text-align: center;
    }
    .member-card:hover {
        box-shadow: 0 6px 24px rgba(10,66,117,0.15);
    }
    .member-card .member-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        object-position: top;
    }
    .member-card .member-img-placeholder {
        width: 100%;
        height: 220px;
        background: #d8e4f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .member-card .member-img-placeholder i {
        font-size: 80px;
        color: #9ab0c8;
    }
    .member-card .member-info {
        padding: 18px 14px 20px;
    }
    .member-card .member-name {
        font-size: 15px;
        font-weight: 700;
        color: #0a4275;
        margin-bottom: 4px;
        line-height: 1.3;
    }
    .member-card .member-designation {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }
    .member-card .member-description {
        font-size: 13px;
        color: #777;
        line-height: 1.6;
        margin-bottom: 10px;
        text-align: left;
    }
    .member-card .member-social {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .member-card .member-social a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        background: #0a4275;
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
        transition: background 0.2s;
    }
    .member-card .member-social a:hover {
        background: #c8952a;
    }
    .no-members-msg {
        text-align: center;
        padding: 40px 0;
        color: #888;
        font-size: 15px;
    }
</style>
@endsection
@section('content')
<div class="committee-tab-area">
    <div class="container">

        {{-- Tab Navigation --}}
        <ul class="nav committee-nav-tabs" id="committeeTab" role="tablist">
            @php $first = true; @endphp
            @foreach($team_types as $typeKey => $typeLabel)
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $first ? 'active' : '' }}"
                       id="tab-{{ $typeKey }}"
                       data-toggle="tab"
                       href="#pane-{{ $typeKey }}"
                       role="tab"
                       aria-controls="pane-{{ $typeKey }}"
                       aria-selected="{{ $first ? 'true' : 'false' }}">
                        {{ $typeLabel }}
                    </a>
                </li>
                @php $first = false; @endphp
            @endforeach
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="committeeTabContent">
            @php $first = true; @endphp
            @foreach($team_types as $typeKey => $typeLabel)
                <div class="tab-pane fade {{ $first ? 'show active' : '' }}"
                     id="pane-{{ $typeKey }}"
                     role="tabpanel"
                     aria-labelledby="tab-{{ $typeKey }}">

                    @if(!empty($all_team_members[$typeKey]) && $all_team_members[$typeKey]->count())
                        <div class="row">
                            @foreach($all_team_members[$typeKey] as $member)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="member-card">
                                        @php $img = get_attachment_image_by_id($member->image, null, true); @endphp
                                        @if(!empty($img))
                                            <img class="member-img" src="{{ $img['img_url'] }}" alt="{{ $member->name }}">
                                        @else
                                            <div class="member-img-placeholder">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        @endif
                                        <div class="member-info">
                                            <div class="member-name">{{ $member->name }}</div>
                                            <div class="member-designation">{{ $member->designation }}</div>
                                            @if(!empty($member->description))
                                                <div class="member-description">{{ $member->description }}</div>
                                            @endif
                                            @if((!empty($member->icon_one) && !empty($member->icon_one_url)) || (!empty($member->icon_two) && !empty($member->icon_two_url)) || (!empty($member->icon_three) && !empty($member->icon_three_url)))
                                                <div class="member-social">
                                                    @if(!empty($member->icon_one) && !empty($member->icon_one_url))
                                                        <a href="{{ $member->icon_one_url }}" target="_blank" rel="noopener"><i class="{{ $member->icon_one }}"></i></a>
                                                    @endif
                                                    @if(!empty($member->icon_two) && !empty($member->icon_two_url))
                                                        <a href="{{ $member->icon_two_url }}" target="_blank" rel="noopener"><i class="{{ $member->icon_two }}"></i></a>
                                                    @endif
                                                    @if(!empty($member->icon_three) && !empty($member->icon_three_url))
                                                        <a href="{{ $member->icon_three_url }}" target="_blank" rel="noopener"><i class="{{ $member->icon_three }}"></i></a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-members-msg">
                            <i class="fas fa-users fa-2x mb-3 d-block" style="color:#c0cfe0;"></i>
                            {{ __('No members found in this category.') }}
                        </div>
                    @endif
                </div>
                @php $first = false; @endphp
            @endforeach
        </div>

    </div>
</div>
@endsection
