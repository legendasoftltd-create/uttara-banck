@extends('backend.admin-master')
@section('site-title')
    {{__('Footer Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <form action="{{route('admin.general.footer.settings')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">{{__('Address & Contact')}}</h4>
                            <nav>
                                <div class="nav nav-tabs" id="address-nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                        <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#address-nav-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30">
                                @foreach($all_languages as $key => $lang)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="address-nav-{{$lang->slug}}" role="tabpanel">
                                        <div class="form-group">
                                            <label for="site_{{$lang->slug}}_footer_address">{{__('Address')}}</label>
                                            <textarea name="site_{{$lang->slug}}_footer_address" class="form-control" rows="3" id="site_{{$lang->slug}}_footer_address">{{get_static_option('site_'.$lang->slug.'_footer_address')}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="site_{{$lang->slug}}_footer_contact_label">{{__('Contact Label')}}</label>
                                            <input type="text" name="site_{{$lang->slug}}_footer_contact_label" class="form-control" value="{{get_static_option('site_'.$lang->slug.'_footer_contact_label')}}" id="site_{{$lang->slug}}_footer_contact_label">
                                            <small class="form-text text-muted">{{__('e.g. 24/7 Call Center')}}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="site_footer_contact_phone">{{__('Contact Phone')}}</label>
                                <input type="text" name="site_footer_contact_phone" class="form-control" value="{{get_static_option('site_footer_contact_phone')}}" id="site_footer_contact_phone">
                            </div>
                            <div class="form-group">
                                <label for="site_footer_contact_email">{{__('Contact Email')}}</label>
                                <input type="text" name="site_footer_contact_email" class="form-control" value="{{get_static_option('site_footer_contact_email')}}" id="site_footer_contact_email">
                            </div>
                        </div>
                    </div>

                    @foreach([
                        'one' => __('Footer Link Column One'),
                        'two' => __('Footer Link Column Two'),
                    ] as $group_key => $group_label)
                        <div class="card mt-4 footer-link-group" data-group="{{$group_key}}">
                            <div class="card-body">
                                <h4 class="header-title">{{$group_label}}</h4>
                                @php
                                    $option_key = 'footer_column_'.($group_key == 'one' ? 'one' : 'two').'_link_item';
                                    $all_url_fields = get_static_option($option_key.'_url');
                                    $all_url_fields = !empty($all_url_fields) ? unserialize($all_url_fields,['allowed_classes' => false]) : [''];
                                @endphp
                                <div class="repeater-list">
                                    @foreach($all_url_fields as $index => $url_field)
                                        <div class="iconbox-repeater-wrapper">
                                            <div class="all-field-wrap">
                                                <ul class="nav nav-tabs" id="myTab_{{$group_key}}_{{$index}}" role="tablist">
                                                    @foreach($all_languages as $key => $lang)
                                                        <li class="nav-item">
                                                            <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#tab_{{$group_key}}_{{$lang->slug}}_{{$key + $index}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="tab-content margin-top-30" id="myTabContent_{{$group_key}}_{{$index}}">
                                                    @foreach($all_languages as $key => $lang)
                                                        @php
                                                            $all_title_fields = get_static_option($option_key.'_'.$lang->slug.'_title');
                                                            $all_title_fields = !empty($all_title_fields) ? unserialize($all_title_fields,['allowed_classes' => false]) : [''];
                                                        @endphp
                                                        <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$group_key}}_{{$lang->slug}}_{{$key + $index}}" role="tabpanel">
                                                            <div class="form-group">
                                                                <label>{{__('Title')}} ({{$lang->name}})</label>
                                                                <input type="text" name="{{$option_key}}_{{$lang->slug}}_title[]" class="form-control" value="{{$all_title_fields[$index] ?? ''}}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="form-group">
                                                        <label>{{__('Link URL')}}</label>
                                                        <input type="text" name="{{$option_key}}_url[]" class="form-control" value="{{$url_field}}" placeholder="{{__('e.g. /about-us or https://example.com')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="action-wrap">
                                                <span class="add"><i class="ti-plus"></i></span>
                                                <span class="remove"><i class="ti-trash"></i></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '.footer-link-group .all-field-wrap .action-wrap .add', function (e) {
            e.preventDefault();
            var el = $(this);
            var group = el.closest('.footer-link-group');
            var groupKey = group.data('group');
            var wrapper = el.closest('.iconbox-repeater-wrapper');
            var list = group.find('.repeater-list');
            var containerLength = list.find('.all-field-wrap').length;

            var clonedData = wrapper.clone();
            clonedData.find('input[type="text"]').val('');
            clonedData.find('.nav-tabs').attr('id', 'myTab_' + groupKey + '_' + containerLength);
            clonedData.find('.tab-content').first().attr('id', 'myTabContent_' + groupKey + '_' + containerLength);
            clonedData.find('.tab-pane').each(function () {
                var pane = $(this);
                var oldId = pane.attr('id');
                pane.attr('id', oldId + '_clone' + containerLength);
            });
            clonedData.find('.nav-link').each(function () {
                var link = $(this);
                var oldHref = link.attr('href');
                if (oldHref) {
                    link.attr('href', oldHref + '_clone' + containerLength);
                }
            });

            list.append(clonedData);

            if (containerLength > 0) {
                list.find('.remove').show(300);
            }
        });

        $(document).on('click', '.footer-link-group .all-field-wrap .action-wrap .remove', function (e) {
            e.preventDefault();
            var el = $(this);
            var group = el.closest('.footer-link-group');
            var wrapper = el.closest('.iconbox-repeater-wrapper');
            var list = group.find('.repeater-list');

            if (list.find('.all-field-wrap').length > 1) {
                wrapper.hide(300, function () {
                    wrapper.remove();
                });
            } else {
                el.hide(300);
            }
        });
    </script>
@endsection
