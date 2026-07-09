<?php

/* ========================================
    ALL ADMIN PANEL ROUTES
======================================== */
Route::prefix('admin-home')->middleware(['setlang:backend'])->group(function () {

    Route::get('/', 'AdminDashboardController@adminIndex')->name('admin.home');

    /* --------------------------
        MAINTAINS PAGE
    -------------------------- */
    Route::get('/maintains-page/settings', 'MaintainsPageController@maintains_page_settings')->name('admin.maintains.page.settings');
    Route::post('/maintains-page/settings', 'MaintainsPageController@update_maintains_page_settings');


    /*---------------------------
        ADMIN SETTINGS
    ----------------------------*/
    Route::get('/settings', 'AdminDashboardController@admin_settings')->name('admin.profile.settings');
    Route::get('/profile-update', 'AdminDashboardController@admin_profile')->name('admin.profile.update');
    Route::post('/profile-update', 'AdminDashboardController@admin_profile_update');
    Route::get('/password-change', 'AdminDashboardController@admin_password')->name('admin.password.change');
    Route::post('/password-change', 'AdminDashboardController@admin_password_chagne');
    Route::post('/set-static-option', 'AdminDashboardController@admin_set_static_option');
    Route::post('/get-static-option', 'AdminDashboardController@admin_get_static_option');
    Route::post('/update-static-option', 'AdminDashboardController@admin_update_static_option');



    /*------------------------------------------
        ADMIN ROUTES: PRODUCTS MODULES
    ------------------------------------------*/
    Route::prefix('products')->middleware(['adminPermissionCheck:Products Manage', 'moduleCheck:product_module_status' ])->group(function () {
        /*-----------------------------------
            PRODUCTS ROUTES
        ------------------------------------*/
        Route::get('/', 'ProductsController@all_product')->name('admin.products.all');
        Route::get('/new', 'ProductsController@new_product')->name('admin.products.new');
        Route::post('/new', 'ProductsController@store_product');
        Route::get('/edit/{id}', 'ProductsController@edit_product')->name('admin.products.edit');
        Route::post('/update', 'ProductsController@update_product')->name('admin.products.update');
        Route::post('/delete/{id}', 'ProductsController@delete_product')->name('admin.products.delete');
        Route::post('/clone', 'ProductsController@clone_product')->name('admin.products.clone');
        Route::post('/bulk-action', 'ProductsController@bulk_action')->name('admin.products.bulk.action');
        Route::get('/file/download/{id}', 'ProductsController@download_file')->name('admin.products.file.download');
        Route::post('/slug-check', 'ProductsController@slug_check')->name('admin.products.slug.check');
        /*-----------------------------------
           * variant dummy routes
        ------------------------------------*/
        Route::post('/variants/details', function () { return response()->json(['terms' => '[]', 'title' => '', 'id' => 0]); })->name('admin.products.variants.details');
        Route::post('/variants/by-lang', function () { return response()->json([]); })->name('admin.products.variant.by.lang');
        /*-----------------------------------
           PRODUCTS RATINGS ROUTES
       ------------------------------------*/
        Route::group(['prefix' => 'product-ratings'],function (){
            Route::get('/', 'ProductsController@product_ratings')->name('admin.products.ratings');
            Route::post('/delete/{id}', 'ProductsController@product_ratings_delete')->name('admin.products.ratings.delete');
            Route::post('/bulk-action', 'ProductsController@product_ratings_bulk_action')->name('admin.products.ratings.bulk.action');
        });

        /*-----------------------------------
           PRODUCTS  ORDERS ROUTES
       ------------------------------------*/
        Route::group(['prefix' => 'product-order-logs'],function (){
            Route::get('/', 'ProductsController@product_order_logs')->name('admin.products.order.logs');
            Route::post('/approve/{id}', 'ProductsController@product_order_payment_approve')->name('admin.products.order.payment.approve');
            Route::post('/delete/{id}', 'ProductsController@product_order_delete')->name('admin.product.payment.delete');
            Route::post('/status-change', 'ProductsController@product_order_status_change')->name('admin.product.order.status.change');
            Route::post('/bulk-actoin', 'ProductsController@product_order_bulk_action')->name('admin.product.order.bulk.action');
            Route::post('/generate-invoice', 'ProductsController@generate_invoice')->name('admin.product.invoice.generate');
            Route::post('/order-reminder', 'ProductsController@order_reminder')->name('admin.product.order.reminder');
            Route::get('/new-order', 'ProductsController@order_new')->name('admin.product.order.new');
            Route::post('/new-order', 'ProductsController@order_new_store');
            Route::get('/view/{id}', 'ProductsController@order_view')->name('admin.product.order.view');
            Route::post('/get-cart-product-markup-by-ajax', 'ProductsController@cart_markup_by_ajax')->name('admin.product.order.cart.markup.by.ajax');
            Route::post('/get-user-details-by-ajax', 'ProductsController@cart_user_details_ajax')->name('admin.product.order.user.details.ajax');
            Route::post('/recalculate-by-qty-ajax', 'ProductsController@cart_qty_recalculate_ajax')->name('admin.product.order.qty.calculate.ajax');
        });

        /*-----------------------------------
          SETTINGS ROUTES
      ------------------------------------*/
        Route::get('/settings', 'ProductsController@settings')->name('admin.products.settings');
        Route::post('/settings', 'ProductsController@update_settings');


        /*-----------------------------------
            PAGES SETTINGS  ROUTES
        ------------------------------------*/
        Route::get('/page-settings', 'ProductsController@page_settings')->name('admin.products.page.settings');
        Route::post('/page-settings', 'ProductsController@update_page_settings');
        Route::get('/single-page-settings', 'ProductsController@single_page_settings')->name('admin.products.single.page.settings');
        Route::post('/single-page-settings', 'ProductsController@update_single_page_settings');

        Route::get('/success-page-settings', 'ProductsController@success_page_settings')->name('admin.products.success.page.settings');
        Route::post('/success-page-settings', 'ProductsController@update_success_page_settings');
        Route::get('/cancel-page-settings', 'ProductsController@cancel_page_settings')->name('admin.products.cancel.page.settings');
        Route::post('/cancel-page-settings', 'ProductsController@update_cancel_page_settings');

        Route::get('/order-report', 'ProductsController@order_report')->name('admin.products.order.report');
        Route::get('/tax-settings', 'ProductsController@tax_settings')->name('admin.products.tax.settings');
        Route::post('/tax-settings', 'ProductsController@update_tax_settings');

        /*-----------------------------------
          CATEGORY SETTINGS  ROUTES
       ------------------------------------*/
        Route::group(['prefix' => 'category'],function (){
            Route::get('/', 'ProductCategoryController@all_product_category')->name('admin.products.category.all');
            Route::post('/new', 'ProductCategoryController@store_product_category')->name('admin.products.category.new');
            Route::post('/update', 'ProductCategoryController@update_product_category')->name('admin.products.category.update');
            Route::post('/delete/{id}', 'ProductCategoryController@delete_product_category')->name('admin.products.category.delete');
            Route::post('/lang', 'ProductCategoryController@category_by_language_slug')->name('admin.products.category.by.lang');
            Route::post('/bulk-action', 'ProductCategoryController@bulk_action')->name('admin.products.category.bulk.action');
        });

        /*-----------------------------------
         SUBCATEGORY SETTINGS  ROUTES
      ------------------------------------*/
        Route::group(['prefix' => 'subcategory'],function (){
            Route::get('/', 'ProductSubCategoryController@all_product_subcategory')->name('admin.products.subcategory.all');
            Route::post('/new', 'ProductSubCategoryController@store_product_subcategory')->name('admin.products.subcategory.new');
            Route::post('/update', 'ProductSubCategoryController@update_product_subcategory')->name('admin.products.subcategory.update');
            Route::post('/delete/{id}', 'ProductSubCategoryController@delete_product_subcategory')->name('admin.products.subcategory.delete');
            Route::post('/lang', 'ProductSubCategoryController@subcategory_by_language_slug')->name('admin.products.subcategory.by.lang');
            Route::post('/by-cat', 'ProductSubCategoryController@subcategory_by_category')->name('admin.products.subcategory.by.category');
            Route::post('/bulk-action', 'ProductSubCategoryController@bulk_action')->name('admin.products.subcategory.bulk.action');
        });

        /*-----------------------------------
           CATEGORY-WISE FILTER ROUTE
           (Loan / Deposit / Services)
        ------------------------------------*/
        Route::get('/by-category/{category_slug}', 'ProductsController@products_by_category')
             ->name('admin.products.by.category');

    });


    /*==============================================
       SUPPORT TICKET MODULE
    ==============================================*/
    Route::prefix('support-tickets')->middleware(['auth:admin','adminPermissionCheck:Support Tickets','moduleCheck:support_ticket_module_status'])->group(function () {
        Route::get('/', 'SupportTicketController@all_tickets')->name('admin.support.ticket.all');
        Route::get('/new', 'SupportTicketController@new_ticket')->name('admin.support.ticket.new');
        Route::post('/new', 'SupportTicketController@store_ticket');
        Route::post('/delete/{id}', 'SupportTicketController@delete')->name('admin.support.ticket.delete');
        Route::get('/view/{id}', 'SupportTicketController@view')->name('admin.support.ticket.view');
        Route::post('/bulk-action', 'SupportTicketController@bulk_action')->name('admin.support.ticket.bulk.action');
        Route::post('/priority-change', 'SupportTicketController@priority_change')->name('admin.support.ticket.priority.change');
        Route::post('/status-change', 'SupportTicketController@status_change')->name('admin.support.ticket.status.change');
        Route::post('/send message', 'SupportTicketController@send_message')->name('admin.support.ticket.send.message');
        /*-----------------------------------
            SUPPORT TICKET : PAGE SETTINGS ROUTES
        ------------------------------------*/
        Route::get('/page-settings', 'SupportTicketController@page_settings')->name('admin.support.ticket.page.settings');
        Route::post('/page-settings', 'SupportTicketController@update_page_settings');
        /*-----------------------------------
          SUPPORT TICKET : DEPARTMENT ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'department'],function (){
            Route::get('/', 'Admin\SupportDepartmentController@category')->name('admin.support.ticket.department');
            Route::post('/', 'Admin\SupportDepartmentController@new_category');
            Route::post('/delete/{id}', 'Admin\SupportDepartmentController@delete')->name('admin.support.ticket.department.delete');
            Route::post('/update', 'Admin\SupportDepartmentController@update')->name('admin.support.ticket.department.update');
            Route::post('/bulk-action', 'Admin\SupportDepartmentController@bulk_action')->name('admin.support.ticket.department.bulk.action');
        });
    });

    /*==============================================
         LOCATIONS MODULE
    ==============================================*/
    Route::prefix('locations')->middleware(['adminPermissionCheck:Locations Manage'])->group(function () {
        Route::get('/', 'LocationController@all_locations')->name('admin.locations.all');
        Route::get('/new', 'LocationController@new_location')->name('admin.locations.new');
        Route::post('/new', 'LocationController@store_location');
        Route::get('/edit/{id}', 'LocationController@edit_location')->name('admin.locations.edit');
        Route::post('/update', 'LocationController@update_location')->name('admin.locations.update');
        Route::post('/delete/{id}', 'LocationController@delete_location')->name('admin.locations.delete');
        Route::post('/bulk-action', 'LocationController@bulk_action')->name('admin.locations.bulk.action');
    });



    /*==============================================
         JOB MODULE
     ==============================================*/
    Route::prefix('jobs')->middleware(['adminPermissionCheck:Job Post Manage', 'moduleCheck:job_module_status'])->group(function () {

        Route::get('/', 'JobsController@all_jobs')->name('admin.jobs.all');
        Route::get('/new', 'JobsController@new_job')->name('admin.jobs.new');
        Route::post('/new', 'JobsController@store_job');
        Route::get('/edit/{id}', 'JobsController@edit_job')->name('admin.jobs.edit');
        Route::post('/update', 'JobsController@update_job')->name('admin.jobs.update');
        Route::post('/delete/{id}', 'JobsController@delete_job')->name('admin.jobs.delete');
        Route::post('/clone', 'JobsController@clone_job')->name('admin.jobs.clone');
        Route::post('/bulk-action', 'JobsController@bulk_action')->name('admin.jobs.bulk.action');
        Route::post('/slug-check', 'JobsController@slug_check')->name('admin.jobs.slug.check');

        /*-----------------------------------
           JOB MODULE : PAGE SETTINGS ROUTES
        ------------------------------------*/
        Route::get('/page-settings', 'JobsController@page_settings')->name('admin.jobs.page.settings');
        Route::post('/page-settings', 'JobsController@update_page_settings');
        Route::get('/single-page-settings', 'JobsController@single_page_settings')->name('admin.jobs.single.page.settings');
        Route::post('/single-page-settings', 'JobsController@update_single_page_settings');

        /*-----------------------------------
           JOB MODULE : CATEGORY ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'category'],function (){
            Route::get('/', 'JobsCategoryController@all_jobs_category')->name('admin.jobs.category.all');
            Route::post('/new', 'JobsCategoryController@store_jobs_category')->name('admin.jobs.category.new');
            Route::post('/update', 'JobsCategoryController@update_jobs_category')->name('admin.jobs.category.update');
            Route::post('/delete/{id}', 'JobsCategoryController@delete_jobs_category')->name('admin.jobs.category.delete');
            Route::post('/bulk-action', 'JobsCategoryController@bulk_action')->name('admin.jobs.category.bulk.action');
            Route::post('/lang', 'JobsCategoryController@Language_by_slug')->name('admin.jobs.category.by.lang');
        });


        /*-----------------------------------
          JOB MODULE : APPLICANT ROUTES
       ------------------------------------*/
        Route::group(['prefix' => 'applicant'],function () {
            Route::get('/', 'JobsController@all_jobs_applicant')->name('admin.jobs.applicant');
            Route::post('/delete/{id}', 'JobsController@delete_job_applicant')->name('admin.jobs.applicant.delete');
            Route::post('/bulk-delete', 'JobsController@job_applicant_bulk_delete')->name('admin.jobs.applicant.bulk.delete');
            Route::get('/report', 'JobsController@job_applicant_report')->name('admin.jobs.applicant.report');
            Route::post('/mail', 'JobsController@job_applicant_mail')->name('admin.jobs.applicant.mail');
        });


        /*-----------------------------------
          JOB MODULE : PAGE SETTINGS ROUTES
        ------------------------------------*/
        Route::get('/success-page-settings', 'JobsController@success_page_settings')->name('admin.jobs.success.page.settings');
        Route::post('/success-page-settings', 'JobsController@update_success_page_settings');
        Route::get('/cancel-page-settings', 'JobsController@cancel_page_settings')->name('admin.jobs.cancel.page.settings');
        Route::post('/cancel-page-settings', 'JobsController@update_cancel_page_settings');
    });

    /*==============================================
          SERVICES MODULE
    ==============================================*/
    Route::prefix('services')->middleware(['adminPermissionCheck:Services'])->group(function () {
        /*-----------------------------------
         SERVICES MODULE : SERVICES ROUTES
        ------------------------------------*/
        Route::get('/', 'ServiceController@index')->name('admin.services');
        Route::post('/', 'ServiceController@store');
        Route::get('/new', 'ServiceController@new_service')->name('admin.services.new');
        Route::get('/edit/{id}', 'ServiceController@edit_service')->name('admin.services.edit');
        Route::post('/cat-by-slug', 'ServiceController@category_by_slug')->name('admin.service.category.by.slug');
        Route::post('/price-plan-by-slug', 'ServiceController@price_plan_by_slug')->name('admin.service.price.plan.by.slug');
        Route::post('/update', 'ServiceController@update')->name('admin.services.update');
        Route::post('/clone', 'ServiceController@clone_service_as_draft')->name('admin.services.clone');
        Route::post('/bulk-action', 'ServiceController@bulk_action')->name('admin.services.bulk.action');
        Route::post('/delete/{id}', 'ServiceController@delete')->name('admin.services.delete');
        Route::post('/slug-check', 'ServiceController@slug_check')->name('admin.services.slug.check');
        /*-----------------------------------
            SERVICES MODULE : CATEGORY ROUTES
         ------------------------------------*/
        Route::group(['prefix' => 'category' ],function (){
            Route::get('/', 'ServiceController@category_index')->name('admin.service.category');
            Route::post('/', 'ServiceController@category_store');
            Route::post('/update', 'ServiceController@category_update')->name('admin.service.category.update');
            Route::post('/delete/{id}', 'ServiceController@category_delete')->name('admin.service.category.delete');
            Route::post('/bulk-action', 'ServiceController@category_bulk_action')->name('admin.service.category.bulk.action');
        });


        /*-----------------------------------
             SERVICES MODULE : PAGE SETTINGS ROUTES
       ------------------------------------*/
        Route::get('/page-settings', 'ServicePageController@service_page_settings')->name('admin.services.page.settings');
        Route::post('/page-settings', 'ServicePageController@update_service_page_settings');

    });

    /*==============================================
             APPEARANCE SETTINGS
    ==============================================*/
    Route::prefix('appearance-setting')->group(function () {
        /*-----------------------------------
         HOME PAGE VARIANT ROUTES
       ------------------------------------*/
        Route::group(['prefix' => 'navbar-variant','middleware' => ['adminPermissionCheck:Home Variant']],function (){
            Route::get('/', "AdminDashboardController@home_variant")->name('admin.home.variant');
            Route::post('/', "AdminDashboardController@update_home_variant");
            Route::get('/settings', "AdminDashboardController@navbar_settings")->name('admin.navbar.settings');
            Route::post('/settings', "AdminDashboardController@update_navbar_settings");
            Route::post('/color-settings', "AdminDashboardController@update_navbar_color_settings")->name('admin.navbar.color.settings');
        });
        /*-----------------------------------
         BREADCRUMB ROUTES
        ------------------------------------*/
        Route::get('/breadcrumb-settings', "AdminDashboardController@breadcrumb_settings")->name('admin.breadcrumb.settings');
        Route::post('/breadcrumb-settings', "AdminDashboardController@update_breadcrumb_settings");
        /*-----------------------------------
         FOOTER COLOR ROUTES
        ------------------------------------*/
        Route::get('/footer-settings', "AdminDashboardController@footer_settings")->name('admin.footer.settings');
        Route::post('/footer-settings', "AdminDashboardController@update_footer_settings");

        /*-----------------------------------
         TOPBAR SETTINGS ROUTES
       ------------------------------------*/
        Route::prefix('topbar-settings')->middleware(['adminPermissionCheck:Topbar Settings', ])->group(function () {

            Route::get('/', "TopBarController@topbar_settings")->name('admin.topbar.settings');
            Route::post('/', "TopBarController@update_topbar_settings");

            Route::group(['prefix' => 'topbar'],function (){
                Route::post('/new-social-item', 'TopBarController@new_social_item')->name('admin.new.social.item');
                Route::post('/update-social-item', 'TopBarController@update_social_item')->name('admin.update.social.item');
                Route::post('/delete-social-item/{id}', 'TopBarController@delete_social_item')->name('admin.delete.social.item');
                Route::post('/info-item', 'TopBarController@store_info_item')->name('admin.support.info.item');
            });

        });
    });


    /*==============================================
                HOME PAGE MANAGE ROUTES
    ==============================================*/
    Route::middleware(['adminPermissionCheck:Home Page Manage' ])->group(function () {
        /*-----------------------------------
            HOME ONE ROUTES
       ------------------------------------*/
        Route::group(['prefix' => 'home-page-01'],function (){
            Route::get('/brand-logos', 'HomePageController@home_01_brand_logos_area')->name('admin.homeone.brand.logos');
            Route::post('/brand-logos', 'HomePageController@home_01_update_brand_logos_area');
            Route::get('/latest-news', 'HomePageController@home_01_latest_news')->name('admin.homeone.latest.news');
            Route::post('/latest-news', 'HomePageController@home_01_update_latest_news');
            Route::get('/testimonial', 'HomePageController@home_01_testimonial')->name('admin.homeone.testimonial');
            Route::post('/testimonial', 'HomePageController@home_01_update_testimonial');
            Route::get('/service-area', 'HomePageController@home_01_service_area')->name('admin.homeone.service.area');
            Route::post('/service-area', 'HomePageController@home_01_update_service_area');
            Route::get('/case-study-area', 'HomePageController@home_01_case_study_area')->name('admin.homeone.case.study.area');
            Route::post('/case-study-area', 'HomePageController@home_01_update_case_study_area');
            Route::get('/about-us', 'HomePageController@home_01_about_us')->name('admin.homeone.about.us');
            Route::post('/about-us', 'HomePageController@home_01_update_about_us');

            Route::get('/cta-area', 'HomePageController@home_01_cta_area')->name('admin.homeone.cta.area');
            Route::post('/cta-area', 'HomePageController@home_01_update_cta_area');
            Route::get('/section-manage', 'HomePageController@home_01_section_manage')->name('admin.homeone.section.manage');
            Route::post('/section-manage', 'HomePageController@home_01_update_section_manage');
            Route::get('/price-plan', 'HomePageController@home_01_price_plan')->name('admin.homeone.price.plan');
            Route::post('/price-plan', 'HomePageController@home_01_update_price_plan');
            Route::get('/team-member', 'HomePageController@home_01_team_member')->name('admin.homeone.team.member');
            Route::post('/team-member', 'HomePageController@home_01_update_team_member');
            Route::get('/contact-area', 'HomePageController@home_01_contact_area')->name('admin.homeone.contact.area');
            Route::post('/contact-area', 'HomePageController@home_01_update_contact_area');

            Route::get('/quality-area', 'HomePageController@home_01_quality_area')->name('admin.homeone.quality.area');
            Route::post('/quality-area', 'HomePageController@home_01_update_quality_area');
        });

        /*-----------------------------------
            KEY FEATURES ROUTES
       ------------------------------------*/
        Route::get('/keyfeatures', 'KeyFeaturesController@index')->name('admin.keyfeatures');
        Route::post('/keyfeatures', 'KeyFeaturesController@store');
        Route::post('/home-page-01/keyfeatures', 'KeyFeaturesController@update_section_settings')->name('admin.keyfeature.section');
        Route::post('/update-keyfeatures', 'KeyFeaturesController@update')->name('admin.keyfeatures.update');
        Route::post('/delete-keyfeatures/{id}', 'KeyFeaturesController@delete')->name('admin.keyfeatures.delete');
        Route::post('/keyfeatures/bulk-action', 'KeyFeaturesController@bulk_action')->name('admin.keyfeatures.bulk.action');


        /*-----------------------------------
            HEADERS ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'header'],function (){
            Route::get('/', 'HeaderSliderController@index')->name('admin.header');
            Route::post('/', 'HeaderSliderController@store');
            Route::post('/update', 'HeaderSliderController@update')->name('admin.header.update');
            Route::post('/delete/{id}', 'HeaderSliderController@delete')->name('admin.header.delete');
            Route::post('/bulk-action/', 'HeaderSliderController@bulk_action')->name('admin.header.bulk.action');
        });

        /*----------------------------------------
            HOME PAGE: 05 (PORTFOLIO)
        -----------------------------------------*/
        Route::group(['prefix' => 'home-05'],function (){
            Route::get('/header', 'PortfolioHomePageController@header_area')->name('admin.home05.header');
            Route::post('/header', 'PortfolioHomePageController@update_header_area');
            Route::get('/about', 'PortfolioHomePageController@about_area')->name('admin.home05.about');
            Route::post('/about', 'PortfolioHomePageController@update_about_area');
            Route::get('/expertises', 'PortfolioHomePageController@expertises_area')->name('admin.home05.expertises');
            Route::post('/expertises', 'PortfolioHomePageController@update_expertises_area');
            Route::get('/what-we-offer', 'PortfolioHomePageController@what_we_offer_area')->name('admin.home05.what.offer.area');
            Route::post('/what-we-offer', 'PortfolioHomePageController@update_what_we_offer_area');
            Route::get('/recent-work', 'PortfolioHomePageController@recent_work_area')->name('admin.home05.recent.work.area');
            Route::post('/recent-work', 'PortfolioHomePageController@update_recent_work_area');
            Route::get('/cta-area', 'PortfolioHomePageController@cta_area')->name('admin.home05.cta.area');
            Route::post('/cta-area', 'PortfolioHomePageController@update_cta_area');
            Route::get('/testimonial-area', 'PortfolioHomePageController@testimonial_area')->name('admin.home05.testimonial.area');
            Route::post('/testimonial-area', 'PortfolioHomePageController@update_testimonial_area');
            Route::get('/news-area', 'PortfolioHomePageController@news_area')->name('admin.home05.news.area');
            Route::post('/news-area', 'PortfolioHomePageController@update_news_area');
        });

        /*----------------------------------------
           HOME PAGE: 12 (MEDICAL)
         -----------------------------------------*/
        Route::group(['prefix' => '/home-12'], function () {
            Route::get('/header-area', 'MedicalHomePageController@header_area')->name('admin.home12.header');
            Route::post('/header-area', 'MedicalHomePageController@update_header_area');
            Route::get('/about-area', 'MedicalHomePageController@about_area')->name('admin.home12.about');
            Route::post('/about-area', 'MedicalHomePageController@update_about_area');
            Route::get('/service-area', 'MedicalHomePageController@service_area')->name('admin.home12.service');
            Route::post('/service-area', 'MedicalHomePageController@update_service_area');
            Route::get('/cta-area', 'MedicalHomePageController@cta_area')->name('admin.home12.cta');
            Route::post('/cta-area', 'MedicalHomePageController@update_cta_area');
            Route::get('/appointment-area', 'MedicalHomePageController@appointment_area')->name('admin.home12.appointment');
            Route::post('/appointment-area', 'MedicalHomePageController@update_appointment_area');
            Route::post('/appointment-category-by-slug', 'MedicalHomePageController@appointment_category_by_slug')->name('admin.home12.appointment.category.by.slug');
            Route::get('/case-study-area', 'MedicalHomePageController@case_study_area')->name('admin.home12.case.study');
            Route::post('/case-study-area', 'MedicalHomePageController@update_case_study_area');
            Route::get('/testimonial-area', 'MedicalHomePageController@testimonial_area')->name('admin.home12.testimonial');
            Route::post('/testimonial-area', 'MedicalHomePageController@update_testimonial_area');
            Route::get('/news-area', 'MedicalHomePageController@news_area')->name('admin.home12.news');
            Route::post('/news-area', 'MedicalHomePageController@update_news_area');

        });
        /*-----------------------------------
           HOME 21 ROUTES
        ------------------------------------*/
        Route::group(['namespace' => 'Admin','prefix' => 'home-page-21'],function (){
            /* header area */
            Route::get('/header-area', 'CreativeAgencyHomePageManageController@header_area')->name('admin.home21.header');
            Route::post('/header-area', 'CreativeAgencyHomePageManageController@header_area_update');

            /* services area */
            Route::get('/services-area', 'CreativeAgencyHomePageManageController@services_area')->name('admin.home21.services');
            Route::post('/services-area', 'CreativeAgencyHomePageManageController@services_area_update');

            /* project area */
            Route::get('/project-area', 'CreativeAgencyHomePageManageController@project_area')->name('admin.home21.project');
            Route::post('/project-area', 'CreativeAgencyHomePageManageController@project_area_update');

            /* counterup area */
            Route::get('/counterup-area', 'CreativeAgencyHomePageManageController@counterup_area')->name('admin.home21.counterup');
            Route::post('/counterup-area', 'CreativeAgencyHomePageManageController@counterup_area_update');

            /* blog area */
            Route::get('/blog-area', 'CreativeAgencyHomePageManageController@blog_area')->name('admin.home21.blog');
            Route::post('/blog-area', 'CreativeAgencyHomePageManageController@blog_area_update');

            /* testimonial area */
            Route::get('/testimonial-area', 'CreativeAgencyHomePageManageController@testimonial_area')->name('admin.home21.testimonial');
            Route::post('/testimonial-area', 'CreativeAgencyHomePageManageController@testimonial_area_update');

            /* contact area */
            Route::get('/contact-area', 'CreativeAgencyHomePageManageController@contact_area')->name('admin.home21.contact');
            Route::post('/contact-area', 'CreativeAgencyHomePageManageController@contact_area_update');

            /* newsletter area */
            Route::get('/newsletter-area', 'CreativeAgencyHomePageManageController@newsletter_area')->name('admin.home21.newsletter');
            Route::post('/newsletter-area', 'CreativeAgencyHomePageManageController@newsletter_area_update');

        }); //end home 21 routes group

        /*-----------------------------------
         HOME 20 ROUTES
      ------------------------------------*/
        Route::group(['namespace' => 'Admin','prefix' => 'home-page-20'],function (){
            /* breaking news area */
            Route::get('/breaking-news-area', 'NewspaperHomePageManageController@breaking_news_area')->name('admin.home20.breaking.news');
            Route::post('/breaking-news-area', 'NewspaperHomePageManageController@breaking_news_area_update');

            /* header area */
            Route::get('/header-area', 'NewspaperHomePageManageController@header_area')->name('admin.home20.header');
            Route::post('/header-area', 'NewspaperHomePageManageController@header_area_update');

            /* advertisement area */
            Route::get('/advertisement-area', 'NewspaperHomePageManageController@advertisement_area')->name('admin.home20.advertisement');
            Route::post('/advertisement-area', 'NewspaperHomePageManageController@advertisement_area_update');

            /* popular area */
            Route::get('/popular-news-area', 'NewspaperHomePageManageController@popular_area')->name('admin.home20.popular');
            Route::post('/popular-news-area', 'NewspaperHomePageManageController@popular_area_update');
            /* video area */
            Route::get('/video-news-area', 'NewspaperHomePageManageController@video_area')->name('admin.home20.video');
            Route::post('/video-news-area', 'NewspaperHomePageManageController@video_area_update');

            /* Sports News area */
            Route::get('/sports-news-area', 'NewspaperHomePageManageController@sports_area')->name('admin.home20.sports');
            Route::post('/sports-news-area', 'NewspaperHomePageManageController@sports_area_update');

            /* Hot News area */
            Route::get('/hot-news-area', 'NewspaperHomePageManageController@hot_area')->name('admin.home20.hot');
            Route::post('/hot-news-area', 'NewspaperHomePageManageController@hot_area_update');

        }); // home 20 routes group

        /*-----------------------------------
            HOME 19 ROUTES
        ------------------------------------*/
        Route::group(['namespace' => 'Admin','prefix' => 'home-page-19'],function (){
            /* header area */
            Route::get('/header-area', 'FashionEcommerceHomePageController@header_area')->name('admin.home19.header');
            Route::post('/header-area', 'FashionEcommerceHomePageController@header_area_update');

            /* Today's deal area */
            Route::get('/todays-deal-area', 'FashionEcommerceHomePageController@todays_deal_area')->name('admin.home19.todays.deal');
            Route::post('/todays-deal-area', 'FashionEcommerceHomePageController@todays_deal_area_update');

            /* Updated area */
            Route::get('/updated-area', 'FashionEcommerceHomePageController@updated_area')->name('admin.home19.updated.area');
            Route::post('/updated-area', 'FashionEcommerceHomePageController@updated_area_update');

            /* Store area */
            Route::get('/store-area', 'FashionEcommerceHomePageController@store_area')->name('admin.home19.store.area');
            Route::post('/store-area', 'FashionEcommerceHomePageController@store_area_update');

            /* Clothing area */
            Route::get('/clothing-area', 'FashionEcommerceHomePageController@clothing_area')->name('admin.home19.clothing.area');
            Route::post('/clothing-area', 'FashionEcommerceHomePageController@clothing_area_update');

            /* Popular area */
            Route::get('/popular-area', 'FashionEcommerceHomePageController@popular_area')->name('admin.home19.popular.area');
            Route::post('/popular-area', 'FashionEcommerceHomePageController@popular_area_update');

            /* Instagram area */
            Route::get('/instagram-area', 'FashionEcommerceHomePageController@instagram_area')->name('admin.home19.instagram.area');
            Route::post('/instagram-area', 'FashionEcommerceHomePageController@instagram_area_update');

            /* Promoo area */
            Route::get('/promo-area', 'FashionEcommerceHomePageController@promo_area')->name('admin.home19.promo.area');
            Route::post('/promo-area', 'FashionEcommerceHomePageController@promo_area_update');
            Route::post('/blog-by-lang', 'FashionEcommerceHomePageController@product_by_lang')->name('admin.product.by.lang');
            Route::post('/blog-category-by-lang', 'FashionEcommerceHomePageController@product_category_by_lang')->name('admin.product.category.by.lang');

        }); // home 19 routes group


        /*----------------------------------------
         HOME PAGE: DONATION BY LANGUAGE
        -----------------------------------------*/
        Route::post('/blog-category-by-lang', 'Admin\NewspaperHomePageManageController@blog_category_by_lang')->name('admin.blog.category.by.lang');
    });


    /*==============================================
         ABOUT PAGE ROUTES
    ==============================================*/
    Route::prefix('about-page')->middleware(['adminPermissionCheck:About Page Manage'])->group(function () {
        /*------------------
            ABOUT US
        ------------------*/
        Route::get('/about-us', 'AboutPageController@about_page_about_section')->name('admin.about.page.about');
        Route::post('/about-us', 'AboutPageController@about_page_update_about_section');
        /*------------------
            GLOBAL NETWORK
        ------------------*/
        Route::get('/global-network', 'AboutPageController@about_page_global_network_section')->name('admin.about.global.network');
        Route::post('/global-network', 'AboutPageController@about_page_update_global_network_section');
        /*------------------
            EXPERIENCE
        ------------------*/
        Route::get('/experience', 'AboutPageController@about_page_experience_section')->name('admin.about.experience');
        Route::post('/experience', 'AboutPageController@about_page_update_experience_section');
        /*------------------
            TEAM MEMBER
        ------------------*/
        Route::get('/team-member', 'AboutPageController@about_page_team_member_section')->name('admin.about.team.member');
        Route::post('/team-member', 'AboutPageController@about_page_update_team_member_section');
        /*------------------
            TESTIMONIAL
       ------------------*/
        Route::get('/testimonial', 'AboutPageController@about_page_testimonial_section')->name('admin.about.testimonial');
        Route::post('/testimonial', 'AboutPageController@about_page_update_testimonial_section');
        /*------------------
            SECTION MANAGE
        ------------------*/
        Route::get('/section-manage', 'AboutPageController@about_page_section_manage')->name('admin.about.page.section.manage');
        Route::post('/section-manage', 'AboutPageController@about_page_update_section_manage');
    });

    /*==============================================
         PRELOADER MODULE ROUTES
    ==============================================*/
    Route::prefix('popup-builder')->middleware(['adminPermissionCheck:Popup Builder'])->group(function () {
        Route::get('/all', 'PopupBuilderController@all_popup')->name('admin.popup.builder.all');
        Route::get('/new', 'PopupBuilderController@new_popup')->name('admin.popup.builder.new');
        Route::post('/new', 'PopupBuilderController@store_popup');
        Route::get('/edit/{id}', 'PopupBuilderController@edit_popup')->name('admin.popup.builder.edit');
        Route::post('/update/{id}', 'PopupBuilderController@update_popup')->name('admin.popup.builder.update');
        Route::post('/delete/{id}', 'PopupBuilderController@delete_popup')->name('admin.popup.builder.delete');
        Route::post('/clone/{id}', 'PopupBuilderController@clone_popup')->name('admin.popup.builder.clone');
        Route::post('/bulk-action', 'PopupBuilderController@bulk_action')->name('admin.popup.builder.bulk.action');
    });


    /*==============================================
          FEEDBACK MODULE ROUTES
     ==============================================*/
    Route::prefix('feedback-page')->middleware(['adminPermissionCheck:Feedback Page Manage'])->group(function () {

        /*------------------
            PAGE SETTINGS
        ------------------*/
        Route::get('/page-settings', 'FeedbackController@page_settings')->name('admin.feedback.page.settings');
        Route::post('/page-settings', 'FeedbackController@update_page_settings');
        /*------------------
            FORM BUILDER
       ------------------*/
        Route::get('/form-builder', 'FeedbackController@form_builder')->name('admin.feedback.page.form.builder');
        Route::post('/form-builder', 'FeedbackController@update_form_builder');
        /*------------------
           ALL FEEDBACK
        -------------------*/
        Route::group(['prefix' => 'all-feedback'],function (){
            Route::get('/', 'FeedbackController@all_feedback')->name('admin.feedback.all');
            Route::post('/delete/{id}', 'FeedbackController@delete_feedback')->name('admin.feedback.delete');
            Route::post('/bulk-action', 'FeedbackController@bulk_action')->name('admin.feedback.bulk.action');
        });

    });

    /*==============================================
      IMAGE GALLERY ROUTES
 ==============================================*/

    Route::prefix('video-gallery')->middleware(['adminPermissionCheck:Video Gallery'])->group(function () {
        Route::get('/', 'Admin\VideoGalleryController@index')->name('admin.video.gallery.all');
        Route::post('/new', 'Admin\VideoGalleryController@store')->name('admin.video.gallery.new');
        Route::post('/update', 'Admin\VideoGalleryController@update')->name('admin.video.gallery.update');
        Route::post('/delete/{id}', 'Admin\VideoGalleryController@delete')->name('admin.video.gallery.delete');
        Route::post('/bulk-action', 'Admin\VideoGalleryController@bulk_action')->name('admin.video.gallery.bulk.action');
        Route::get('/page-settings', 'Admin\VideoGalleryController@page_settings')->name('admin.video.gallery.page.settings');
        Route::post('/page-settings', 'Admin\VideoGalleryController@update_page_settings');
    });
    /*==============================================
         IMAGE GALLERY ROUTES
    ==============================================*/

    Route::prefix('gallery-page')->middleware(['adminPermissionCheck:Gallery Page'])->group(function () {
        Route::get('/', 'ImageGalleryPageController@index')->name('admin.gallery.all');
        Route::post('/new', 'ImageGalleryPageController@store')->name('admin.gallery.new');
        Route::post('/update', 'ImageGalleryPageController@update')->name('admin.gallery.update');
        Route::post('/delete/{id}', 'ImageGalleryPageController@delete')->name('admin.gallery.delete');
        Route::post('/bulk-action', 'ImageGalleryPageController@bulk_action')->name('admin.gallery.bulk.action');
        Route::get('/page-settings', 'ImageGalleryPageController@page_settings')->name('admin.gallery.page.settings');
        Route::post('/page-settings', 'ImageGalleryPageController@update_page_settings');
        /*------------------------
            IMAGE CATEGORY
        -------------------------*/
        Route::group(['prefix' => 'category'],function (){
            Route::get('/', 'ImageGalleryPageController@category_index')->name('admin.gallery.category');
            Route::post('/new', 'ImageGalleryPageController@category_store')->name('admin.gallery.category.new');
            Route::post('/update', 'ImageGalleryPageController@category_update')->name('admin.gallery.category.update');
            Route::post('/delete/{id}', 'ImageGalleryPageController@category_delete')->name('admin.gallery.category.delete');
            Route::post('/bulk-action', 'ImageGalleryPageController@category_bulk_action')->name('admin.gallery.category.bulk.action');
        });
        Route::post('/category-by-slug', 'ImageGalleryPageController@category_by_slug')->name('admin.gallery.category.by.lang');

    });



    /*==============================================
         CONTACT PAGE ROUTES
    ==============================================*/
    Route::prefix('contact-page')->middleware(['adminPermissionCheck:Contact Page Manage'])->group(function () {

        Route::get('/form-area', 'ContactPageController@contact_page_form_area')->name('admin.contact.page.form.area');
        Route::post('/form-area', 'ContactPageController@contact_page_update_form_area');
        Route::get('/map', 'ContactPageController@contact_page_map_area')->name('admin.contact.page.map');
        Route::post('/map', 'ContactPageController@contact_page_update_map_area');
        /*------------------------
           SECTION MANAGE ROUTES
        -------------------------*/
        Route::get('/section-manage', 'ContactPageController@contact_page_section_manage')->name('admin.contact.page.section.manage');
        Route::post('/section-manage', 'ContactPageController@contact_page_update_section_manage');

        /*------------------------
           CONTACT INFO ROUTES
        -------------------------*/
        Route::group(['prefix' => 'contact-info'],function (){
            Route::get('/', 'ContactInfoController@index')->name('admin.contact.info');
            Route::post('/', 'ContactInfoController@store');
            Route::post('/title', 'ContactInfoController@contact_info_title')->name('admin.contact.info.title');
            Route::post('/update', 'ContactInfoController@update')->name('admin.contact.info.update');
            Route::post('/delete/{id}', 'ContactInfoController@delete')->name('admin.contact.info.delete');
            Route::post('/bulk-action', 'ContactInfoController@bulk_action')->name('admin.contact.info.bulk.action');
        });

    });

    /*==============================================
        TEAM MEMBER PAGE ROUTES
    ==============================================*/
    Route::prefix('team-member')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        //team member
        Route::get('/', 'TeamMemberController@index')->name('admin.team.member');
        Route::post('/', 'TeamMemberController@store');
        Route::post('/update', 'TeamMemberController@update')->name('admin.team.member.update');
        Route::post('/delete/{id}', 'TeamMemberController@delete')->name('admin.team.member.delete');
        Route::post('/bulk-action', 'TeamMemberController@bulk_action')->name('admin.team.member.bulk.action');
    });

    /*======================================
        DESIGNATION ROUTES
    =======================================*/
    Route::prefix('designation')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        Route::get('/', 'DesignationController@index')->name('admin.designation');
        Route::post('/', 'DesignationController@store')->name('admin.designation.store');
        Route::post('/update', 'DesignationController@update')->name('admin.designation.update');
        Route::post('/delete/{id}', 'DesignationController@delete')->name('admin.designation.delete');
        Route::post('/bulk-action', 'DesignationController@bulk_action')->name('admin.designation.bulk.action');
    });

    /*==============================================
        BOARD OF DIRECTOR ROUTES
    ==============================================*/
    Route::prefix('board-of-director')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        Route::get('/', 'BoardOfDirectorController@index')->name('admin.board.of.director');
        Route::post('/', 'BoardOfDirectorController@store');
        Route::post('/update', 'BoardOfDirectorController@update')->name('admin.board.of.director.update');
        Route::post('/delete/{id}', 'BoardOfDirectorController@delete')->name('admin.board.of.director.delete');
        Route::post('/bulk-action', 'BoardOfDirectorController@bulk_action')->name('admin.board.of.director.bulk.action');
    });

    /*==============================================
        EXECUTIVE COMMITTEE ROUTES
    ==============================================*/
    Route::prefix('executive-committee')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        Route::get('/', 'ExecutiveCommitteeController@index')->name('admin.executive.committee');
        Route::post('/', 'ExecutiveCommitteeController@store');
        Route::post('/update', 'ExecutiveCommitteeController@update')->name('admin.executive.committee.update');
        Route::post('/delete/{id}', 'ExecutiveCommitteeController@delete')->name('admin.executive.committee.delete');
        Route::post('/bulk-action', 'ExecutiveCommitteeController@bulk_action')->name('admin.executive.committee.bulk.action');
    });

    /*==============================================
        AUDIT COMMITTEE ROUTES
    ==============================================*/
    Route::prefix('audit-committee')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        Route::get('/', 'AuditCommitteeController@index')->name('admin.audit.committee');
        Route::post('/', 'AuditCommitteeController@store');
        Route::post('/update', 'AuditCommitteeController@update')->name('admin.audit.committee.update');
        Route::post('/delete/{id}', 'AuditCommitteeController@delete')->name('admin.audit.committee.delete');
        Route::post('/bulk-action', 'AuditCommitteeController@bulk_action')->name('admin.audit.committee.bulk.action');
    });

    /*==============================================
        RISK MANAGEMENT COMMITTEE ROUTES
    ==============================================*/
    Route::prefix('risk-management-committee')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        Route::get('/', 'RiskManagementCommitteeController@index')->name('admin.risk.management.committee');
        Route::post('/', 'RiskManagementCommitteeController@store');
        Route::post('/update', 'RiskManagementCommitteeController@update')->name('admin.risk.management.committee.update');
        Route::post('/delete/{id}', 'RiskManagementCommitteeController@delete')->name('admin.risk.management.committee.delete');
        Route::post('/bulk-action', 'RiskManagementCommitteeController@bulk_action')->name('admin.risk.management.committee.bulk.action');
    });

    /*==============================================
        SENIOR MANAGEMENT ROUTES
    ==============================================*/
    Route::prefix('senior-management')->middleware(['adminPermissionCheck:Team Members'])->group(function () {
        Route::get('/', 'SeniorManagementController@index')->name('admin.senior.management');
        Route::post('/', 'SeniorManagementController@store');
        Route::post('/update', 'SeniorManagementController@update')->name('admin.senior.management.update');
        Route::post('/delete/{id}', 'SeniorManagementController@delete')->name('admin.senior.management.delete');
        Route::post('/bulk-action', 'SeniorManagementController@bulk_action')->name('admin.senior.management.bulk.action');
    });

    /*======================================
        EMAIL TEMPLATE SETTINGS
    =======================================*/
    Route::prefix('email-template')->middleware(['auth:admin','adminPermissionCheck:Email Templates' ])->namespace('Admin')->group(function () {
        Route::get('/all', 'EmailTemplateController@all')->name('admin.email.template.all');
        /*-------------------------------------------
            ADMIN PASSWORD RESET ROUTES
        ---------------------------------------------*/
        Route::get('/admin-password-reset', 'EmailTemplateController@admin_password_reset')->name('admin.email.template.admin.password.reset');
        Route::post('/admin-password-reset', 'EmailTemplateController@update_admin_password_reset');

        /*-------------------------------------------
          USER PASSWORD RESET ROUTES
        ---------------------------------------------*/
        Route::get('/user-password-reset', 'EmailTemplateController@user_password_reset')->name('admin.email.template.user.password.reset');
        Route::post('/user-password-reset', 'EmailTemplateController@update_user_password_reset');

        /*-------------------------------------------
         USER EMAIL VERIFY ROUTES
        ---------------------------------------------*/
        Route::get('/user-email-verify', 'EmailTemplateController@user_email_verify')->name('admin.email.template.user.email.verify');
        Route::post('/user-email-verify', 'EmailTemplateController@update_user_email_verify');

        /*-------------------------------------------
            NEWSLETTER VERIFY ROUTES
        ---------------------------------------------*/
        Route::get('/newsletter-verify', 'EmailTemplateController@newsletter_verify')->name('admin.email.template.newsletter.verify');
        Route::post('/newsletter-verify', 'EmailTemplateController@update_newsletter_verify');

        /*==========================================
            COURSE EMAIL TEMPLATE ROUTE
        ==========================================*/
        /* course enroll admin */
        Route::get('/course-enroll-admin', 'CourseEmailTemplateController@course_enroll_admin')->name('admin.email.template.course.enroll.admin');
        Route::post('/course-enroll-admin', 'CourseEmailTemplateController@update_courese_enroll_admin');
        /* course enroll user */
        Route::get('/course-enroll-user', 'CourseEmailTemplateController@course_enroll_user')->name('admin.email.template.course.enroll.user');
        Route::post('/course-enroll-user', 'CourseEmailTemplateController@update_course_enroll_user');

        /* course payment accept */
        Route::get('/course-payment-accept', 'CourseEmailTemplateController@course_payment_accept')->name('admin.email.template.course.payment.accept');
        Route::post('/course-payment-accept', 'CourseEmailTemplateController@update_course_payment_accept');

        /* course reminder mail */
        Route::get('/course-reminder-mail', 'CourseEmailTemplateController@course_reminder_mail')->name('admin.email.template.course.reminder.mail');
        Route::post('/course-reminder-mail', 'CourseEmailTemplateController@update_course_reminder_mail');

        /*==========================================
           APPOINTMENT EMAIL TEMPLATE ROUTE
       ==========================================*/

        /* appointment booking mail admin */
        Route::get('/appointment-booking-admin', 'AppointmentEmailTempalteController@appointment_booking_admin')->name('admin.email.template.appointment.booking.admin');
        Route::post('/appointment-booking-admin', 'AppointmentEmailTempalteController@update_appointment_booking_admin');

        /* appointment booking mail user */
        Route::get('/appointment-booking-user', 'AppointmentEmailTempalteController@appointment_booking_user')->name('admin.email.template.appointment.booking.user');
        Route::post('/appointment-booking-user', 'AppointmentEmailTempalteController@update_appointment_booking_user');

        /* appointment booking update */
        Route::get('/appointment-booking-update', 'AppointmentEmailTempalteController@appointment_booking_update')->name('admin.email.template.appointment.booking.update');
        Route::post('/appointment-booking-update', 'AppointmentEmailTempalteController@update_appointment_booking_update');

        /* appointment payment accept */
        Route::get('/appointment-payment-accept', 'AppointmentEmailTempalteController@appointment_payment_accept')->name('admin.email.template.appointment.payment.accept');
        Route::post('/appointment-payment-accept', 'AppointmentEmailTempalteController@update_appointment_payment_accept');

        /* appointment reminder mail */
        Route::get('/appointment-reminder-mail', 'AppointmentEmailTempalteController@appointment_reminder_mail')->name('admin.email.template.appointment.reminder.mail');
        Route::post('/appointment-reminder-mail', 'AppointmentEmailTempalteController@update_appointment_reminder_mail');

        /*==========================================
          QUOTE EMAIL TEMPLATE ROUTE
         ==========================================*/
        /* appointment reminder mail */
        Route::get('/quote-mail-to-admin', 'EmailTemplateController@quote_admin_mail')->name('admin.email.template.quote.admin.mail');
        Route::post('/quote-mail-to-admin', 'EmailTemplateController@update_quote_admin_mail');

        /*==========================================
         PACKAGE ORDER EMAIL TEMPLATE ROUTE
        ==========================================*/

        /* package order mail admin */
        Route::get('/package-order-admin', 'PackageOrderEmailTemplateController@package_order_admin')->name('admin.email.template.package.order.admin');
        Route::post('/package-order-admin', 'PackageOrderEmailTemplateController@update_package_order_admin');

        /* package order mail user */
        Route::get('/package-order-user', 'PackageOrderEmailTemplateController@package_order_user')->name('admin.email.template.package.order.user');
        Route::post('/package-order-user', 'PackageOrderEmailTemplateController@update_package_order_user');

        /* package order status change */
        Route::get('/package-order-status-change', 'PackageOrderEmailTemplateController@package_order_status_change')->name('admin.email.template.package.order.status.change');
        Route::post('/package-order-status-change', 'PackageOrderEmailTemplateController@update_package_order_status_change');

        /* package order payment accept */
        Route::get('/package-order-payment-accept', 'PackageOrderEmailTemplateController@package_order_payment_accept')->name('admin.email.template.package.order.payment.accept');
        Route::post('/package-order-payment-accept', 'PackageOrderEmailTemplateController@update_package_order_payment_accept');

        /* package order reminder mail */
        Route::get('/package-order-reminder-mail', 'PackageOrderEmailTemplateController@package_order_reminder_mail')->name('admin.email.template.package.order.reminder.mail');
        Route::post('/package-order-reminder-mail', 'PackageOrderEmailTemplateController@update_package_order_reminder_mail');

        /*==========================================
           JOB APPLICATION EMAIL TEMPLATE ROUTE
         ==========================================*/
        /* package order mail admin */
        Route::get('/job-application-admin', 'JobApplicantEmailTemplateController@job_application_admin')->name('admin.email.template.job.application.admin');
        Route::post('/job-application-admin', 'JobApplicantEmailTemplateController@update_job_application_admin');

        /* package order mail user */
        Route::get('/job-application-user', 'JobApplicantEmailTemplateController@job_application_user')->name('admin.email.template.job.application.user');
        Route::post('/job-application-user', 'JobApplicantEmailTemplateController@update_job_application_user');

        /*==========================================
            EVENT EMAIL TEMPLATE ROUTE
        ==========================================*/

        /* event order mail admin */
        Route::get('/event-attendance-mail-admin', 'EventEmailTemplateController@event_attendance_mail_admin')->name('admin.email.template.event.attendance.mail.admin');
        Route::post('/event-attendance-mail-admin', 'EventEmailTemplateController@update_event_attendance_mail_admin');

        /* event order mail user */
        Route::get('/event-attendance-mail-user', 'EventEmailTemplateController@event_attendance_mail_user')->name('admin.email.template.event.attendance.mail.user');
        Route::post('/event-attendance-mail-user', 'EventEmailTemplateController@update_event_attendance_mail_user');
        /* event order payment accept */
        Route::get('/event-attendance-mail-payment-accept', 'EventEmailTemplateController@event_attendance_mail_payment_accept')->name('admin.email.template.event.attendance.mail.payment.accept');
        Route::post('/event-attendance-mail-payment-accept', 'EventEmailTemplateController@update_event_attendance_mail_payment_accept');

        /* event order reminder mail */
        Route::get('/event-attendance-mail-reminder-mail', 'EventEmailTemplateController@event_attendance_mail_reminder_mail')->name('admin.email.template.event.attendance.mail.reminder.mail');
        Route::post('/event-attendance-mail-reminder-mail', 'EventEmailTemplateController@update_event_attendance_mail_reminder_mail');

        /*==========================================
          PRODUCTS EMAIL TEMPLATE ROUTE
        ==========================================*/

        /* product order mail admin */
        Route::get('/product-order-mail-admin', 'ProductEmailTemplateController@product_order_mail_admin')->name('admin.email.template.product.order.mail.admin');
        Route::post('/product-order-mail-admin', 'ProductEmailTemplateController@update_product_order_mail_admin');

        /* product order mail user */
        Route::get('/product-order-mail-user', 'ProductEmailTemplateController@product_order_mail_user')->name('admin.email.template.product.order.mail.user');
        Route::post('/product-order-mail-user', 'ProductEmailTemplateController@update_product_order_mail_user');

        /* product order payment accept */
        Route::get('/product-order-mail-payment-accept', 'ProductEmailTemplateController@product_order_mail_payment_accept')->name('admin.email.template.product.order.mail.payment.accept');
        Route::post('/product-order-mail-payment-accept', 'ProductEmailTemplateController@update_product_order_mail_payment_accept');

        /* product order reminder mail */
        Route::get('/product-order-mail-reminder-mail', 'ProductEmailTemplateController@product_order_mail_reminder_mail')->name('admin.email.template.product.order.mail.reminder.mail');
        Route::post('/product-order-mail-reminder-mail', 'ProductEmailTemplateController@update_product_order_mail_reminder_mail');

        /* product order reminder mail */
        Route::get('/product-order-status-change-mail', 'ProductEmailTemplateController@product_order_status_change_mail')->name('admin.email.template.product.order.status.change.mail');
        Route::post('/product-order-status-change-mail', 'ProductEmailTemplateController@update_product_order_status_change_mail');

        /*==========================================
          DONATION EMAIL TEMPLATE ROUTE
        ==========================================*/

        /* donation mail admin */
        Route::get('/donation-mail-admin', 'DonationEmailTemplateController@donation_mail_admin')->name('admin.email.template.donation.mail.admin');
        Route::post('/donation-mail-admin', 'DonationEmailTemplateController@update_donation_mail_admin');

        /* donation mail user */
        Route::get('/donation-mail-user', 'DonationEmailTemplateController@donation_mail_user')->name('admin.email.template.donation.mail.user');
        Route::post('/donation-mail-user', 'DonationEmailTemplateController@update_donation_mail_user');

        /* donation payment accept */
        Route::get('/donation-mail-payment-accept', 'DonationEmailTemplateController@donation_mail_payment_accept')->name('admin.email.template.donation.mail.payment.accept');
        Route::post('/donation-mail-payment-accept', 'DonationEmailTemplateController@update_donation_mail_payment_accept');

        /* donation reminder mail */
        Route::get('/donation-mail-reminder-mail', 'DonationEmailTemplateController@donation_mail_reminder_mail')->name('admin.email.template.donation.mail.reminder.mail');
        Route::post('/donation-mail-reminder-mail', 'DonationEmailTemplateController@update_donation_mail_reminder_mail');


    });

    /*==============================================
           FORM BUILDER ROUTES
    ==============================================*/
    Route::prefix('form-builder')->middleware(['adminPermissionCheck:Form Builder'])->group(function () {

        /*-------------------------
            CUSTOM FORM BUILDER
        --------------------------*/
        Route::get('/all', 'Admin\CustomFormBuilderController@all')->name('admin.form.builder.all');
        Route::post('/new', 'Admin\CustomFormBuilderController@store')->name('admin.form.builder.store');
        Route::get('/edit/{id}', 'Admin\CustomFormBuilderController@edit')->name('admin.form.builder.edit');
        Route::post('/update', 'Admin\CustomFormBuilderController@update')->name('admin.form.builder.update');
        Route::post('/delete/{id}', 'Admin\CustomFormBuilderController@delete')->name('admin.form.builder.delete');
        Route::post('/bulk-action', 'Admin\CustomFormBuilderController@bulk_action')->name('admin.form.builder.bulk.action');

        /*-------------------------
         GET IN TOUCH FORM ROUTES
        --------------------------*/
        Route::get('/get-in-touch', 'FormBuilderController@get_in_touch_form_index')->name('admin.form.builder.get.in.touch');
        Route::post('/get-in-touch', 'FormBuilderController@update_get_in_touch_form');
        /*-------------------------
        SERVICE QUERY FORM ROUTES
       --------------------------*/
        Route::get('/service-query', 'FormBuilderController@service_query_index')->name('admin.form.builder.service.query');
        Route::post('/service-query', 'FormBuilderController@update_service_query');
        /*-------------------------
        CASE STUDY FORM ROUTES
       --------------------------*/
        Route::get('/case-study-query', 'FormBuilderController@case_study_query_index')->name('admin.form.builder.case.study.query');
        Route::post('/case-study-query', 'FormBuilderController@update_case_study_query');
        /*-------------------------
        QUOTE FORM ROUTES
       --------------------------*/
        Route::get('/quote-form', 'FormBuilderController@quote_form_index')->name('admin.form.builder.quote');
        Route::post('/quote-form', 'FormBuilderController@update_quote_form');

        /*-------------------------
        ORDER FORM ROUTES
       --------------------------*/
        Route::get('/order-form', 'FormBuilderController@order_form_index')->name('admin.form.builder.order');
        Route::post('/order-form', 'FormBuilderController@update_order_form');
        /*-------------------------
          CONTACT FORM ROUTES
          --------------------------*/
        Route::get('/contact-form', 'FormBuilderController@contact_form_index')->name('admin.form.builder.contact');
        Route::post('/contact-form', 'FormBuilderController@update_contact_form');
        /*-------------------------
           APPLY JOB FORM ROUTES
          --------------------------*/
        Route::get('/apply-job-form', 'FormBuilderController@apply_job_form_index')->name('admin.form.builder.apply.job.form');
        Route::post('/apply-job-form', 'FormBuilderController@update_apply_job_form');
        /*-------------------------
           EVENT ATTENDANCE FORM ROUTES
          --------------------------*/
        Route::get('/event-attendance', 'FormBuilderController@event_attendance_form_index')->name('admin.form.builder.event.attendance.form');
        Route::post('/event-attendance', 'FormBuilderController@update_event_attedance_form');
        /*-------------------------
          APPOINTMENT BOOKING FORM ROUTES
         --------------------------*/
        Route::get('/appoinment-booking', 'FormBuilderController@appointment_form_index')->name('admin.form.builder.appointment.form');
        Route::post('/appoinment-booking', 'FormBuilderController@update_appointment_form');
        /*-------------------------
           ESTIMATE FORM ROUTES
         --------------------------*/
        Route::get('/estimate', 'FormBuilderController@estimate_form_index')->name('admin.form.builder.estimate.form');
        Route::post('/estimate', 'FormBuilderController@update_estimate_form');

    });

    /*==============================================
         NEWSLETTER ROUTES
     ==============================================*/
    Route::prefix('newsletter')->middleware(['adminPermissionCheck:Newsletter Manage'])->group(function () {
        Route::get('/', 'NewsletterController@index')->name('admin.newsletter');
        Route::post('/delete/{id}', 'NewsletterController@delete')->name('admin.newsletter.delete');
        Route::post('/single', 'NewsletterController@send_mail')->name('admin.newsletter.single.mail');
        Route::get('/all', 'NewsletterController@send_mail_all_index')->name('admin.newsletter.mail');
        Route::post('/all', 'NewsletterController@send_mail_all');
        Route::post('/new', 'NewsletterController@add_new_sub')->name('admin.newsletter.new.add');
        Route::post('/bulk-action', 'NewsletterController@bulk_action')->name('admin.newsletter.bulk.action');
        Route::post('/verify-mail-send','NewsletterController@verify_mail_send')->name('admin.newsletter.verify.mail.send');
    });
    /*==============================================
            LANGUAGE ROUTES
     ==============================================*/
    Route::prefix('languages')->middleware(['adminPermissionCheck:Languages'])->group(function () {
        Route::get('/', 'LanguageController@index')->name('admin.languages');
        Route::get('/words/edit/{id}', 'LanguageController@edit_words')->name('admin.languages.words.edit');
        Route::get('/words/frontend/{id}','LanguageController@frontend_edit_words')->name('admin.languages.words.frontend');
        Route::get('/words/backend/{id}','LanguageController@backend_edit_words')->name('admin.languages.words.backend');
        Route::post('/words/new', 'LanguageController@add_new_words')->name('admin.languages.add.new.word');
        Route::post('/words/update/{id}', 'LanguageController@update_words')->name('admin.languages.words.update');
        Route::post('/new', 'LanguageController@store')->name('admin.languages.new');
        Route::post('/update', 'LanguageController@update')->name('admin.languages.update');
        Route::post('/delete/{id}', 'LanguageController@delete')->name('admin.languages.delete');
        Route::post('/clone', 'LanguageController@clone_languages')->name('admin.languages.clone');
        Route::post('/default/{id}', 'LanguageController@make_default')->name('admin.languages.default');
        Route::post('/add-new-string', 'LanguageController@add_new_string')->name('admin.languages.add.string');
        Route::post('/languages/regenerate-source-text','LanguageController@regenerate_source_text')->name('admin.languages.regenerate.source.texts');
    });

    /*==============================================
            MEDIA UPLOAD ROUTES
     ==============================================*/
    Route::prefix('media-upload')->group(function () {
        Route::post('/delete', 'MediaUploadController@delete_upload_media_file')->name('admin.upload.media.file.delete');
        Route::get('/page', 'MediaUploadController@all_upload_media_images_for_page')->name('admin.upload.media.images.page');
        Route::post('/alt', 'MediaUploadController@alt_change_upload_media_file')->name('admin.upload.media.file.alt.change');
    });

    /*==============================================
       BRAND LOGOS
    ==============================================*/
    Route::prefix('achievements')->middleware(['adminPermissionCheck:Our Achievement Manage'])->group(function () {
        //brand logos
        Route::get('/', 'BrandController@index')->name('admin.achievements');
        Route::post('/', 'BrandController@store');
        Route::post('/slug-check', 'BrandController@slug_check')->name('admin.achievements.slug.check');
        Route::post('/update', 'BrandController@update')->name('admin.achievements.update');
        Route::post('/delete/{id}', 'BrandController@delete')->name('admin.achievements.delete');
        Route::post('/bulk-action', 'BrandController@bulk_action')->name('admin.achievements.bulk.action');
    });

    /*==============================================
       BLOGS
    ==============================================*/
    Route::prefix('news')->middleware(['adminPermissionCheck:News Manage'])->group(function () {
        /*-------------------------
          BLOG ROUTES
        --------------------------*/
        Route::get('/', 'BlogController@index')->name('admin.news');
        Route::get('/new', 'BlogController@new_blog')->name('admin.news.new');
        Route::post('/new', 'BlogController@store_new_blog');
        Route::post('/clone', 'BlogController@clone_blog')->name('admin.news.clone');
        Route::get('/edit/{id}', 'BlogController@edit_blog')->name('admin.news.edit');
        Route::post('/update/{id}', 'BlogController@update_blog')->name('admin.news.update');
        Route::post('/delete/{id}', 'BlogController@delete_blog')->name('admin.news.delete');
        Route::post('/bulk-action', 'BlogController@bulk_action')->name('admin.news.bulk.action');
        Route::post('/slug-check', 'BlogController@slug_check')->name('admin.news.slug.check');

        /*-------------------------
          BLOG CATEGORIES ROUTES
        --------------------------*/
        Route::group(['prefix' => 'category'],function (){
            Route::get('/', 'BlogController@category')->name('admin.blog.category');
            Route::post('/', 'BlogController@new_category');
            Route::post('/delete/{id}', 'BlogController@delete_category')->name('admin.blog.category.delete');
            Route::post('/update', 'BlogController@update_category')->name('admin.blog.category.update');
            Route::post('/bulk-action', 'BlogController@category_bulk_action')->name('admin.blog.category.bulk.action');
        });


        Route::post('/blog-lang-by-cat', 'BlogController@Language_by_slug')->name('admin.blog.lang.cat');
        /*-------------------------
           BLOG PAGE SETTINGS ROUTES
        --------------------------*/
        Route::get('/page-settings', 'BlogController@blog_page_settings')->name('admin.blog.page.settings');
        Route::post('/page-settings', 'BlogController@update_blog_page_settings');
        Route::get('/single-settings', 'BlogController@blog_single_page_settings')->name('admin.blog.single.settings');
        Route::post('/single-settings', 'BlogController@update_blog_single_page_settings');
    });

/*==============================================
   ADVERTISEMENT
==============================================*/
    Route::group(['prefix'=>'our-activities','namespace' => 'Admin'],function(){
        Route::get('/','AdvertisementController@index')->name('admin.advertisement');
        Route::get('/new','AdvertisementController@new_advertisement')->name('admin.advertisement.new');
        Route::post('/store','AdvertisementController@store_advertisement')->name('admin.advertisement.store');
        Route::get('/edit/{id}','AdvertisementController@edit_advertisement')->name('admin.advertisement.edit');
        Route::post('/update/{id}','AdvertisementController@update_advertisement')->name('admin.advertisement.update');
        Route::post('/delete/{id}','AdvertisementController@delete_advertisement')->name('admin.advertisement.delete');
        Route::post('/bulk-action', 'AdvertisementController@bulk_action')->name('admin.advertisement.bulk.action');
    });

    /*==============================================
       BANK DOWNLOADS MODULE ROUTES
    ==============================================*/
    Route::prefix('bank-downloads')->middleware(['adminPermissionCheck:Bank Downloads'])->group(function () {
        
        /*------------------------------------
           BANK DOWNLOADS ROUTES
        ------------------------------------*/
        Route::get('/', 'BankDownloadController@index')->name('admin.bank.download');
        Route::get('/new', 'BankDownloadController@new_download')->name('admin.bank.download.new');
        Route::post('/new', 'BankDownloadController@store_new_download');
        Route::get('/edit/{id}', 'BankDownloadController@edit_download')->name('admin.bank.download.edit');
        Route::post('/update/{id}', 'BankDownloadController@update_download')->name('admin.bank.download.update');
        Route::post('/delete/{id}', 'BankDownloadController@delete_download')->name('admin.bank.download.delete');
        Route::post('/bulk-action', 'BankDownloadController@bulk_action')->name('admin.bank.download.bulk.action');
        Route::post('/slug-check', 'BankDownloadController@slug_check')->name('admin.bank.download.slug.check');
        Route::post('/delete-file', 'BankDownloadController@delete_file')->name('admin.bank.download.delete.file');
        
        /*------------------------------------
           BANK DOWNLOAD CATEGORIES ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'category'],function (){
            Route::get('/', 'BankDownloadController@category')->name('admin.bank.download.category');
            Route::post('/', 'BankDownloadController@new_category');
            Route::post('/delete/{id}', 'BankDownloadController@delete_category')->name('admin.bank.download.category.delete');
            Route::post('/update', 'BankDownloadController@update_category')->name('admin.bank.download.category.update');
            Route::post('/bulk-action', 'BankDownloadController@category_bulk_action')->name('admin.bank.download.category.bulk.action');
        });

        /*------------------------------------
           BANK DOWNLOAD SUBCATEGORIES ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'subcategory'],function (){
            Route::get('/', 'BankDownloadController@subcategory')->name('admin.bank.download.subcategory');
            Route::post('/', 'BankDownloadController@new_subcategory');
            Route::post('/delete/{id}', 'BankDownloadController@delete_subcategory')->name('admin.bank.download.subcategory.delete');
            Route::post('/update', 'BankDownloadController@update_subcategory')->name('admin.bank.download.subcategory.update');
            Route::post('/bulk-action', 'BankDownloadController@subcategory_bulk_action')->name('admin.bank.download.subcategory.bulk.action');
        });

        /*------------------------------------
           AJAX ROUTES
        ------------------------------------*/
        Route::get('/subcategories-by-category/{category_id}', 'BankDownloadController@get_subcategories_by_category')->name('admin.bank.download.subcategories.by.category');
    });

    /*==============================================
      USEFUL LINKS ROUTES
    ==============================================*/
    Route::prefix('useful-links')->middleware(['adminPermissionCheck:Useful Links Manage'])->group(function () {
        Route::get('/', 'UsefulLinkController@index')->name('admin.useful.links.all');
        Route::get('/new', 'UsefulLinkController@new_link')->name('admin.useful.links.new');
        Route::post('/new', 'UsefulLinkController@store_link');
        Route::get('/edit/{id}', 'UsefulLinkController@edit_link')->name('admin.useful.links.edit');
        Route::post('/update/{id}', 'UsefulLinkController@update_link')->name('admin.useful.links.update');
        Route::post('/delete/{id}', 'UsefulLinkController@delete_link')->name('admin.useful.links.delete');
        Route::post('/bulk-action', 'UsefulLinkController@bulk_action')->name('admin.useful.links.bulk.action');
        Route::post('/update-order', 'UsefulLinkController@update_order')->name('admin.useful.links.update.order');
        Route::get('/page-settings', 'UsefulLinkController@page_settings')->name('admin.useful.links.page.settings');
        Route::post('/page-settings', 'UsefulLinkController@update_page_settings')->name('admin.useful.links.page.settings.update');
    });

    /*==============================================
      TENDER ROUTES
    ==============================================*/
    Route::prefix('tender')->middleware(['adminPermissionCheck:Tender Manage'])->group(function () {
        Route::get('/', 'TenderController@index')->name('admin.tender.all');
        Route::get('/new', 'TenderController@new_tender')->name('admin.tender.new');
        Route::post('/new', 'TenderController@store_tender');
        Route::get('/edit/{id}', 'TenderController@edit_tender')->name('admin.tender.edit');
        Route::post('/update/{id}', 'TenderController@update_tender')->name('admin.tender.update');
        Route::post('/delete/{id}', 'TenderController@delete_tender')->name('admin.tender.delete');
        Route::post('/bulk-action', 'TenderController@bulk_action')->name('admin.tender.bulk.action');
        Route::get('/page-settings', 'TenderController@page_settings')->name('admin.tender.page.settings');
        Route::post('/page-settings', 'TenderController@update_page_settings')->name('admin.tender.page.settings.update');
    });

    /*==============================================
      NOTICE ROUTES
    ==============================================*/
    Route::prefix('notice')->middleware(['adminPermissionCheck:Notice Manage'])->group(function () {
        Route::get('/', 'NoticeController@index')->name('admin.notice.all');
        Route::get('/new', 'NoticeController@new_notice')->name('admin.notice.new');
        Route::post('/new', 'NoticeController@store_notice');
        Route::get('/edit/{id}', 'NoticeController@edit_notice')->name('admin.notice.edit');
        Route::post('/update/{id}', 'NoticeController@update_notice')->name('admin.notice.update');
        Route::post('/delete/{id}', 'NoticeController@delete_notice')->name('admin.notice.delete');
        Route::post('/bulk-action', 'NoticeController@bulk_action')->name('admin.notice.bulk.action');
        Route::get('/page-settings', 'NoticeController@page_settings')->name('admin.notice.page.settings');
        Route::post('/page-settings', 'NoticeController@update_page_settings')->name('admin.notice.page.settings.update');
    });

    /*==============================================
      AUCTION ROUTES
    ==============================================*/
    Route::prefix('auction')->middleware(['adminPermissionCheck:Auction Manage'])->group(function () {
        Route::get('/', 'AuctionController@index')->name('admin.auction.all');
        Route::get('/new', 'AuctionController@new_auction')->name('admin.auction.new');
        Route::post('/new', 'AuctionController@store_auction');
        Route::get('/edit/{id}', 'AuctionController@edit_auction')->name('admin.auction.edit');
        Route::post('/update/{id}', 'AuctionController@update_auction')->name('admin.auction.update');
        Route::post('/delete/{id}', 'AuctionController@delete_auction')->name('admin.auction.delete');
        Route::post('/bulk-action', 'AuctionController@bulk_action')->name('admin.auction.bulk.action');
        Route::get('/page-settings', 'AuctionController@page_settings')->name('admin.auction.page.settings');
        Route::post('/page-settings', 'AuctionController@update_page_settings')->name('admin.auction.page.settings.update');
    });

    /*==============================================
      COMPLAINT ROUTES
    ==============================================*/
    Route::prefix('complaint')->middleware(['adminPermissionCheck:Complaint Manage'])->group(function () {
        Route::get('/cell-settings', 'ComplaintCellController@complaint_cell_settings')->name('admin.complaint.cell.settings');
        Route::post('/cell-settings/info', 'ComplaintCellController@update_complaint_cell_info')->name('admin.complaint.cell.info.update');
        Route::post('/cell-settings/new-member', 'ComplaintCellController@new_member')->name('admin.complaint.cell.member.new');
        Route::post('/cell-settings/update-member', 'ComplaintCellController@update_member')->name('admin.complaint.cell.member.update');
        Route::post('/cell-settings/delete-member/{id}', 'ComplaintCellController@delete_member')->name('admin.complaint.cell.member.delete');
        Route::get('/all', 'ComplaintController@all_complaints')->name('admin.complaints.all');
        Route::post('/status-change', 'ComplaintController@status_change')->name('admin.complaints.status.change');
        Route::post('/delete/{id}', 'ComplaintController@delete_complaint')->name('admin.complaints.delete');
    });

    /*==============================================
      AUDIT TRAIL ROUTES
    ==============================================*/
    Route::prefix('audit-logs')->middleware(['adminPermissionCheck:Audit Log Manage'])->group(function () {
        Route::get('/', 'AuditLogController@all')->name('admin.audit.logs.all');
        Route::get('/{id}', 'AuditLogController@show')->name('admin.audit.logs.show');
    });

    /*==============================================
      EXCHANGE RATE ROUTES
    ==============================================*/
    Route::prefix('exchange-rate')->middleware(['adminPermissionCheck:Exchange Rate Manage'])->group(function () {
        Route::get('/', 'ExchangeRateController@index')->name('admin.exchange.rate.all');
        Route::get('/new', 'ExchangeRateController@create')->name('admin.exchange.rate.new');
        Route::post('/new', 'ExchangeRateController@store')->name('admin.exchange.rate.store');
        Route::get('/edit/{id}', 'ExchangeRateController@edit')->name('admin.exchange.rate.edit');
        Route::post('/update/{id}', 'ExchangeRateController@update')->name('admin.exchange.rate.update');
        Route::post('/delete/{id}', 'ExchangeRateController@delete')->name('admin.exchange.rate.delete');
        Route::post('/bulk-action', 'ExchangeRateController@bulk_action')->name('admin.exchange.rate.bulk.action');
    });

    /*==============================================
      PAGES ROUTES
    ==============================================*/
    Route::prefix('page')->middleware(['adminPermissionCheck:Pages Manage'])->group(function () {
        Route::get('/', 'PagesController@index')->name('admin.page');
        Route::get('/new', 'PagesController@new_page')->name('admin.page.new');
        Route::post('/new', 'PagesController@store_new_page');
        Route::get('/edit/{id}', 'PagesController@edit_page')->name('admin.page.edit');
        Route::post('/update/{id}', 'PagesController@update_page')->name('admin.page.update');
        Route::post('/delete/{id}', 'PagesController@delete_page')->name('admin.page.delete');
        Route::post('/bulk-action', 'PagesController@bulk_action')->name('admin.page.bulk.action');
        Route::post('/slug-check', 'PagesController@slug_check')->name('admin.page.slug.check');
    });

    /*==============================================
     404 PAGE ROUTES
    ==============================================*/
    Route::prefix('404-page-manage')->middleware(['adminPermissionCheck:404 Page Manage'])->group(function () {
        Route::get('/', 'Error404PageManage@error_404_page_settings')->name('admin.404.page.settings');
        Route::post('/', 'Error404PageManage@update_error_404_page_settings');
    });

    /*==============================================
       FAQ ROUTES
    ==============================================*/
    Route::prefix('faq')->middleware(['adminPermissionCheck:Faq'])->group(function () {
        Route::get('/', 'FaqController@index')->name('admin.faq');
        Route::post('/', 'FaqController@store');
        Route::post('/update', 'FaqController@update')->name('admin.faq.update');
        Route::post('/delete/{id}', 'FaqController@delete')->name('admin.faq.delete');
        Route::post('/clone', 'FaqController@clone')->name('admin.faq.clone');
        Route::post('/bulk-action', 'FaqController@bulk_action')->name('admin.faq.bulk.action');
    });

    /*==============================================
       VISITOR MANAGE ROUTES
    ==============================================*/
    Route::prefix('visitors')->group(function () {
        Route::get('/', 'VisitorManageController@index')->name('admin.visitors');
        Route::post('/settings', 'VisitorManageController@update_settings')->name('admin.visitors.settings');
        Route::post('/delete/{id}', 'VisitorManageController@delete')->name('admin.visitors.delete');
        Route::post('/bulk-action', 'VisitorManageController@bulk_action')->name('admin.visitors.bulk.action');
        Route::post('/clear-all', 'VisitorManageController@clear_all')->name('admin.visitors.clear.all');
    });

    /*==============================================
        TESTIMONIAL ROUTES
     ==============================================*/
    Route::prefix('testimonial')->middleware(['adminPermissionCheck:Testimonial'])->group(function () {
        Route::get('/', 'TestimonialController@index')->name('admin.testimonial');
        Route::post('/', 'TestimonialController@store');
        Route::post('/clone', 'TestimonialController@clone')->name('admin.testimonial.clone');
        Route::post('/update', 'TestimonialController@update')->name('admin.testimonial.update');
        Route::post('/delete/{id}', 'TestimonialController@delete')->name('admin.testimonial.delete');
        Route::post('/bulk-action', 'TestimonialController@bulk_action')->name('admin.testimonial.bulk.action');
    });

    /*==============================================
           EVENTS MODULE ROUTES
     ==============================================*/
    Route::prefix('events')->middleware(['adminPermissionCheck:Events Manage', 'moduleCheck:events_module_status' ])->group(function () {

        /*----------------------------------------
            EVENTS MODULE: ROUTEs
        ----------------------------------------*/
        Route::get('/all', 'EventsController@all_events')->name('admin.events.all');
        Route::get('/new', 'EventsController@new_event')->name('admin.events.new');
        Route::post('/new', 'EventsController@store_event');
        Route::get('/edit/{id}', 'EventsController@edit_event')->name('admin.events.edit');
        Route::post('/update', 'EventsController@update_event')->name('admin.events.update');
        Route::post('/delete/{id}', 'EventsController@delete_event')->name('admin.events.delete');
        Route::post('/clone', 'EventsController@clone_event')->name('admin.events.clone');
        Route::post('/bulk-action', 'EventsController@bulk_action')->name('admin.events.bulk.action');
        Route::post('/slug-check', 'EventsController@slug_check')->name('admin.events.slug.check');

        /*----------------------------------------
            EVENTS MODULE: PAGE SETTINGS
        ----------------------------------------*/
        Route::get('/page-settings', 'EventsController@page_settings')->name('admin.events.page.settings');
        Route::post('/page-settings', 'EventsController@update_page_settings');
        /*----------------------------------------
            EVENTS MODULE: SUCCESS PAGE SETTINGS
        ----------------------------------------*/

        Route::get('/payment-success-page-settings', 'EventsController@payment_success_page_settings')->name('admin.events.payment.success.page.settings');
        Route::post('/payment-success-page-settings', 'EventsController@update_payment_success_page_settings');
        /*----------------------------------------
          EVENTS MODULE: CANCEL PAGE SETTINGS
        ----------------------------------------*/
        Route::get('/payment-cancel-pag-settings', 'EventsController@payment_cancel_page_settings')->name('admin.events.payment.cancel.page.settings');
        Route::post('/payment-cancel-pag-settings', 'EventsController@update_payment_cancel_page_settings');

        /*----------------------------------------
         EVENTS MODULE: SETTINGS
       ----------------------------------------*/
        Route::get('/settings', 'EventsController@settings')->name('admin.events.settings');
        Route::post('/settings', 'EventsController@update_settings');

        /*----------------------------------------
          EVENTS MODULE: SINGLE PAGE SETTINGS
        ----------------------------------------*/
        Route::get('/single-page-settings', 'EventsController@single_page_settings')->name('admin.events.single.page.settings');
        Route::post('/single-page-settings', 'EventsController@update_single_page_settings');
        Route::get('/attendance', 'EventsController@event_attendance')->name('admin.events.attendance');
        Route::post('/attendance', 'EventsController@update_event_attendance');

        /*----------------------------------------
         EVENTS MODULE: ATTENDANCE SETTINGS
       ----------------------------------------*/
        //event attendance logs
        Route::group(['prefix' => 'attendance'],function (){
            Route::get('/all', 'EventsController@event_attendance_logs')->name('admin.event.attendance.logs');
            Route::post('/all', 'EventsController@update_event_attendance_logs_status');
            Route::post('/delete/{id}', 'EventsController@delete_event_attendance_logs')->name('admin.event.attendance.logs.delete');
            Route::post('/send-mail', 'EventsController@send_mail_event_attendance_logs')->name('admin.event.attendance.send.mail');
            Route::post('/bulk-action', 'EventsController@attendance_logs_bulk_action')->name('admin.event.attendance.bulk.action');
        });

        /*----------------------------------------
           EVENTS MODULE: PAYMENT LOGS
         ----------------------------------------*/
        Route::group(['prefix' => 'event-payment-logs'],function (){
            Route::get('/', 'EventsController@event_payment_logs')->name('admin.event.payment.logs');
            Route::post('/delete/{id}', 'EventsController@delete_event_payment_logs')->name('admin.event.payment.delete');
            Route::post('/approve/{id}', 'EventsController@approve_event_payment')->name('admin.event.payment.approve');
            Route::post('/bulk-action', 'EventsController@payment_logs_bulk_action')->name('admin.event.payment.bulk.action');
        });

        /*----------------------------------------
        EVENTS MODULE: CATEGORY ROUTES
         ----------------------------------------*/
        Route::group(['prefix' => 'category'],function (){
            //event category
            Route::get('/', 'EventsCategoryController@all_events_category')->name('admin.events.category.all');
            Route::post('/new', 'EventsCategoryController@store_events_category')->name('admin.events.category.new');
            Route::post('/update', 'EventsCategoryController@update_events_category')->name('admin.events.category.update');
            Route::post('/delete/{id}', 'EventsCategoryController@delete_events_category')->name('admin.events.category.delete');
            Route::post('/lang', 'EventsCategoryController@Category_by_language_slug')->name('admin.events.category.by.lang');
            Route::post('/bulk-action', 'EventsCategoryController@bulk_action')->name('admin.events.category.bulk.action');
        });

        /*----------------------------------------
        EVENTS MODULE: OTHERS ROUTES
        ----------------------------------------*/
        Route::post('/event-attendance/reminder', 'EventsController@event_attedance_reminder')->name('admin.event.attendance.reminder');
        Route::get('/payment/report', 'EventsController@payment_report')->name('admin.event.payment.report');
        Route::get('/attendance/report', 'EventsController@attendance_report')->name('admin.event.attendance.report');
    });

    /*==============================================
             CASE STUDY MODULE ROUTES
    ==============================================*/
    Route::prefix('important-information')->middleware(['adminPermissionCheck:Important Information'])->group(function () {

        Route::get('/', 'WorksController@index')->name('admin.work');
        Route::post('/', 'WorksController@store');
        Route::get('/new', 'WorksController@new')->name('admin.work.new');
        Route::get('/edit/{id}', 'WorksController@edit')->name('admin.work.edit');
        Route::post('/update', 'WorksController@update')->name('admin.work.update');
        Route::post('/clone', 'WorksController@clone_new_draft')->name('admin.work.clone');
        Route::post('/bulk-action', 'WorksController@bulk_action')->name('admin.work.bulk.action');
        Route::post('/delete/{id}', 'WorksController@delete')->name('admin.work.delete');
        Route::post('/cat-by-slug', 'WorksController@category_by_slug')->name('admin.work.category.by.slug');
        Route::post('/slug-check', 'WorksController@slug_check')->name('admin.work.slug.check');

        /*----------------------------------------------------
             CASE STUDY : CATEGORY ROUTES
        ----------------------------------------------------*/
        Route::group(['prefix' => 'category'],function (){
            Route::get('/', 'WorksController@category_index')->name('admin.work.category');
            Route::post('/', 'WorksController@category_store');
            Route::post('/update', 'WorksController@category_update')->name('admin.work.category.update');
            Route::post('/delete/{id}', 'WorksController@category_delete')->name('admin.work.category.delete');
            Route::post('/bulk-action', 'WorksController@category_bulk_action')->name('admin.work.category.bulk.action');
        });


        /*----------------------------------------------------
            CASE STUDY : SINGLE PAGE SETTINGS ROUTES
        ----------------------------------------------------*/
        Route::get('/single-page/settings', 'WorkSinglePageController@work_single_page_settings')->name('admin.work.single.page.settings');
        Route::post('/single-page/settings', 'WorkSinglePageController@update_work_single_page_settings');
        /*----------------------------------------------------
           CASE STUDY : PAGE SETTINGS ROUTES
        ----------------------------------------------------*/
        Route::get('/page/settings', 'WorkSinglePageController@work_page_settings')->name('admin.work.page.settings');
        Route::post('/page/settings', 'WorkSinglePageController@update_work_page_settings');
    });

    /*==============================================
             WIDGETS MODULE ROUTES
    ==============================================*/
    Route::prefix('widgets')->middleware(['adminPermissionCheck:Widgets Manage'])->group(function () {

        Route::get('/', 'WidgetsController@index')->name('admin.widgets');
        Route::post('/create', 'WidgetsController@new_widget')->name('admin.widgets.new');
        Route::post('/update', 'WidgetsController@update_widget')->name('admin.widgets.update');
        Route::post('/markup', 'WidgetsController@widget_markup')->name('admin.widgets.markup');
        Route::post('/update/order', 'WidgetsController@update_order_widget')->name('admin.widgets.update.order');
        Route::post('/delete', 'WidgetsController@delete_widget')->name('admin.widgets.delete');
    });

    /*==============================================
             WIDGETS MODULE ROUTES
    ==============================================*/
    Route::prefix('menu')->middleware(['adminPermissionCheck:Menus Manage'])->group(function () {
        Route::get('/', 'MenuController@index')->name('admin.menu');
        Route::post('/new', 'MenuController@store_new_menu')->name('admin.menu.new');
        Route::get('/edit/{id}', 'MenuController@edit_menu')->name('admin.menu.edit');
        Route::post('/update/{id}', 'MenuController@update_menu')->name('admin.menu.update');
        Route::post('/delete/{id}', 'MenuController@delete_menu')->name('admin.menu.delete');
        Route::post('/default/{id}', 'MenuController@set_default_menu')->name('admin.menu.default');
        Route::post('/mega-menu', 'MenuController@mega_menu_item_select_markup')->name('admin.mega.menu.item.select.markup');
    });

    /*==============================================
          FRONTEND USER MANAGE
    ==============================================*/
    Route::prefix('frontend/user')->middleware(['adminPermissionCheck:Users Manage'])->group(function () {
        Route::get('/new', 'FrontendUserManageController@new_user')->name('admin.frontend.new.user');
        Route::post('/new', 'FrontendUserManageController@new_user_add');
        Route::post('/update', 'FrontendUserManageController@user_update')->name('admin.frontend.user.update');
        Route::post('/password-change', 'FrontendUserManageController@user_password_change')->name('admin.frontend.user.password.change');
        Route::post('/delete/{id}', 'FrontendUserManageController@new_user_delete')->name('admin.frontend.delete.user');
        Route::get('/all', 'FrontendUserManageController@all_user')->name('admin.all.frontend.user');
        Route::post('/all/bulk-action', 'FrontendUserManageController@bulk_action')->name('admin.all.frontend.user.bulk.action');
        Route::post('/all/email-status', 'FrontendUserManageController@email_status')->name('admin.all.frontend.user.email.status');

    });

    /*==============================================
         ADMIN ROLE MANAGE MANAGE
    ==============================================*/
    Route::prefix('admin')->middleware(['adminPermissionCheck:Admin Manage'])->group(function () {
        /*----------------------------------------------------
            ADMIN MANAGE
         ----------------------------------------------------*/
        Route::get('/new', 'UserRoleManageController@new_user')->name('admin.new.user');
        Route::post('/new', 'UserRoleManageController@new_user_add');
        Route::post('/update', 'UserRoleManageController@user_update')->name('admin.user.update');
        Route::post('/password-change', 'UserRoleManageController@user_password_change')->name('admin.user.password.change');
        Route::post('/delete/{id}', 'UserRoleManageController@new_user_delete')->name('admin.delete.user');
        Route::get('/all', 'UserRoleManageController@all_user')->name('admin.all.user');
        /*----------------------------------------------------
          ADMIN ROLE MANAGE
        ----------------------------------------------------*/
        Route::group(['prefix' => 'all/role'],function (){
            Route::get('/', 'UserRoleManageController@all_user_role')->name('admin.all.user.role');
            Route::post('/', 'UserRoleManageController@add_new_user_role');
            Route::post('/update', 'UserRoleManageController@udpate_user_role')->name('admin.user.role.edit');
            Route::post('/delete/{id}', 'UserRoleManageController@delete_user_role')->name('admin.user.role.delete');
        });

    });

    /*==============================================
        GENERAL SETTINGS ROUTES
     ==============================================*/

    Route::prefix('general-settings')->middleware(['adminPermissionCheck:General Settings'])->group(function () {
        /*----------------------------------------------------
            DATABASE UPGRADE
        ----------------------------------------------------*/
        Route::get('/database-upgrade', 'GeneralSettingsController@database_upgrade')->name('admin.general.database.upgrade');
        Route::post('/database-upgrade', 'GeneralSettingsController@database_upgrade_post');
        /*----------------------------------------------------
              SITE IDENTITY
        ----------------------------------------------------*/
        Route::get('/site-identity', 'GeneralSettingsController@site_identity')->name('admin.general.site.identity');
        Route::post('/site-identity', 'GeneralSettingsController@update_site_identity');

        /*----------------------------------------------------
            COLOR SETTINGS
      ----------------------------------------------------*/
        Route::get('/color-settings', 'GeneralSettingsController@color_settings')->name('admin.general.color.settings');
        Route::post('/color-settings', 'GeneralSettingsController@update_color_settings');

        /*----------------------------------------------------
            BASIC SETTINGS
        ----------------------------------------------------*/
        Route::get('/basic-settings', 'GeneralSettingsController@basic_settings')->name('admin.general.basic.settings');
        Route::post('/basic-settings', 'GeneralSettingsController@update_basic_settings');
        /*----------------------------------------------------
          SEO SETTINGS
        ----------------------------------------------------*/
        Route::get('/seo-settings', 'GeneralSettingsController@seo_settings')->name('admin.general.seo.settings');
        Route::post('/seo-settings', 'GeneralSettingsController@update_seo_settings');
        /*----------------------------------------------------
          CUSTOM SCRIPT SETTINGS
         ----------------------------------------------------*/
        Route::get('/scripts', 'GeneralSettingsController@scripts_settings')->name('admin.general.scripts.settings');
        Route::post('/scripts', 'GeneralSettingsController@update_scripts_settings');
        /*----------------------------------------------------
          EMAIL TEMPLATE SETTINGS
        ----------------------------------------------------*/
        Route::get('/email-template', 'GeneralSettingsController@email_template_settings')->name('admin.general.email.template');
        Route::post('/email-template', 'GeneralSettingsController@update_email_template_settings');
        /*----------------------------------------------------
          EMAIL  SETTINGS
         ----------------------------------------------------*/
        Route::get('/email-settings', 'GeneralSettingsController@email_settings')->name('admin.general.email.settings');
        Route::post('/email-settings', 'GeneralSettingsController@update_email_settings');
        /*----------------------------------------------------
          TYPOGRAPHY SETTINGS
        ----------------------------------------------------*/
        Route::get('/typography-settings', 'GeneralSettingsController@typography_settings')->name('admin.general.typography.settings');
        Route::post('/typography-settings', 'GeneralSettingsController@update_typography_settings');
        Route::post('/typography-settings/single', 'GeneralSettingsController@get_single_font_variant')->name('admin.general.typography.single');
        /*----------------------------------------------------
          CACHE SETTINGS
         ----------------------------------------------------*/
        Route::get('/cache-settings', 'GeneralSettingsController@cache_settings')->name('admin.general.cache.settings');
        Route::post('/cache-settings', 'GeneralSettingsController@update_cache_settings');
        /*----------------------------------------------------
         PAGE SETTINGS
        ----------------------------------------------------*/
        Route::get('/page-settings', 'GeneralSettingsController@page_settings')->name('admin.general.page.settings');
        Route::post('/page-settings', 'GeneralSettingsController@update_page_settings');
        /*----------------------------------------------------
         UPDATE SYSTEM SETTINGS
        ----------------------------------------------------*/
        Route::get('/update-system', 'GeneralSettingsController@update_system')->name('admin.general.update.system');
        Route::post('/update-system', 'GeneralSettingsController@update_system_version');

        /*----------------------------------------------------
         CUSTOM CSS SETTINGS
        ----------------------------------------------------*/
        Route::get('/custom-css', 'GeneralSettingsController@custom_css_settings')->name('admin.general.custom.css');
        Route::post('/custom-css', 'GeneralSettingsController@update_custom_css_settings');
        /*----------------------------------------------------
         GDPR SETTINGS
        ----------------------------------------------------*/
        Route::get('/gdpr-settings', 'GeneralSettingsController@gdpr_settings')->name('admin.general.gdpr.settings');
        Route::post('/gdpr-settings', 'GeneralSettingsController@update_gdpr_cookie_settings');

        /*----------------------------------------------------
         FOOTER SETTINGS
        ----------------------------------------------------*/
        Route::get('/footer-settings', 'GeneralSettingsController@footer_settings')->name('admin.general.footer.settings');
        Route::post('/footer-settings', 'GeneralSettingsController@update_footer_settings');

        /*----------------------------------------------------
         UPDATE SETTINGS
        ----------------------------------------------------*/
        Route::get('/update-script', 'ScriptUpdateController@index')->name('admin.general.script.update');
        Route::post('/update-script', 'ScriptUpdateController@update_script');

        /*----------------------------------------------------
          CUSTOM JAVASCRIPT SETTINGS
         ----------------------------------------------------*/
        Route::get('/custom-js', 'GeneralSettingsController@custom_js_settings')->name('admin.general.custom.js');
        Route::post('/custom-js', 'GeneralSettingsController@update_custom_js_settings');

        /*----------------------------------------------------
         REGENERATE IMAGE SETTINGS
        ----------------------------------------------------*/
        Route::get('/regenerate-image', 'GeneralSettingsController@regenerate_image_settings')->name('admin.general.regenerate.thumbnail');
        Route::post('/regenerate-image', 'GeneralSettingsController@update_regenerate_image_settings');

        /*----------------------------------------------------
          SMTP SETTINGS
         ----------------------------------------------------*/
        Route::get('/smtp-settings', 'GeneralSettingsController@smtp_settings')->name('admin.general.smtp.settings');
        Route::post('/smtp-settings', 'GeneralSettingsController@update_smtp_settings');
        Route::post('/smtp-settings/test', 'GeneralSettingsController@test_smtp_settings')->name('admin.general.smtp.settings.test');

        /*----------------------------------------------------
          PAYMENT SETTINGS
         ----------------------------------------------------*/
        Route::get('/payment-settings', 'GeneralSettingsController@payment_settings')->name('admin.general.payment.settings');
        Route::post('/payment-settings', 'GeneralSettingsController@update_payment_settings');

        /*----------------------------------------------------
         PRELOADER SETTINGS
        ----------------------------------------------------*/
        Route::get('/preloader-settings', 'GeneralSettingsController@preloader_settings')->name('admin.general.preloader.settings');
        Route::post('/preloader-settings', 'GeneralSettingsController@update_preloader_settings');
        /*----------------------------------------------------
         POPULAR SETTINGS
        ----------------------------------------------------*/
        Route::get('/popup-settings', 'GeneralSettingsController@popup_settings')->name('admin.general.popup.settings');
        Route::post('/popup-settings', 'GeneralSettingsController@update_popup_settings');

        /*----------------------------------------------------
            LICENSE SETTINGS
        ----------------------------------------------------*/
        Route::get('/license-setting', 'GeneralSettingsController@license_settings')->name('admin.general.license.settings');
        Route::post('/license-setting', 'GeneralSettingsController@update_license_settings');

        Route::post('/license-setting-verify', 'GeneralSettingsController@license_key_generate')->name('admin.general.license.key.generate');
        Route::get('/update-check', 'GeneralSettingsController@update_version_check')->name('admin.general.update.version.check');
        Route::post('/download-update/{productId}/{tenant}', 'GeneralSettingsController@updateDownloadLatestVersion')->name('admin.general.update.download.settings');
        Route::get('/software-update-setting', 'GeneralSettingsController@software_update_check_settings')->name('admin.general.software.update.settings');
//        Route::post('/license-setting', 'GeneralSettingsController@update_license_settings');


        /*----------------------------------------------------
          RSS SETTINGS
         ----------------------------------------------------*/
        Route::get('/rss-settings', 'GeneralSettingsController@rss_feed_settings')->name('admin.general.rss.feed.settings');
        Route::post('/rss-settings', 'GeneralSettingsController@update_rss_feed_settings');

        //Module Settings
        Route::get('/module-settings', 'GeneralSettingsController@module_settings')->name('admin.general.module.settings');
        Route::post('/module-settings', 'GeneralSettingsController@store_module_settings');

        /*----------------------------------------------------
         UPDATE SETTINGS
        ----------------------------------------------------*/
        Route::get('/update-script', 'GeneralSettingsController@update_script_settings')->name('admin.general.update.script.settings');
        Route::post('/update-script', 'GeneralSettingsController@sote_update_script_settings');

        /*----------------------------------------------------
          SITEMAP SETTINGS
         ----------------------------------------------------*/
        Route::get('/sitemap-settings', 'GeneralSettingsController@sitemap_settings')->name('admin.general.sitemap.settings');
        Route::post('/sitemap-settings', 'GeneralSettingsController@update_sitemap_settings');
        Route::post('/sitemap-settings/delete', 'GeneralSettingsController@delete_sitemap_settings')->name('admin.general.sitemap.settings.delete');

    });


    /*===================================================
         PAGE BUILDER ROUTE
     ==================================================*/
    Route::group(['prefix' => 'page-builder','namespace' => 'Admin','middleware' => 'auth:admin'],function () {
        /*-------------------------
            HOME PAGE BUILDER
        -------------------------*/
        Route::get('/home-page', 'PageBuilderController@homepage_builder')->name('admin.home.page.builder');
        Route::post('/home-page', 'PageBuilderController@update_homepage_builder');
        /*-------------------------
             ABOUT PAGE BUILDER
        -------------------------*/
        Route::get('/about-page', 'PageBuilderController@aboutpage_builder')->name('admin.about.page.builder');
        Route::post('/about-page', 'PageBuilderController@update_aboutpage_builder');
        /*-------------------------
             CONTACT PAGE BUILDER
        -------------------------*/
        Route::get('/contact-page', 'PageBuilderController@contactpage_builder')->name('admin.contact.page.builder');
        Route::post('/contact-page', 'PageBuilderController@update_contactpage_builder');

        /*-------------------------
           DYNAMIC PAGE BUILDER
        -------------------------*/
        Route::get('/dynamic-page/{type}/{id}', 'PageBuilderController@dynamicpage_builder')->name('admin.dynamic.page.builder');
        Route::post('/dynamic-page', 'PageBuilderController@update_dynamicpage_builder')->name('admin.dynamic.page.builder.store');

    });


});

/* ============================================
    ALL ADMIN PANEL ROUTES : OPEN FOR DEMO
============================================= */
Route::prefix('admin-home')->group(function () {
    Route::post('/media-upload/all', 'MediaUploadController@all_upload_media_file')->name('admin.upload.media.file.all');
    Route::post('/media-upload', 'MediaUploadController@upload_media_file')->name('admin.upload.media.file');
    Route::post('/media-upload/loadmore', 'MediaUploadController@get_image_for_loadmore')->name('admin.upload.media.file.loadmore');
    /*--------------------------
        PAGE BUILDER
    --------------------------*/
    Route::post('/update', 'Admin\PageBuilderController@update_addon_content')->name('admin.page.builder.update');
    Route::post('/new', 'Admin\PageBuilderController@store_new_addon_content')->name('admin.page.builder.new');
    Route::post('/delete', 'Admin\PageBuilderController@delete')->name('admin.page.builder.delete');
    Route::post('/update-order', 'Admin\PageBuilderController@update_addon_order')->name('admin.page.builder.update.addon.order');
    Route::post('/get-admin-markup', 'Admin\PageBuilderController@get_admin_panel_addon_markup')->name('admin.page.builder.get.addon.markup');
});
