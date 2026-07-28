@php $home_page_variant = get_static_option('home_page_variant');@endphp
<style>
/* Modern Admin Sidebar Styling */
.sidebar-menu {
    background: #0f172a !important; /* Dark Slate Blue/Black */
    box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15) !important;
}

.sidebar-header {
    background: #ffffffff !important;
    border-bottom: 1px solid #1e293b !important;
    padding: 24px !important;
}

.main-menu {
    padding: 15px 0 0 0 !important;
    height: calc(100% - 100px) !important;
}

/* Custom Scrollbar for modern feel */
.menu-inner::-webkit-scrollbar {
    width: 6px;
}
.menu-inner::-webkit-scrollbar-track {
    background: transparent;
}
.menu-inner::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.menu-inner::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.25);
}

/* Metismenu items styling */
.metismenu {
    padding: 0 12px 30px 12px !important;
}

.metismenu li {
    margin: 4px 0 !important;
}

.metismenu li a {
    color: #94a3b8 !important; /* Slate 400 */
    font-size: 14px !important;
    font-weight: 500 !important;
    padding: 12px 16px !important;
    border-radius: 8px !important;
    display: flex !important;
    align-items: center !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    text-decoration: none !important;
}

.metismenu li a i {
    color: #64748b !important; /* Slate 500 */
    font-size: 16px !important;
    margin-right: 12px !important;
    transition: all 0.25s ease !important;
    width: 20px !important;
    text-align: center !important;
}

/* Hover State */
.metismenu li a:hover {
    color: #f8fafc !important; /* Slate 50 */
    background: rgba(255, 255, 255, 0.05) !important;
}

.metismenu li a:hover i {
    color: #3faa4d !important; /* Hover icon color */
}

/* Active Menu Item Style */
.metismenu li.active > a {
    color: #ffffff !important;
    background: rgba(63, 170, 77, 0.12) !important;
    border-left: 4px solid #3faa4d !important;
    border-radius: 0 8px 8px 0 !important;
    font-weight: 600 !important;
}

.metismenu li.active > a i {
    color: #3faa4d !important;
}

/* If it is a leaf active item (no submenu / not dropdown parent) */
.metismenu li.active:not(.main_dropdown) > a {
    background: #3faa4d !important;
    color: #ffffff !important;
    border-left: none !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(63, 170, 77, 0.3) !important;
}

.metismenu li.active:not(.main_dropdown) > a i {
    color: #ffffff !important;
}

/* Caret/Arrow indicator custom styling */
.metismenu li a:after {
    color: #64748b !important;
    font-size: 14px !important;
    right: 16px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
}

.metismenu li.active > a:after {
    color: #ffffff !important;
}

/* Dropdown/Sub-menus container */
.metismenu li ul {
    background: rgba(0, 0, 0, 0.15) !important;
    border-radius: 8px !important;
    margin: 4px 0 !important;
    padding: 6px 0 6px 12px !important;
    border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
}

/* Dropdown/Sub-menu links styling */
.metismenu li ul li a {
    padding: 8px 16px 8px 24px !important;
    font-size: 13px !important;
    color: #94a3b8 !important;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    border-radius: 6px !important;
}

.metismenu li ul li a:hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.03) !important;
}

.metismenu li ul li.active > a {
    color: #3faa4d !important;
    background: rgba(63, 170, 77, 0.12) !important;
    font-weight: 600 !important;
}

.metismenu li ul li.active > a i {
    color: #3faa4d !important;
}

/* Arrow position for child items */
.metismenu li li a:after {
    top: 50% !important;
    transform: translateY(-50%) !important;
}

/* ==========================================================
   Mobile/Tablet responsive layouts & toggler styling
   ========================================================== */
@media (max-width: 991px) {
    /* Fixed Sidebar width on mobile drawer style */
    .sidebar-menu {
        width: 280px !important;
        left: 0 !important;
        transform: translateX(0) !important;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* Hide sidebar by sliding it out when collapsed */
    .page-container.sbar_collapsed .sidebar-menu {
        transform: translateX(-100%) !important;
    }

    /* Fixed positioned Hamburger/Close Button */
    .nav-btn {
        position: fixed !important;
        left: 15px !important;
        top: 15px !important;
        z-index: 9999 !important;
        background: #3faa4d !important; /* Brand green */
        border-radius: 8px !important;
        width: 40px !important;
        height: 40px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 0 !important;
        box-shadow: 0 4px 12px rgba(63, 170, 77, 0.3) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
    }

    .nav-btn span {
        width: 20px !important;
        height: 2px !important;
        background: #ffffff !important;
        margin: 2px 0 !important;
        display: block !important;
        transition: all 0.3s ease !important;
    }

    /* Shift toggle button outside the drawer when open and style it as an X close button */
    .page-container:not(.sbar_collapsed) .nav-btn {
        left: 295px !important; /* 280px drawer width + 15px margin */
        background: #ef4444 !important; /* Modern Red Color */
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
    }

    .page-container:not(.sbar_collapsed) .nav-btn span:nth-child(1) {
        transform: rotate(45deg) translate(4px, 4px) !important;
    }

    .page-container:not(.sbar_collapsed) .nav-btn span:nth-child(2) {
        opacity: 0 !important;
    }

    .page-container:not(.sbar_collapsed) .nav-btn span:nth-child(3) {
        transform: rotate(-45deg) translate(4px, -4px) !important;
    }

    /* Reset page containers defaults on mobile */
    .page-container {
        padding-left: 0 !important;
    }

    .main-content {
        width: 100% !important;
        padding-top: 60px !important; /* Make space for top bar mobile toggler */
    }

    /* Full screen modern glass-morphism overlay backdrop */
    .page-container:not(.sbar_collapsed)::after {
        content: "" !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: rgba(15, 23, 42, 0.6) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        backdrop-filter: blur(4px) !important;
        z-index: 90 !important;
        transition: opacity 0.3s ease !important;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Backdrop click-to-close handler for mobile sidebar
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 991) {
            var container = document.querySelector('.page-container');
            if (container && !container.classList.contains('sbar_collapsed')) {
                // If clicked outside sidebar and outside the toggler button, close the sidebar
                if (!e.target.closest('.sidebar-menu') && !e.target.closest('.nav-btn')) {
                    container.classList.add('sbar_collapsed');
                    document.body.classList.add('sidebar_collapsed');
                }
            }
        }
    });
});
</script>
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo" style="max-height: 50px;">
            <a href="{{route('admin.home')}}">
                @php
                    $logo_type = 'site_logo';
                    if(!empty(get_static_option('site_admin_dark_mode'))){
                        $logo_type = 'site_white_logo';
                    }
                @endphp
                {!! render_image_markup_by_attachment_id(get_static_option($logo_type)) !!}
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav id="main_menu_wrap">
                <ul class="metismenu" id="menu">
                    <li class="{{active_menu('admin-home')}}">
                        <a href="{{route('admin.home')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>@lang('dashboard')</span>
                        </a>
                    </li>
                    @if(check_page_permission('admin_manage'))
                    <li
                        class="main_dropdown
                        @if(request()->is(['admin-home/admin/*'])) active @endif
                        ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i>
                            <span>{{__('User Management')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/admin/all')}}"><a
                                        href="{{route('admin.all.user')}}">{{__('All Users')}}</a></li>
                            <li class="{{active_menu('admin-home/admin/new')}}"><a
                                        href="{{route('admin.new.user')}}">{{__('Add New User')}}</a></li>
                            <li class="{{active_menu('admin-home/admin/all/role')}}"><a
                                        href="{{route('admin.all.user.role')}}">{{__('All User Role & Permission')}}</a></li>
                        </ul>
                    </li>
                    @endif

                    @if(check_page_permission_by_string('Pages Manage') || check_page_permission_by_string('Pages View'))
                        <li
                        class="main_dropdown
                        @if(request()->is(['admin-home/page/*','admin-home/page'])) active @endif
                        ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Pages')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/page')}}"><a
                                            href="{{route('admin.page')}}">{{__('All Pages')}}</a></li>
                                @if(check_page_permission_by_string('Pages Edit') || check_page_permission_by_string('Pages Manage'))
                                <li class="{{active_menu('admin-home/page/new')}}"><a
                                            href="{{route('admin.page.new')}}">{{__('Add New Page')}}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(check_page_permission_by_string('News Manage') || check_page_permission_by_string('News View'))
                        <li
                         class="main_dropdown
                        @if(request()->is(['admin-home/news/*','admin-home/news'])) active @endif
                        ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                <span>{{__('News')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/news')}}"><a
                                            href="{{route('admin.news')}}">{{__('All News')}}</a></li>
                                @if(check_page_permission_by_string('News Edit') || check_page_permission_by_string('News Manage'))
                                <li class="{{active_menu('admin-home/news/new')}}"><a
                                            href="{{route('admin.news.new')}}">{{__('Add New news')}}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(check_page_permission_by_string('Our Activities View') || check_page_permission_by_string('activities_view'))
                    <li class="main_dropdown
                        @if(request()->is(['admin-home/our-activities/*','admin-home/our-activities'])) active @endif
                        ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span>{{__('Our Activities')}}</span></a>
                        <ul class="collapse">
                                <li class="{{active_menu('admin-home/our-activities')}} @if(request()->is('admin-home/our-activities/edit/*')) active @endif"><a
                                            href="{{route('admin.advertisement')}}">{{__('All Our Activities')}}</a></li>
                                @if(check_page_permission_by_string('Our Activities Edit') || check_page_permission_by_string('activities_edit'))
                                <li class="{{active_menu('admin-home/our-activities/new')}}"><a
                                            href="{{route('admin.advertisement.new')}}">{{__('Add New Activity')}}</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif

                    @if(check_page_permission('services_view') || check_page_permission_by_string('Services View'))
                    <li class="main_dropdown
                    @if(request()->is(['admin-home/services/*','admin-home/services'])) active @endif
                    ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Our Services')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/services')}}"><a
                                    href="{{route('admin.services')}}">{{__('All Services')}}</a></li>
                            @if(check_page_permission('services_create'))
                            <li class="{{active_menu('admin-home/services/new')}}"><a
                                    href="{{route('admin.services.new')}}">{{__('New Service')}}</a></li>
                            @endif
                            @if(check_page_permission('services_category_view'))
                            <li class="{{active_menu('admin-home/services/category')}}"><a
                                    href="{{route('admin.service.category')}}">{{__('Category')}}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('important_information_view') || check_page_permission_by_string('Important Information View'))
                    <li class="main_dropdown
                    @if(request()->is(['admin-home/important-information/*','admin-home/important-information'])) active @endif ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Important Information')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/important-information')}}"><a
                                        href="{{route('admin.work')}}">{{__('All Important Information')}}</a></li>
                            @if(check_page_permission('important_information_create'))
                            <li class="{{active_menu('admin-home/important-information/new')}}"><a
                                    href="{{route('admin.work.new')}}">{{__('New Important Information')}}</a></li>
                            @endif
                            @if(check_page_permission('important_information_category_view'))
                            <li class="{{active_menu('admin-home/important-information/category')}}"><a
                                        href="{{route('admin.work.category')}}">{{__('Category')}}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission('image_gallery_view') || check_page_permission_by_string('Gallery Page View'))
                        <li class="main_dropdown
                        {{active_menu('admin-home/gallery-page')}}
                        @if(request()->is('admin-home/gallery-page/*')) active @endif
                                ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-picture-o" aria-hidden="true"></i>
                                <span>{{__('Image Gallery')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/gallery-page')}}">
                                    <a href="{{route('admin.gallery.all')}}" >{{__('Image Gallery')}}</a>
                                </li>
                                @if(check_page_permission('image_gallery_category_view'))
                                <li class="{{active_menu('admin-home/gallery-page/category')}}">
                                    <a href="{{route('admin.gallery.category')}}" >{{__('Category')}}</a>
                                </li>
                                @endif
                                @if(check_page_permission('image_gallery_settings'))
                                 <li class="{{active_menu('admin-home/gallery-page/page-settings')}}">
                                    <a href="{{route('admin.gallery.page.settings')}}" >{{__('Gallery Page Settings')}}</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('video_gallery_view') || check_page_permission_by_string('Video Gallery View'))
                        <li class="main_dropdown
                        {{active_menu('admin-home/video-gallery')}}
                        @if(request()->is('admin-home/video-gallery/*')) active @endif
                                ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-video-camera" aria-hidden="true"></i>
                                <span>{{__('Video Gallery')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/video-gallery')}}">
                                    <a href="{{route('admin.video.gallery.all')}}" >{{__('Video Gallery')}}</a>
                                </li>
                                @if(check_page_permission('video_gallery_settings'))
                                <li class="{{active_menu('admin-home/video-gallery/page-settings')}}">
                                    <a href="{{route('admin.video.gallery.page.settings')}}" >{{__('Gallery Page Settings')}}</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    
                    @if(check_page_permission_by_string('Our Achievement Manage') || check_page_permission_by_string('achievement_view'))
                    <li class="main_dropdown {{active_menu('admin-home/achievements')}}">
                        <a href="{{route('admin.achievements')}}" aria-expanded="true"><i class="fa fa-star" aria-hidden="true"></i>
                            <span>{{__('Our Achievement')}}</span></a>
                    </li>
                    @endif 


                    @if(check_page_permission_by_string('Team Members') || check_page_permission_by_string('Board of Director View') || check_page_permission_by_string('Executive Committee View') || check_page_permission_by_string('Audit Committee View') || check_page_permission_by_string('Risk Management Committee View') || check_page_permission_by_string('Senior Management View') || check_page_permission('designation_view') || check_page_permission_by_string('Designation View'))
                    <li class="main_dropdown @if(request()->is(['admin-home/team-member*', 'admin-home/designation*', 'admin-home/board-of-director*', 'admin-home/executive-committee*', 'admin-home/audit-committee*', 'admin-home/risk-management-committee*', 'admin-home/senior-management*'])) active @endif">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users" aria-hidden="true"></i>
                            <span>{{__('Team Manage')}}</span></a>
                        <ul class="collapse ">
                            @if(check_page_permission_by_string('Board of Director View') || check_page_permission_by_string('Team Members'))
                                {{-- Board of Director --}}
                                <li class="main_dropdown @if(request()->is('admin-home/board-of-director*')) active @endif">
                                    <a href="{{route('admin.board.of.director')}}" aria-expanded="true">
                                        <span>{{__('Board of Director')}}</span>
                                    </a>
                                </li>
                            @endif

                            @if(check_page_permission_by_string('Executive Committee View') || check_page_permission_by_string('Team Members'))
                                {{-- Executive Committee --}}
                                <li class="main_dropdown @if(request()->is('admin-home/executive-committee*')) active @endif">
                                    <a href="{{route('admin.executive.committee')}}" aria-expanded="true">
                                        <span>{{__('Executive Committee')}}</span>
                                    </a>
                                </li>
                            @endif

                            @if(check_page_permission_by_string('Audit Committee View') || check_page_permission_by_string('Team Members'))
                                {{-- Audit Committee --}}
                                <li class="main_dropdown @if(request()->is('admin-home/audit-committee*')) active @endif">
                                    <a href="{{route('admin.audit.committee')}}" aria-expanded="true">
                                        <span>{{__('Audit Committee')}}</span>
                                    </a>
                                </li>
                            @endif

                            @if(check_page_permission_by_string('Risk Management Committee View') || check_page_permission_by_string('Team Members'))
                                {{-- Risk Management Committee --}}
                                <li class="main_dropdown @if(request()->is('admin-home/risk-management-committee*')) active @endif">
                                    <a href="{{route('admin.risk.management.committee')}}" aria-expanded="true">
                                        <span>{{__('Risk Management Committee')}}</span>
                                    </a>
                                </li>
                            @endif

                            @if(check_page_permission_by_string('Senior Management View') || check_page_permission_by_string('Team Members'))
                                {{-- Senior Management --}}
                                <li class="main_dropdown @if(request()->is('admin-home/senior-management*')) active @endif">
                                    <a href="{{route('admin.senior.management')}}" aria-expanded="true">
                                        <span>{{__('Senior Management')}}</span>
                                    </a>
                                </li>
                            @endif

                            @if(check_page_permission('designation_view') || check_page_permission_by_string('Designation View') || check_page_permission_by_string('Team Members'))
                                <li class="{{active_menu('admin-home/designation')}}">
                                    <a href="{{route('admin.designation')}}">
                                        <span>{{__('Designations')}}</span></a>
                                </li>
                            @endif
                        </ul> 
                    </li>
                    @endif

                    
                    

                    @if((check_page_permission_by_string('Products Manage') || check_page_permission_by_string('Products View')) && !empty(get_static_option('product_module_status')))
                        @php
                            /* DB থেকে সব published product categories fetch করো */
                            $sidebar_product_categories = \App\ProductCategory::where('status', 'publish')
                                ->where('lang', get_default_language())
                                ->orderBy('title', 'ASC')
                                ->get();
                            /* current URL থেকে active category slug বের করো */
                            $active_cat_slug = request()->segment(3) === 'by-category' ? request()->segment(4) : null;
                        @endphp
                            <li class="main_dropdown
                            @if(request()->is(['admin-home/products', 'admin-home/products/*'])) active @endif
                                    ">
                                <a href="javascript:void(0)" aria-expanded="true">
                                    <i class="fa fa-camera-retro"></i>
                                    <span>{{__('Loan & Deposit Manage')}}</span>
                                </a>
                                <ul class="collapse">

                                    {{--  All Products --}}
                                    
                                    <!-- <li class="@if(request()->is('admin-home/products') && !request()->is('admin-home/products/by-category/*')) active @endif">
                                        <a href="{{route('admin.products.all')}}">
                                            <i class="ti-layout-list-thumb" style="font-size:12px;"></i>
                                            {{__('All Products')}}
                                        </a>
                                    </li> -->

                                    {{--  Dynamic Category Filter Items (DB থেকে আসে) --}}
                                    @foreach($sidebar_product_categories as $sidebar_cat)
                                        @php
                                            $cat_slug = \Illuminate\Support\Str::slug($sidebar_cat->title);
                                        @endphp
                                        <li class="@if($active_cat_slug === $cat_slug) active @endif">
                                            <a href="{{ route('admin.products.by.category', $cat_slug) }}">
                                                
                                                {{ $sidebar_cat->title }}
                                            </a>
                                        </li>
                                    @endforeach

                                    {{--  Add New Product --}}
                                    @if(check_page_permission('products_create'))
                                    <li class="{{active_menu('admin-home/products/new')}}">
                                        <a href="{{route('admin.products.new')}}">
                                            
                                            {{__('Add New Product')}}
                                        </a>
                                    </li>
                                    @endif

                                    {{--  Product Type (Category Manager) --}}
                                    @if(check_page_permission('products_category_view'))
                                    <li class="{{active_menu('admin-home/products/category')}}">
                                        <a href="{{route('admin.products.category.all')}}">
                                            
                                            {{__('Product Type')}}
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                            </li>
                    @endif
                    
                    @if(
                        check_page_permission('jobs_view') || check_page_permission('jobs_category_view') ||
                        check_page_permission('support_ticket_view') || check_page_permission('support_ticket_department_view') ||
                        check_page_permission('locations_view') ||
                        check_page_permission('downloads_view') || check_page_permission('downloads_category_view') ||
                        check_page_permission('visitor_log_view') ||
                        check_page_permission('auction_view') ||
                        check_page_permission('notice_view') ||
                        check_page_permission('complaint_view') ||
                        check_page_permission('audit_log_manage') ||
                        check_page_permission('exchange_rate_view') ||
                        check_page_permission('tender_view') ||
                        check_page_permission('useful_links_view')
                    )
                    <li class="main_dropdown
                    @if(request()->is([
                        'admin-home/jobs',
                        'admin-home/jobs/*',
                        'admin-home/new-jobs',
                        'admin-home/events',
                        'admin-home/events/*',
                        'admin-home/support-tickets/*',
                        'admin-home/support-tickets',
                        'admin-home/bank-downloads',
                        'admin-home/bank-downloads/*',
                        'admin-home/locations',
                        'admin-home/locations/*',
                        'admin-home/auction',
                        'admin-home/auction/*',
                        'admin-home/notice',
                        'admin-home/notice/*',
                        'admin-home/complaint',
                        'admin-home/complaint/*',
                        'admin-home/exchange-rate',
                        'admin-home/exchange-rate/*',
                        'admin-home/tender',
                        'admin-home/tender/*',
                        'admin-home/useful-links',
                        'admin-home/useful-links/*',
                        'admin-home/visitors',
                        'admin-home/audit-logs',
                        'admin-home/visitors/*'
                    ])) active @endif">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span>{{__('All Modules')}}</span></a>
                        <ul class="collapse ">
                            @if((check_page_permission('jobs_view') || check_page_permission('jobs_category_view')) && !empty(get_static_option('job_module_status')))
                                <li
                                    class="main_dropdown
                                    @if(request()->is(['admin-home/jobs/*', 'admin-home/jobs', 'admin-home/new-jobs'])) active @endif
                                    ">
                                    <a href="javascript:void(0)" aria-expanded="true">
                                        {{__('Career Manage')}}</a>
                                    <ul class="collapse">
                                        @if(check_page_permission('jobs_category_view'))
                                        <li class="{{active_menu('admin-home/jobs/category')}}"><a
                                                    href="{{route('admin.jobs.category.all')}}">{{__('Category')}}</a></li>
                                        @endif
                                        @if(check_page_permission('jobs_create'))
                                        <li class="{{active_menu('admin-home/new-jobs')}}"><a
                                                    href="{{route('admin.jobs.new')}}">{{__('Add New Job')}}</a></li>
                                        @endif
                                        @if(check_page_permission('jobs_view'))
                                        <li class="{{active_menu('admin-home/jobs')}}"><a
                                                    href="{{route('admin.jobs.all')}}">{{__('All Jobs')}}</a></li>
                                        @endif
                                        @if(check_page_permission('jobs_settings'))
                                        <li class="{{active_menu('admin-home/jobs/page-settings')}}"><a
                                                    href="{{route('admin.jobs.page.settings')}}">{{__('Job Page Settings')}}</a></li>
                                        @endif
                                        @if(check_page_permission('jobs_single_page_settings'))
                                        <li class="{{active_menu('admin-home/jobs/single-page-settings')}}"><a
                                                    href="{{route('admin.jobs.single.page.settings')}}">{{__('Job Single Page Settings')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            
                            @if(check_page_permission('locations_view'))
                                <li class="main_dropdown {{active_menu('admin-home/locations')}} @if(request()->is('admin-home/locations/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Locations')}}</a>
                                    <ul class="collapse">
                                        <li class="{{active_menu('admin-home/locations')}}"><a href="{{route('admin.locations.all')}}">{{__('All Locations')}}</a></li>
                                        @if(check_page_permission('locations_create'))
                                        <li class="{{active_menu('admin-home/locations/new')}}"><a href="{{route('admin.locations.new')}}">{{__('Add New Location')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if(check_page_permission('downloads_view') || check_page_permission('downloads_category_view'))
                                <li class="main_dropdown {{active_menu('admin-home/bank-downloads')}} @if(request()->is('admin-home/bank-downloads/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Bank Downloads')}}</a>
                                    <ul class="collapse">
                                        @if(check_page_permission('downloads_view'))
                                        <li class="{{active_menu('admin-home/bank-downloads')}}"><a href="{{route('admin.bank.download')}}">{{__('All Downloads')}}</a></li>
                                        @endif
                                        @if(check_page_permission('downloads_create'))
                                        <li class="{{active_menu('admin-home/bank-downloads/new')}}"><a href="{{route('admin.bank.download.new')}}">{{__('Add New Download')}}</a></li>
                                        @endif
                                        @if(check_page_permission('downloads_category_view'))
                                        <li class="{{active_menu('admin-home/bank-downloads/category')}}"><a href="{{route('admin.bank.download.category')}}">{{__('Categories')}}</a></li>
                                        <li class="{{active_menu('admin-home/bank-downloads/subcategory')}}"><a href="{{route('admin.bank.download.subcategory')}}">{{__('Sub Categories')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            @if(check_page_permission('visitor_log_view'))
                            <li class="{{active_menu('admin-home/visitors')}}">
                                <a href="{{route('admin.visitors')}}">
                                    {{__('Visitor Log')}}</a>
                            </li>
                            @endif

                            @if(check_page_permission('auction_view'))
                                <li class="main_dropdown {{active_menu('admin-home/auction')}} @if(request()->is('admin-home/auction/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Auction')}}</a>
                                    <ul class="collapse">
                                        <li class="{{active_menu('admin-home/auction')}}"><a href="{{route('admin.auction.all')}}">{{__('All Auctions')}}</a></li>
                                        @if(check_page_permission('auction_create'))
                                        <li class="{{active_menu('admin-home/auction/new')}}"><a href="{{route('admin.auction.new')}}">{{__('Add New Auction')}}</a></li>
                                        @endif
                                        @if(check_page_permission('auction_settings'))
                                        <li class="{{active_menu('admin-home/auction/page-settings')}}"><a href="{{route('admin.auction.page.settings')}}">{{__('Auction Page Settings')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if(check_page_permission('notice_view'))
                                <li class="main_dropdown {{active_menu('admin-home/notice')}} @if(request()->is('admin-home/notice/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true">{{__('Notice')}}</a>
                                    <ul class="collapse">
                                        <li class="{{active_menu('admin-home/notice')}}"><a href="{{route('admin.notice.all')}}">{{__('All Notices')}}</a></li>
                                        @if(check_page_permission('notice_create'))
                                        <li class="{{active_menu('admin-home/notice/new')}}"><a href="{{route('admin.notice.new')}}">{{__('Add New Notice')}}</a></li>
                                        @endif
                                        @if(check_page_permission('notice_settings'))
                                        <li class="{{active_menu('admin-home/notice/page-settings')}}"><a href="{{route('admin.notice.page.settings')}}">{{__('Notice Page Settings')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if(check_page_permission('complaint_view'))
                                <li class="main_dropdown {{active_menu('admin-home/complaint')}} @if(request()->is('admin-home/complaint/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Complaint')}}</a>
                                    <ul class="collapse">
                                        @if(check_page_permission('complaint_create'))
                                        <li class="{{active_menu('admin-home/complaint/cell-settings')}}"><a href="{{route('admin.complaint.cell.settings')}}">{{__('Complaint Cell Settings')}}</a></li>
                                        @endif
                                        <li class="{{active_menu('admin-home/complaint/all')}}"><a href="{{route('admin.complaints.all')}}">{{__('All Complaints')}}</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if(check_page_permission('audit_log_manage'))
                                <li class="{{active_menu('admin-home/audit-logs')}}">
                                    <a href="{{route('admin.audit.logs.all')}}">{{__('Audit Trail')}}</a>
                                </li>
                            @endif

                            
                            @if(check_page_permission('exchange_rate_view'))
                                <li class="main_dropdown {{active_menu('admin-home/exchange-rate')}} @if(request()->is('admin-home/exchange-rate/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Exchange Rates')}}</a>
                                    <ul class="collapse">
                                        <li class="{{active_menu('admin-home/exchange-rate')}}"><a href="{{route('admin.exchange.rate.all')}}">{{__('All Exchange Rates')}}</a></li>
                                        @if(check_page_permission('exchange_rate_create'))
                                        <li class="{{active_menu('admin-home/exchange-rate/new')}}"><a href="{{route('admin.exchange.rate.new')}}">{{__('Add New Exchange Rate')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            @if(check_page_permission('tender_view'))
                                <li class="main_dropdown {{active_menu('admin-home/tender')}} @if(request()->is('admin-home/tender/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Tender')}}</a>
                                    <ul class="collapse">
                                        <li class="{{active_menu('admin-home/tender')}}"><a href="{{route('admin.tender.all')}}">{{__('All Tenders')}}</a></li>
                                        @if(check_page_permission('tender_create'))
                                        <li class="{{active_menu('admin-home/tender/new')}}"><a href="{{route('admin.tender.new')}}">{{__('Add New Tender')}}</a></li>
                                        @endif
                                        @if(check_page_permission('tender_settings'))
                                        <li class="{{active_menu('admin-home/tender/page-settings')}}"><a href="{{route('admin.tender.page.settings')}}">{{__('Tender Page Settings')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if(check_page_permission('useful_links_view'))
                                <li class="main_dropdown {{active_menu('admin-home/useful-links')}} @if(request()->is('admin-home/useful-links/*')) active @endif">
                                    <a href="javascript:void(0)" aria-expanded="true"> {{__('Useful Links')}}</a>
                                    <ul class="collapse">
                                        <li class="{{active_menu('admin-home/useful-links')}}"><a href="{{route('admin.useful.links.all')}}">{{__('All Links')}}</a></li>
                                        @if(check_page_permission('useful_links_create'))
                                        <li class="{{active_menu('admin-home/useful-links/new')}}"><a href="{{route('admin.useful.links.new')}}">{{__('Add New Link')}}</a></li>
                                        @endif
                                        @if(check_page_permission('useful_links_settings'))
                                        <li class="{{active_menu('admin-home/useful-links/page-settings')}}"><a href="{{route('admin.useful.links.page.settings')}}">{{__('Useful Links Page Settings')}}</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if(check_page_permission('topbar_settings_view') || check_page_permission('popup_builder_view') || check_page_permission('home_page_manage_view') || check_page_permission('404_page_manage_view') || check_page_permission('maintenance_page_view') || check_page_permission('footer_settings_view'))
                    <li class="main_dropdown
                        @if(request()->is([
                        'admin-home/form-builder/*',
                        'admin-home/email-template/*',
                        'admin-home/popup-builder/*',
                        'admin-home/widgets/*',
                        'admin-home/widgets',
                        'admin-home/menu-edit/*',
                        'admin-home/media-upload/page',
                        'admin-home/menu',
                        'admin-home/appearance-setting/*',
                        'admin-home/header',
                        'admin-home/404-page-manage',
                        'admin-home/maintains-page/settings',
                        'admin-home/general-settings/popup-settings',
                        'admin-home/general-settings/footer-settings'
                        ])) active @endif
                        ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span>{{__('Appearance Settings')}}</span></a>
                        <ul class="collapse ">
                            @if(check_page_permission_by_string('topbar_settings_view'))
                                <li class="{{active_menu('admin-home/appearance-setting/topbar-settings')}}">
                                    <a href="{{route('admin.topbar.settings')}}"
                                       aria-expanded="true">
                                        {{__('Topbar Settings')}}
                                    </a>
                                </li>
                            @endif

                            @if(check_page_permission_by_string('popup_builder_view'))
                                    <li class="main_dropdown @if(request()->is('admin-home/popup-builder/*')) active @endif">
                                        <a href="javascript:void(0)"
                                           aria-expanded="true">
                                            {{__('Popup Builder')}}
                                        </a>
                                        <ul class="collapse">
                                            <li class="{{active_menu('admin-home/popup-builder/all')}}"><a
                                                        href="{{route('admin.popup.builder.all')}}">{{__('All Popup')}}</a></li>
                                            @if(check_page_permission_by_string('popup_builder_create'))
                                            <li class="{{active_menu('admin-home/popup-builder/new')}}"><a
                                                        href="{{route('admin.popup.builder.new')}}">{{__('New Popup')}}</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li class="{{active_menu('admin-home/general-settings/popup-settings')}}"><a
                                            href="{{route('admin.general.popup.settings')}}">{{__('Popup Settings')}}</a>
                                    </li>
                            @endif

                            @if(check_page_permission_by_string('media_manage_view'))
                            <li class="{{active_menu('admin-home/media-upload/page')}}">
                               <a href="{{route('admin.upload.media.images.page')}}">
                                   {{__('Media  Manage')}}
                               </a>
                            </li>
                            @endif

                            @if(check_page_permission_by_string('home_page_manage_view'))
                                    <li class="{{active_menu('admin-home/header')}}">
                                        <a href="{{route('admin.header')}}">
                                            {{__('Header Area')}}
                                        </a>
                                    </li>
                            @endif
                            @if(check_page_permission_by_string('404_page_manage_view'))
                                        <li class="{{active_menu('admin-home/404-page-manage')}}">
                                            <a href="{{route('admin.404.page.settings')}}">
                                                {{__('404 Page Manage')}}</a>
                                        </li>
                            @endif
                            @if(check_page_permission_by_string('maintenance_page_view'))
                                        <li class="{{active_menu('admin-home/maintains-page/settings')}}">
                                            <a href="{{route('admin.maintains.page.settings')}}">
                                            {{__('Maintain Page Manage')}}
                                            </a>
                                        </li>
                            @endif
                                
                            @if(check_page_permission_by_string('footer_settings_view'))
                                    <li class="{{active_menu('admin-home/general-settings/footer-settings')}}"><a
                                             href="{{route('admin.general.footer.settings')}}">{{__('Footer Settings')}}</a>
                                    </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(check_page_permission_by_string('general_settings_view') || check_page_permission_by_string('site_identity_view') || check_page_permission_by_string('third_party_scripts_view') || check_page_permission_by_string('smtp_settings_view') || check_page_permission_by_string('cache_settings_view') || check_page_permission_by_string('gdpr_settings_view') || check_page_permission_by_string('sitemap_settings_view') || check_page_permission_by_string('rss_settings_view') || check_page_permission_by_string('faq_view'))
                    <li class="main_dropdown @if((request()->is('admin-home/general-settings/*') && !request()->is(['admin-home/general-settings/footer-settings', 'admin-home/general-settings/popup-settings'])) || request()->is(['admin-home/faq', 'admin-home/faq/*'])) active @endif">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span>{{__('General Settings')}}</span></a>
                        <ul class="collapse ">
                            @if(check_page_permission_by_string('general_settings_view'))
                            <li class="{{active_menu('admin-home/general-settings/basic-settings')}}">
                                <a href="{{route('admin.general.basic.settings')}}">{{__('Basic Settings')}}</a>
                            </li>
                            @endif
                            @if(check_page_permission_by_string('site_identity_view'))
                            <li class="{{active_menu('admin-home/general-settings/site-identity')}}">
                                <a href="{{route('admin.general.site.identity')}}">{{__('Site Identity')}}</a>
                            </li>
                            @endif
                            
                            @if(check_page_permission_by_string('third_party_scripts_view'))
                            <li class="{{active_menu('admin-home/general-settings/scripts')}}"><a
                                        href="{{route('admin.general.scripts.settings')}}">{{__('Third Party Scripts')}}</a>
                            </li> 
                            @endif

                            @if(check_page_permission_by_string('smtp_settings_view'))
                            <li class="{{active_menu('admin-home/general-settings/smtp-settings')}}"><a
                                        href="{{route('admin.general.smtp.settings')}}">{{__('SMTP Settings')}}</a>
                            </li>
                            @endif
                           
                            @if(check_page_permission_by_string('cache_settings_view'))
                            <li class="{{active_menu('admin-home/general-settings/cache-settings')}}"><a
                                        href="{{route('admin.general.cache.settings')}}">{{__('Cache Settings')}}</a>
                            </li>
                            @endif
                            @if(check_page_permission_by_string('gdpr_settings_view'))
                            <li class="{{active_menu('admin-home/general-settings/gdpr-settings')}}"><a
                                        href="{{route('admin.general.gdpr.settings')}}">{{__('GDPR Compliant Cookies Settings')}}</a>
                            </li>
                            @endif
                            
                            @if(check_page_permission_by_string('sitemap_settings_view'))
                            <li class="{{active_menu('admin-home/general-settings/sitemap-settings')}}"><a
                                    href="{{route('admin.general.sitemap.settings')}}">{{__('Sitemap Settings')}}</a>
                            </li>
                            @endif
                            @if(check_page_permission_by_string('rss_settings_view'))
                            <li class="{{active_menu('admin-home/general-settings/rss-settings')}}"><a
                                    href="{{route('admin.general.rss.feed.settings')}}">{{__('RSS Feed Settings')}}</a>
                            </li>
                            @endif

                            @if(check_page_permission_by_string('FAQ') || check_page_permission_by_string('Faq View'))
                                <li class="{{active_menu('admin-home/faq')}}">
                                    <a href="{{route('admin.faq')}}">
                                        <span>{{__('Faq')}}</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                </ul>
            </nav>
        </div>
    </div>
</div>
