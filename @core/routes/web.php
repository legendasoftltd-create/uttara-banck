<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//rss feed route
Route::feeds();

//courses module
Route::group(['middleware' => ['setlang:frontend', 'globalVariable', 'maintains_mode']], function () {

    Route::post('/poplar-item-by-category-ajax', 'FrontendController@popular_item_by_category')->name('frontend.popular.item.by.category');
    Route::post('/product-story-item-by-category-ajax', 'FrontendController@product_story_item_by_category')->name('frontend.story.product.item.by.category');

    Route::get('home/advertisement/click/store','FrontendController@home_advertisement_click_store')->name('frontend.home.advertisement.click.store');
    Route::get('home/advertisement/impression/store','FrontendController@home_advertisement_impression_store')->name('frontend.home.advertisement.impression.store');



    /*----------------------------------------
      FRONTEND: CUSTOM FORM BUILDER ROUTES
    -----------------------------------------*/
    Route::post('submit-custom-form', 'FrontendFormController@custom_form_builder_message')->name('frontend.form.builder.custom.submit');

    Route::group(['namespace' => 'Frontend'], function () {
        Route::get('/locations', 'LocationController@index')->name('frontend.locations');
        Route::get('/locations/{slug}', 'LocationController@show')->name('frontend.locations.single');
    });

});

Route::get('/brand/{slug}', 'FrontendController@get_single_brands')->middleware(['setlang:frontend', 'globalVariable', 'maintains_mode'])->name('frontend.brand.single');

/*==============================================
    FRONTEND ROUTES: PRODUCT MODULE
==============================================*/

Route::group(['middleware' => ['setlang:frontend', 'globalVariable', 'maintains_mode','moduleCheck:product_module_status']], function () {

    $product_page_slug = !empty(get_static_option('product_page_slug')) ? get_static_option('product_page_slug') : 'product';
    //product
    Route::get($product_page_slug , 'FrontendController@products')->name('frontend.products');
    Route::get( $product_page_slug.'/{slug}', 'FrontendController@product_single')->name('frontend.products.single');
    Route::get( $product_page_slug.'-category/{id}/{any?}', 'FrontendController@products_category')->name('frontend.products.category');
    Route::get( $product_page_slug.'-subcategory/{id}/{any?}', 'FrontendController@products_subcategory')->name('frontend.products.subcategory');

    Route::post( $product_page_slug.'-item/ajax/add-to-cart', 'ProductCartController@ajax_add_to_cart')->name('frontend.products.add.to.cart.ajax');
    Route::post( $product_page_slug.'-item/ajax/add-to-wishlist', 'ProductCartController@ajax_add_to_wishlist')->name('frontend.products.add.to.wishlist.ajax');
    Route::post( $product_page_slug.'-item/ajax/coupon', 'ProductCartController@ajax_coupon_code')->name('frontend.products.coupon.code');
    Route::post( $product_page_slug.'-item/ajax/shipping', 'ProductCartController@ajax_shipping_apply')->name('frontend.products.shipping.apply');
    Route::post( $product_page_slug.'-item/ajax/cart-update', 'ProductCartController@ajax_cart_update')->name('frontend.products.ajax.cart.update');
    Route::get( $product_page_slug.'-checkout', 'FrontendController@product_checkout')->name('frontend.products.checkout');

});

/*==============================================
    FRONTEND ROUTES: JOB MODULE
==============================================*/
Route::group(['middleware' => ['setlang:frontend', 'globalVariable', 'maintains_mode', 'moduleCheck:job_module_status']], function () {
    $career_with_us_page_slug = !empty(get_static_option('career_with_us_page_slug')) ? get_static_option('career_with_us_page_slug') : 'jobs';
    Route::get($career_with_us_page_slug, 'FrontendController@jobs')->name('frontend.jobs');
    Route::get( $career_with_us_page_slug.'/{slug}', 'FrontendController@jobs_single')->name('frontend.jobs.single');
    Route::get( $career_with_us_page_slug.'-category/{id}/{any}', 'FrontendController@jobs_category')->name('frontend.jobs.category');
    Route::get($career_with_us_page_slug.'-search', 'FrontendController@jobs_search')->name('frontend.jobs.search');

    Route::get('/apply/{id}', 'FrontendController@jobs_apply')->name('frontend.jobs.apply');

});

Route::group(['middleware' => ['setlang:frontend', 'globalVariable', 'maintains_mode', 'HtmlMinifier']], function () {

    Route::get('/', 'FrontendController@index')->name('homepage');

    Route::post('/get-touch', 'FrontendFormController@get_touch')->name('frontend.get.touch');
    Route::post('/appointment-message', 'FrontendFormController@appointment_message')->name('frontend.appointment.message');
    Route::post('/service-quote', 'FrontendFormController@service_quote')->name('frontend.service.quote');
    Route::post('/case-study-quote', 'FrontendFormController@case_study_quote')->name('frontend.case.study.quote');
    /*-----------------------------
        SUBSCRIBER VERIFY
    -----------------------------*/
    Route::get('/subscriber/email-verify/{token}','FrontendController@subscriber_verify')->name('subscriber.verify');


    //static page
    $about_page_slug = get_static_option('about_page_slug') ?? 'about';
    $work_page_slug = get_static_option('work_page_slug') ?? 'work';
    $faq_page_slug = get_static_option('faq_page_slug') ?? 'faq';
    $team_page_slug = get_static_option('team_page_slug') ?? 'team';
    $contact_page_slug = get_static_option('contact_page_slug') ?? 'contact';
    $blog_page_slug = get_static_option('blog_page_slug') ?? 'news';
    $testimonial_page_slug = get_static_option('testimonial_page_slug') ?? 'testimonials';
    $image_gallery_page_slug = get_static_option('image_gallery_page_slug') ?? 'image-gallery';
    $video_gallery_page_slug = get_static_option('video_gallery_page_slug') ?? 'video-gallery';

    /*--------------------------------------
        FRONTEND: SERVICES ROUTES
    ---------------------------------------*/
    $service_page_slug = get_static_option('service_page_slug') ?? 'service';
    Route::get($service_page_slug, 'FrontendController@service_page')->name('frontend.service');
    Route::get($service_page_slug.'/category/{id}/{any?}', 'FrontendController@category_wise_services_page')->name('frontend.services.category');
    Route::get( $service_page_slug.'/{slug}', 'FrontendController@services_single_page')->name('frontend.services.single');

    /*--------------------------------------
         FRONTEND: OTHERS ROUTES
     ---------------------------------------*/
    Route::get('/' . $about_page_slug, 'FrontendController@about_page')->name('frontend.about');
    Route::get('/' . $faq_page_slug, 'FrontendController@faq_page')->name('frontend.faq');
    Route::get('/' . $team_page_slug, 'FrontendController@team_page')->name('frontend.team');
    Route::get('/{committee}', 'FrontendController@team_page_committee')
        ->where('committee', 'board-of-director|executive-committee|audit-committee|risk-management-committee|senior-management')
        ->name('frontend.team.committee');
    Route::get('/' . $contact_page_slug, 'FrontendController@contact_page')->name('frontend.contact');
    /*--------------------------------------
         FRONTEND: CASE STUDY/ WORKS ROUTES
     ---------------------------------------*/
        Route::get($work_page_slug, 'FrontendController@work_page')->name('frontend.work');
        Route::get( $work_page_slug.'/{slug}', 'FrontendController@work_single_page')->name('frontend.work.single');
        Route::get( $work_page_slug.'/category/{id}/{any?}', 'FrontendController@category_wise_works_page')->name('frontend.works.category');

    /*--------------------------------------
        FRONTEND: BLOGS ROUTES
    ---------------------------------------*/
        Route::get($blog_page_slug, 'FrontendController@blog_page')->name('frontend.news');
        Route::get( $blog_page_slug.'/{slug}', 'FrontendController@blog_single_page')->name('frontend.news.single');
        Route::get( $blog_page_slug.'-search', 'FrontendController@blog_search_page')->name('frontend.news.search');
        Route::get( $blog_page_slug.'-category/{id}/{any}', 'FrontendController@category_wise_blog_page')->name('frontend.news.category');
        Route::get( $blog_page_slug.'-tags/{name}', 'FrontendController@tags_wise_blog_page')->name('frontend.news.tags.page');

    /*--------------------------------------
        FRONTEND: BANK DOWNLOADS ROUTES
    ---------------------------------------*/
    Route::group(['namespace' => 'Frontend'], function () {
        $downloads_page_slug = get_static_option('bank_downloads_page_slug') ?? 'bank-downloads';
        Route::get($downloads_page_slug, 'BankDownloadController@page')->name('frontend.bank.downloads');
        Route::get($downloads_page_slug . '/{slug}', 'BankDownloadController@single')->name('frontend.bank.downloads.single');
        Route::get($downloads_page_slug . '-category/{id}/{slug?}', 'BankDownloadController@category')->name('frontend.bank.downloads.category');
        Route::get($downloads_page_slug . '-subcategory/{id}/{slug?}', 'BankDownloadController@subcategory')->name('frontend.bank.downloads.subcategory');
        Route::get($downloads_page_slug . '-search', 'BankDownloadController@search')->name('frontend.bank.downloads.search');
    });

    /*------------------------------------
        FRONTEND: AUCTION ROUTES
    ------------------------------------*/
    Route::group(['namespace' => 'Frontend'], function () {
        $auction_page_slug = get_static_option('auction_page_slug') ?? 'auction';
        Route::get($auction_page_slug, 'AuctionController@page')->name('frontend.auction');
        Route::get($auction_page_slug . '/{slug}', 'AuctionController@single')->name('frontend.auction.single');
    });

    /*------------------------------------
        FRONTEND: USEFUL LINKS ROUTES
    ------------------------------------*/
    Route::group(['namespace' => 'Frontend'], function () {
        $useful_links_slug = get_static_option('useful_links_page_slug') ?? 'useful-links';
        Route::get($useful_links_slug, 'UsefulLinkController@page')->name('frontend.useful.links');
    });

    /*------------------------------------
        FRONTEND: TENDER ROUTES
    ------------------------------------*/
    Route::group(['namespace' => 'Frontend'], function () {
        $tender_page_slug = get_static_option('tender_page_slug') ?? 'tender';
        Route::get($tender_page_slug, 'TenderController@page')->name('frontend.tender');
        Route::get($tender_page_slug . '/{slug}', 'TenderController@single')->name('frontend.tender.single');
    });

    /*------------------------------------
        FRONTEND: NOTICE ROUTES
    ------------------------------------*/
    Route::group(['namespace' => 'Frontend'], function () {
        $notice_page_slug = get_static_option('notice_page_slug') ?? 'notice';
        Route::get($notice_page_slug, 'NoticeController@page')->name('frontend.notice');
        Route::get($notice_page_slug . '/{slug}', 'NoticeController@single')->name('frontend.notice.single');
    });

    /*------------------------------------
        FRONTEND: ROUTES
    ------------------------------------*/
    Route::get('/' . $testimonial_page_slug, 'FrontendController@testimonials')->name('frontend.testimonials');
    $complain_page_slug = get_static_option('complain_page_slug') ?? 'complain';
    Route::get('/' . $complain_page_slug, 'FrontendController@complain_page')->name('frontend.complain');
    Route::get('/' . $complain_page_slug . '/branches/{division}', 'FrontendController@get_branches_by_division')->name('frontend.complain.branches');
    Route::get('/' . $complain_page_slug . '/send-complaint', 'FrontendController@send_complaint_page')->name('frontend.complain.send');
    Route::get('/' . $image_gallery_page_slug . '', 'FrontendController@image_gallery_page')->name('frontend.image.gallery');
    Route::get('/' . $video_gallery_page_slug . '', 'FrontendController@video_gallery_page')->name('frontend.video.gallery');

    
    /*------------------------------------
    IMAGE GALLERY ROUTES
------------------------------------*/


    Route::get('/' . $image_gallery_page_slug . '/filter', 'FrontendController@image_gallery_filter')
        ->name('frontend.image.gallery.filter');

    Route::post('/contact-submit', 'FrontendController@contact_form_submit')->name('contact-submit');
    Route::get('/deposit-calculator', 'FrontendController@loan_calculator')->name('deposit.calculator');
    Route::get('/emi-calculator', 'FrontendController@emi_calculator')->name('emi.calculator');
    Route::get('/exrate', 'FrontendController@exrate')->name('frontend.exrate');
    Route::get('/achievement', 'FrontendController@achievement_page')->name('frontend.achievement');

});


/*----------------------------------
    USER DASHBOARD
-----------------------------------*/
// Route::prefix('user-home')->middleware(['userEmailVerify', 'setlang:frontend', 'globalVariable', 'maintains_mode'])->group(function () {
//     Route::get('/', 'UserDashboardController@user_index')->name('user.home');
//     Route::get('/download/file/{id}', 'UserDashboardController@download_file')->name('user.dashboard.download.file');
//     Route::get('/package-orders', 'UserDashboardController@package_orders')->name('user.home.package.order');
//     Route::get('/product-orders', 'UserDashboardController@product_orders')->name('user.home.product.order');
//     Route::get('/product-download', 'UserDashboardController@product_downloads')->name('user.home.product.download');
//     Route::get('/events-booking', 'UserDashboardController@event_booking')->name('user.home.event.booking');
//     Route::get('/donations', 'UserDashboardController@donations')->name('user.home.donations');
//     Route::get('/appointment-booking', 'UserDashboardController@appointment_booking')->name('user.home.appointment.booking');
//     Route::get('/course-enroll', 'UserDashboardController@course_enroll')->name('user.home.course.enroll');
//     Route::get('/support-tickets', 'UserDashboardController@support_tickets')->name('user.home.support.tickets');

//     Route::get('/change-password', 'UserDashboardController@change_password')->name('user.home.change.password');
//     Route::get('/edit-profile', 'UserDashboardController@edit_profile')->name('user.home.edit.profile');
//     Route::post('/profile-update', 'UserDashboardController@user_profile_update')->name('user.profile.update');
//     Route::post('/password-change', 'UserDashboardController@user_password_change')->name('user.password.change');
//     Route::post('/package-order/cancel', 'UserDashboardController@package_order_cancel')->name('user.dashboard.package.order.cancel');
//     Route::post('/product-order/cancel', 'UserDashboardController@product_order_cancel')->name('user.dashboard.product.order.cancel');
//     Route::post('/event-order/cancel', 'UserDashboardController@event_order_cancel')->name('user.dashboard.event.order.cancel');
//     Route::post('/donation-order/cancel', 'UserDashboardController@donation_order_cancel')->name('user.dashboard.donation.order.cancel');
//     Route::post('/appointment-order/cancel', 'UserDashboardController@appointment_order_cancel')->name('user.dashboard.appointment.order.cancel');
//     Route::post('/course-order/cancel', 'UserDashboardController@course_order_cancel')->name('user.dashboard.course.order.cancel');
//     Route::get('/product-order/view/{id}', 'UserDashboardController@product_order_view')->name('user.dashboard.product.order.view');

//     Route::post('/course-certificate', 'UserDashboardController@course_certificate')->name('user.dashboard.course.certificate');
//     Route::get('/course-certificate/download/{id}', 'UserDashboardController@course_certificate_download')->name('user.dashboard.course.certificate.download');
//     Route::get('support-ticket/view/{id}', 'UserDashboardController@support_ticket_view')->name('user.dashboard.support.ticket.view');
//     Route::post('support-ticket/priority-change', 'UserDashboardController@support_ticket_priority_change')->name('user.dashboard.support.ticket.priority.change');
//     Route::post('support-ticket/status-change', 'UserDashboardController@support_ticket_status_change')->name('user.dashboard.support.ticket.status.change');
//     Route::post('support-ticket/message', 'UserDashboardController@support_ticket_message')->name('user.dashboard.support.ticket.message');

//     /* EVENT TICKET QR CODE GENERATOR */
//     Route::post('/event-user/generate-ticket', 'UserDashboardController@generate_event_ticket')->name('user.dashboard.event.ticket.generate');
// });



/*------------------------------------
  ADMIN LOGIN ROUTE
-------------------------------------*/
Route::group(['middleware' => ['setlang:frontend', 'globalVariable', 'HtmlMinifier']], function () {

    Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('admin.login');
    Route::get('/login/admin/forget-password', 'FrontendController@showAdminForgetPasswordForm')->name('admin.forget.password');
    Route::get('/login/admin/reset-password/{user}/{token}', 'FrontendController@showAdminResetPasswordForm')->name('admin.reset.password');
    Route::post('/login/admin/reset-password', 'FrontendController@AdminResetPassword')->name('admin.reset.password.change');
    Route::post('/login/admin/forget-password', 'FrontendController@sendAdminForgetPasswordMail');
    Route::post('/logout/admin', 'AdminDashboardController@adminLogout')->name('admin.logout');
    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
    Route::get('/lang', 'FrontendController@lang_change')->name('frontend.langchange');
    Route::post('/subscribe-newsletter', 'FrontendController@subscribe_newsletter')->name('frontend.subscribe.newsletter');
    Route::post('/contact-message', 'FrontendFormController@send_contact_message')->name('frontend.contact.message');
    Route::post('/complain-submit', 'FrontendFormController@complain_submit')->name('frontend.complain.submit');
    Route::post('/place-order', 'FrontendFormController@send_order_message')->name('frontend.order.message');
});


require_once __DIR__.'/admin.php';

/*------------------------------------
    DYNAMIC PAGE ROUTE
-------------------------------------*/
Route::group(['middleware' => ['setlang:frontend', 'globalVariable', 'HtmlMinifier','maintains_mode']], function () {
    Route::get('/{slug}', 'FrontendController@dynamic_single_page')->name('frontend.dynamic.page');
});
