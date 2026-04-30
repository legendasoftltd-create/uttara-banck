<?php $home_page_variant = get_static_option('home_page_variant');?>
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo" style="max-height: 50px;">
            <a href="<?php echo e(route('admin.home')); ?>">
                <?php
                    $logo_type = 'site_logo';
                    if(!empty(get_static_option('site_admin_dark_mode'))){
                        $logo_type = 'site_white_logo';
                    }
                ?>
                <?php echo render_image_markup_by_attachment_id(get_static_option($logo_type)); ?>

            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav id="main_menu_wrap">
                <ul class="metismenu" id="menu">
                    <li class="<?php echo e(active_menu('admin-home')); ?>">
                        <a href="<?php echo e(route('admin.home')); ?>"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span><?php echo app('translator')->get('dashboard'); ?></span>
                        </a>
                    </li>
                    <?php if(check_page_permission('admin_manage')): ?>
                    <li
                        class="main_dropdown
                        <?php if(request()->is(['admin-home/admin/*'])): ?> active <?php endif; ?>
                        ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i>
                            <span><?php echo e(__('Admin Manage')); ?></span></a>
                        <ul class="collapse">
                            <li class="<?php echo e(active_menu('admin-home/admin/all')); ?>"><a
                                        href="<?php echo e(route('admin.all.user')); ?>"><?php echo e(__('All Admin')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/admin/new')); ?>"><a
                                        href="<?php echo e(route('admin.new.user')); ?>"><?php echo e(__('Add New Admin')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/admin/all/role')); ?>"><a
                                        href="<?php echo e(route('admin.all.user.role')); ?>"><?php echo e(__('All Admin Role')); ?></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(check_page_permission_by_string('Users Manage')): ?>
                    <li
                        class="main_dropdown
                        <?php if(request()->is([
                        'admin-home/frontend/user/*',
                        ])): ?> active <?php endif; ?>
                        ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i>
                            <span><?php echo e(__('Users Manage')); ?></span></a>
                        <ul class="collapse">
                            <li class="<?php echo e(active_menu('admin-home/frontend/user/all')); ?>"><a
                                    href="<?php echo e(route('admin.all.frontend.user')); ?>"><?php echo e(__('All Users')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/frontend/user/new')); ?>"><a
                                    href="<?php echo e(route('admin.frontend.new.user')); ?>"><?php echo e(__('Add New User')); ?></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(check_page_permission_by_string('Newsletter Manage')): ?>
                    <li
                        class="main_dropdown <?php if(request()->is(['admin-home/newsletter/*','admin-home/newsletter'])): ?> active <?php endif; ?>
                     ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-email"></i>
                            <span><?php echo e(__('Newsletter Manage')); ?></span></a>
                        <ul class="collapse">
                            <li class="<?php echo e(active_menu('admin-home/newsletter')); ?>"><a
                                        href="<?php echo e(route('admin.newsletter')); ?>"><?php echo e(__('All Subscriber')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/newsletter/all')); ?>"><a
                                        href="<?php echo e(route('admin.newsletter.mail')); ?>"><?php echo e(__('Send Mail To All')); ?></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if(check_page_permission_by_string('Pages Manage')): ?>
                        <li
                        class="main_dropdown
                        <?php if(request()->is(['admin-home/page/*','admin-home/page'])): ?> active <?php endif; ?>
                        ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span><?php echo e(__('Pages')); ?></span></a>
                            <ul class="collapse">
                                <li class="<?php echo e(active_menu('admin-home/page')); ?>"><a
                                            href="<?php echo e(route('admin.page')); ?>"><?php echo e(__('All Pages')); ?></a></li>
                                <li class="<?php echo e(active_menu('admin-home/page/new')); ?>"><a
                                            href="<?php echo e(route('admin.page.new')); ?>"><?php echo e(__('Add New Page')); ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(check_page_permission_by_string('News Manage')): ?>
                        <li
                         class="main_dropdown
                        <?php if(request()->is(['admin-home/news/*','admin-home/news'])): ?> active <?php endif; ?>
                        ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span><?php echo e(__('News')); ?></span></a>
                            <ul class="collapse">
                                <li class="<?php echo e(active_menu('admin-home/news')); ?>"><a
                                            href="<?php echo e(route('admin.news')); ?>"><?php echo e(__('All News')); ?></a></li>
                                
                                <li class="<?php echo e(active_menu('admin-home/news/new')); ?>"><a
                                            href="<?php echo e(route('admin.news.new')); ?>"><?php echo e(__('Add New news')); ?></a></li>
                                
                                
                            </ul>
                        </li>
                    <?php endif; ?>


                    <li class="main_dropdown
                        <?php if(request()->is(['admin-home/our-activities/*','admin-home/our-activities'])): ?> active <?php endif; ?>
                        ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span><?php echo e(__('Our Activities')); ?></span></a>
                        <ul class="collapse">
                                <li class="<?php echo e(active_menu('admin-home/our-activities')); ?> <?php if(request()->is('admin-home/our-activities/edit/*')): ?> active <?php endif; ?>"><a
                                            href="<?php echo e(route('admin.advertisement')); ?>"><?php echo e(__('All Our Activities')); ?></a></li>

                                <li class="<?php echo e(active_menu('admin-home/our-activities/new')); ?>"><a
                                            href="<?php echo e(route('admin.advertisement.new')); ?>"><?php echo e(__('Add New Activity')); ?></a></li>
                        </ul>
                    </li>



                    <?php if(check_page_permission_by_string('Services')): ?>
                    <li class="main_dropdown
                    <?php if(request()->is(['admin-home/services/*','admin-home/services'])): ?> active <?php endif; ?>
                    ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span><?php echo e(__('Services')); ?></span>
                        </a>
                        <ul class="collapse">
                            <li class="<?php echo e(active_menu('admin-home/services')); ?>"><a
                                    href="<?php echo e(route('admin.services')); ?>"><?php echo e(__('All Services')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/services/new')); ?>"><a
                                    href="<?php echo e(route('admin.services.new')); ?>"><?php echo e(__('New Service')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/services/category')); ?>"><a
                                    href="<?php echo e(route('admin.service.category')); ?>"><?php echo e(__('Category')); ?></a></li>
                            
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(check_page_permission_by_string('Important Information')): ?>
                    <li class="main_dropdown
                    <?php if(request()->is(['admin-home/works/*','admin-home/works'])): ?> active <?php endif; ?> ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span><?php echo e(__('Important Information')); ?></span>
                        </a>
                        <ul class="collapse">
                            <li class="<?php echo e(active_menu('admin-home/works')); ?>"><a
                                        href="<?php echo e(route('admin.work')); ?>"><?php echo e(__('All Important Information')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/works/new')); ?>"><a
                                    href="<?php echo e(route('admin.work.new')); ?>"><?php echo e(__('New Important Information')); ?></a></li>
                            <li class="<?php echo e(active_menu('admin-home/works/category')); ?>"><a
                                        href="<?php echo e(route('admin.work.category')); ?>"><?php echo e(__('Category')); ?></a></li>
                            
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(check_page_permission_by_string('Gallery Page')): ?>
                        <li class="main_dropdown
                        <?php echo e(active_menu('admin-home/gallery-page')); ?>

                        <?php if(request()->is('admin-home/gallery-page/*')): ?> active <?php endif; ?>
                                ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span><?php echo e(__('Image Gallery')); ?></span></a>
                            <ul class="collapse">
                                <li class="<?php echo e(active_menu('admin-home/gallery-page')); ?>">
                                    <a href="<?php echo e(route('admin.gallery.all')); ?>" ><?php echo e(__('Image Gallery')); ?></a>
                                </li>
                                <li class="<?php echo e(active_menu('admin-home/gallery-page/category')); ?>">
                                    <a href="<?php echo e(route('admin.gallery.category')); ?>" ><?php echo e(__('Category')); ?></a>
                                </li>
                                
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if(check_page_permission_by_string('Video Gallery')): ?>
                        <li class="main_dropdown
                        <?php echo e(active_menu('admin-home/video-gallery')); ?>

                        <?php if(request()->is('admin-home/video-gallery/*')): ?> active <?php endif; ?>
                                ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span><?php echo e(__('Video Gallery')); ?></span></a>
                            <ul class="collapse">
                                <li class="<?php echo e(active_menu('admin-home/video-gallery')); ?>">
                                    <a href="<?php echo e(route('admin.video.gallery.all')); ?>" ><?php echo e(__('Video Gallery')); ?></a>
                                </li>
                                
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    
                    
                    
                    <li class="main_dropdown
                    <?php if(request()->is(['admin-home/quote-manage/*',
                    'admin-home/package/*',
                    'admin-home/payment-logs',
                    'admin-home/payment-logs/report',
                    'admin-home/jobs',
                    'admin-home/jobs/*',
                    'admin-home/events',
                    'admin-home/events/*',
                    'admin-home/products',
                    'admin-home/products/*',
                    'admin-home/donations',
                    'admin-home/donations/*',
                    'admin-home/knowledge',
                    'admin-home/knowledge/*',
                    'admin-home/appointment/*',
                    'admin-home/courses/*',
                    'admin-home/support-tickets/*',
                    'admin-home/support-tickets',
                    'admin-home/bank-downloads',
                    'admin-home/bank-downloads/*'
                    ])): ?> active <?php endif; ?>">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span><?php echo e(__('All Modules')); ?></span></a>
                        <ul class="collapse ">
                            
                            <?php if(check_page_permission_by_string('Products Manage') && !empty(get_static_option('product_module_status'))): ?>
                                    <li class="main_dropdown
                                    <?php echo e(active_menu('admin-home/products')); ?>

                                    <?php if(request()->is('admin-home/products/*')): ?> active <?php endif; ?>
                                            ">
                                        <a href="javascript:void(0)" aria-expanded="true">
                                            <?php echo e(__('Products Manage')); ?></a>
                                        <ul class="collapse">
                                            <li class="<?php echo e(active_menu('admin-home/products')); ?>"><a
                                                        href="<?php echo e(route('admin.products.all')); ?>"><?php echo e(__('All Products')); ?></a></li>
                                            <li class="<?php echo e(active_menu('admin-home/products/new')); ?>"><a
                                                        href="<?php echo e(route('admin.products.new')); ?>"><?php echo e(__('Add New Product')); ?></a></li>
                                            <li class="<?php echo e(active_menu('admin-home/products/category')); ?>"><a
                                                        href="<?php echo e(route('admin.products.category.all')); ?>"><?php echo e(__('Category')); ?></a></li>
                                            <li class="<?php echo e(active_menu('admin-home/products/subcategory')); ?>"><a
                                                        href="<?php echo e(route('admin.products.subcategory.all')); ?>"><?php echo e(__('Sub Category')); ?></a></li>
                                            
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            
                            <?php if(check_page_permission_by_string('Support Tickets') && !empty(get_static_option('support_ticket_module_status'))): ?>
                                <li class="main_dropdown <?php echo e(active_menu('admin-home/support-tickets')); ?> <?php if(request()->is('admin-home/support-tickets/*')): ?> active <?php endif; ?>"
                                >
                                    <a href="javascript:void(0)" aria-expanded="true">
                                        <?php echo e(__('Support Tickets')); ?></a>
                                    <ul class="collapse">
                                        <li class="<?php echo e(active_menu('admin-home/support-tickets')); ?>">
                                            <a href="<?php echo e(route('admin.support.ticket.all')); ?>"><?php echo e(__('All Tickets')); ?></a></li>
                                        <li class="<?php echo e(active_menu('admin-home/support-tickets/new')); ?>"><a
                                                    href="<?php echo e(route('admin.support.ticket.new')); ?>"><?php echo e(__('Add New Ticket')); ?></a></li>
                                        <li class="<?php echo e(active_menu('admin-home/support-tickets/department')); ?>"><a
                                                    href="<?php echo e(route('admin.support.ticket.department')); ?>"><?php echo e(__('Departments')); ?></a></li>
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if(check_page_permission_by_string('Locations Manage')): ?>
                                <li class="main_dropdown <?php echo e(active_menu('admin-home/locations')); ?> <?php if(request()->is('admin-home/locations/*')): ?> active <?php endif; ?>">
                                    <a href="javascript:void(0)" aria-expanded="true"><?php echo e(__('Locations')); ?></a>
                                    <ul class="collapse">
                                        <li class="<?php echo e(active_menu('admin-home/locations')); ?>"><a href="<?php echo e(route('admin.locations.all')); ?>"><?php echo e(__('All Locations')); ?></a></li>
                                        <li class="<?php echo e(active_menu('admin-home/locations/new')); ?>"><a href="<?php echo e(route('admin.locations.new')); ?>"><?php echo e(__('Add New Location')); ?></a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if(check_page_permission_by_string('Bank Downloads')): ?>
                                <li class="main_dropdown <?php echo e(active_menu('admin-home/bank-downloads')); ?> <?php if(request()->is('admin-home/bank-downloads/*')): ?> active <?php endif; ?>">
                                    <a href="javascript:void(0)" aria-expanded="true"><?php echo e(__('Bank Downloads')); ?></a>
                                    <ul class="collapse">
                                        <li class="<?php echo e(active_menu('admin-home/bank-downloads')); ?>"><a href="<?php echo e(route('admin.bank.download')); ?>"><?php echo e(__('All Downloads')); ?></a></li>
                                        <li class="<?php echo e(active_menu('admin-home/bank-downloads/new')); ?>"><a href="<?php echo e(route('admin.bank.download.new')); ?>"><?php echo e(__('Add New Download')); ?></a></li>
                                        <li class="<?php echo e(active_menu('admin-home/bank-downloads/category')); ?>"><a href="<?php echo e(route('admin.bank.download.category')); ?>"><?php echo e(__('Categories')); ?></a></li>
                                        <li class="<?php echo e(active_menu('admin-home/bank-downloads/subcategory')); ?>"><a href="<?php echo e(route('admin.bank.download.subcategory')); ?>"><?php echo e(__('Subcategories')); ?></a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    
                                        
                                        
                                        
                                        
                                        
                                        

                                        
                                        
                                        
                                        
                                            
                                            
                                            
                                            
                                            
                                            


                                            
                                            

                                        
                                        
                                        
                                        

                                    
                            
                    
                    
                    <?php if(check_page_permission_by_string('General Settings')): ?>
                    <li class="main_dropdown <?php if(request()->is('admin-home/general-settings/*')): ?> active <?php endif; ?>">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span><?php echo e(__('General Settings')); ?></span></a>
                        <ul class="collapse ">
                            <li class="<?php echo e(active_menu('admin-home/general-settings/site-identity')); ?>">
                                <a href="<?php echo e(route('admin.general.site.identity')); ?>"><?php echo e(__('Site Identity')); ?></a>
                            </li>
                            
                           
                            
                        </ul>
                    </li>
                    <?php endif; ?>
                    
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/partials/sidebar.blade.php ENDPATH**/ ?>