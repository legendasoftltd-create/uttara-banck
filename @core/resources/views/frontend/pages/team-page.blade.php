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
    /* Base style (Mobile / Small devices: 1 column) */
    .management-comete .row.four-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 20px;
        justify-content: center;
    }
    
    .management-comete .row.four-grid .card {
        width: 100% !important;
        max-width: 260px !important;
        margin: 0 auto;
    }
    
    /* Make all images under management-comete fully responsive */
    .management-comete .img-box img {
        width: 100% !important;
        max-width: 250px;
        height: auto;
        object-fit: cover;
    }

    /* Medium devices: 3 columns */
    @media (min-width: 768px) {
        .management-comete .row.four-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }
        .management-comete .row.four-grid .card {
            max-width: 100% !important;
        }
    }

    /* Extra large devices: 6 columns */
    @media (min-width: 1200px) {
        .management-comete .row.four-grid {
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 20px;
        }
        .management-comete .row.four-grid .card {
            max-width: 100% !important;
        }
    }
</style>
@endsection


@section('content')

<div class="container management-comete mt-4">

    {{-- Committee navigation links --}}
    @php $slug_map = array_flip(\App\TeamMember::slugMap()); @endphp
    <!--<div class="row" style="justify-content:center; gap:10px; margin-bottom:30px; flex-wrap:wrap;">-->
    <!--    @foreach($team_types as $typeKey => $typeLabel)-->
    <!--        @php $slug = $slug_map[$typeKey] ?? str_replace('_','-',$typeKey); @endphp-->
    <!--        <a href="{{ route('frontend.team.committee', ['committee' => $slug]) }}"-->
    <!--           style="padding:8px 18px; border-radius:4px; font-size:14px; font-weight:500; text-decoration:none; white-space:nowrap;-->
    <!--                  {{ $active_type === $typeKey ? 'background:#012C60; color:#fff;' : 'background:#eef1f6; color:#012C60;' }}">-->
    <!--            {{ $typeLabel }}-->
    <!--        </a>-->
    <!--    @endforeach-->
    <!--</div>-->

    <section class="board-section">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center title-color">
                    {{ $team_types[$active_type] }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>

        @php
            $list      = $members->values();
            $first     = $list->first();
            $second    = $list->get(1);
            $remaining = $list->slice(2);
        @endphp

        @if($list->isEmpty())
            <div class="row">
                <div class="col-md-12 text-center py-5">
                    <p class="text-muted">{{ __('No members found in this category.') }}</p>
                </div>
            </div>
        @else
            {{-- First member: centred single --}}
            <div class="row single">
                <div class="card" onclick="openModal(this)"
                     data-description="{{ $first->description }}">
                    <div class="img-box">
                        {!! render_image_markup_by_attachment_id($first->image) !!}
                    </div>
                    <h3>{{ $first->name }}</h3>
                    <p>{{ $first->designation }}</p>
                </div>
            </div>

            @if($second)
                {{-- Second and rest in four-grid --}}
                <div class="row four-grid">
                    <div class="card" onclick="openModal(this)"
                         data-description="{{ $second->description }}">
                        <div class="img-box">
                            {!! render_image_markup_by_attachment_id($second->image) !!}
                        </div>
                        <div class="p-2">
                            <h3>{{ $second->name }}</h3>
                            <p>{{ $second->designation }}</p>
                        </div>
                    </div>

                    @foreach($remaining as $member)
                        <div class="card" onclick="openModal(this)"
                             data-description="{{ $member->description }}">
                            <div class="img-box">
                                {!! render_image_markup_by_attachment_id($member->image) !!}
                            </div>
                            <div class="p-2">
                                <h3>{{ $member->name }}</h3>
                                <p>{{ $member->designation }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </section>

    {{-- Bio Modal — must be inside .management-comete for scoped CSS to apply --}}
    <div id="bioModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div class="modal-body">
                <div class="modal-img-container">
                    <img id="modalImg" src="" alt="Member Image">
                </div>
                <div class="modal-text">
                    <h2 id="modalName"></h2>
                    <h4 id="modalDesignation"></h4>
                    <hr>
                    <div id="modalDesc" class="description-text"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
