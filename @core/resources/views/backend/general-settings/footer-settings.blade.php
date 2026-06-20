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
                                    $all_icon_fields = get_static_option($option_key.'_icon');
                                    $all_icon_fields = !empty($all_icon_fields) ? unserialize($all_icon_fields,['allowed_classes' => false]) : [];
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
                                                    <div class="form-group icon-picker-wrapper">
                                                        @php
                                                            $icon_field = $all_icon_fields[$index] ?? '';
                                                            $icon_preview_class = $icon_field ?: 'far fa-square';
                                                        @endphp
                                                        <label class="d-block">{{__('Icon')}} <small class="text-muted">({{__('optional, leave empty to hide')}})</small></label>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary iconpicker-component">
                                                                <i class="{{$icon_preview_class}}"></i>
                                                            </button>
                                                            <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                                                    data-selected="{{$icon_field}}" data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu"></div>
                                                            <button type="button" class="btn btn-light icon-clear-btn" title="{{__('Remove Icon')}}">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" class="form-control" value="{{$icon_field}}" name="{{$option_key}}_icon[]">
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
        var footerCloneCounter = Date.now();

        $(document).on('click', '.footer-link-group .action-wrap .add', function (e) {
            e.preventDefault();
            var el = $(this);
            var group = el.closest('.footer-link-group');
            var groupKey = group.data('group');
            var wrapper = el.closest('.iconbox-repeater-wrapper');
            var list = group.find('.repeater-list');

            footerCloneCounter++;
            var uid = groupKey + '_' + footerCloneCounter;

            var clonedData = wrapper.clone();
            clonedData.find('input[type="text"]').val('');
            clonedData.find('.icon-picker-wrapper input[type="hidden"]').val('');
            clonedData.find('.icon-picker-wrapper .icp-dd').attr('data-selected', '');
            clonedData.find('.icon-picker-wrapper .iconpicker-component i').attr('class', 'far fa-square');
            clonedData.find('.icon-picker-wrapper .iconpicker-popover').remove();

            clonedData.find('.nav-tabs').attr('id', 'myTab_' + uid);
            clonedData.find('.tab-content').first().attr('id', 'myTabContent_' + uid);

            clonedData.find('.tab-pane').each(function (i) {
                var pane = $(this);
                var baseId = pane.attr('id').replace(/_clone_\d+$/, '').replace(/_\d+$/, '');
                pane.attr('id', baseId + '_clone_' + footerCloneCounter);
                pane.removeClass('show active');
                if (i === 0) pane.addClass('show active');
            });

            clonedData.find('.nav-link').each(function (i) {
                var link = $(this);
                var oldHref = link.attr('href');
                if (oldHref) {
                    var baseHref = oldHref.replace(/_clone_\d+$/, '').replace(/_\d+$/, '');
                    link.attr('href', baseHref + '_clone_' + footerCloneCounter);
                }
                link.removeClass('active');
                if (i === 0) link.addClass('active');
            });

            list.append(clonedData);
            list.find('.remove').show(300);
            clonedData.find('.icp-dd').iconpicker();
        });

        $('.icp-dd').iconpicker();
        $('body').on('iconpickerSelected', '.icp-dd', function (e) {
            var selectedIcon = e.iconpickerValue;
            var wrapper = $(this).closest('.icon-picker-wrapper');
            wrapper.find('input[type="hidden"]').val(selectedIcon);
            wrapper.find('.iconpicker-component i').attr('class', selectedIcon);
            $('body .dropdown-menu.iconpicker-container').removeClass('show');
        });

        $(document).on('click', '.icon-clear-btn', function (e) {
            e.preventDefault();
            var wrapper = $(this).closest('.icon-picker-wrapper');
            wrapper.find('input[type="hidden"]').val('');
            wrapper.find('.iconpicker-component i').attr('class', 'far fa-square');
            wrapper.find('.icp-dd').attr('data-selected', '');
        });

        $(document).on('click', '.footer-link-group .action-wrap .remove', function (e) {
            e.preventDefault();
            var el = $(this);
            var group = el.closest('.footer-link-group');
            var wrapper = el.closest('.iconbox-repeater-wrapper');
            var list = group.find('.repeater-list');

            if (list.find('.iconbox-repeater-wrapper').length > 1) {
                wrapper.hide(300, function () {
                    wrapper.remove();
                });
            } else {
                el.hide(300);
            }
        });
    </script>
@endsection
