<?php

namespace App\Http\Middleware;

use App\Services\AuditLogger;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminSettingsPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$param)
    {
        if (Auth::guard('admin')->check()) {
            $user_role = \App\AdminRole::where('id', auth()->guard('admin')->user()->role)->first();
            $all_permission = json_decode($user_role->permission);
            $permission = strtolower(str_replace(' ','_',$param));
            $permission_aliases = [
                'exchange_rate_manage' => 'exchange_rate',
            ];

            // Resolve granular permissions dynamically
            $module_mappings = [
                'pages_manage' => 'pages',
                'news_manage' => 'news',
                'services' => 'services',
                'important_information' => 'important_information',
                'gallery_page' => 'image_gallery',
                'video_gallery' => 'video_gallery',
                'our_achievement_manage' => 'achievement',
                'products_manage' => 'products',
                'job_post_manage' => 'jobs',
                'support_ticket_all' => 'support_ticket',
                'support_ticket_add_new' => 'support_ticket',
                'support_ticket_department' => 'support_ticket_department',
                'locations_manage' => 'locations',
                'bank_downloads' => 'downloads',
                'visitor_log_view' => 'visitor_log',
                'auction_manage' => 'auction',
                'notice_manage' => 'notice',
                'complaint_manage' => 'complaint',
                'exchange_rate_manage' => 'exchange_rate',
                'exchange_rate' => 'exchange_rate',
                'tender_manage' => 'tender',
                'useful_links_manage' => 'useful_links',
                'general_settings' => 'general_settings',
                'topbar_settings' => 'topbar_settings',
                'popup_builder' => 'popup_builder',
                'home_page_manage' => 'home_page_manage',
                '404_page_manage' => '404_page_manage',
                'faq' => 'faq',
                'media_manage' => 'media_manage',
            ];

            if (isset($module_mappings[$permission])) {
                $module = $module_mappings[$permission];
                $action = 'view';
                
                $path = strtolower($request->getPathInfo());
                if (strpos($path, 'footer-settings') !== false) {
                    $module = 'footer_settings';
                } elseif (strpos($path, 'site-identity') !== false) {
                    $module = 'site_identity';
                } elseif (strpos($path, 'scripts') !== false) {
                    $module = 'third_party_scripts';
                } elseif (strpos($path, 'smtp-settings') !== false) {
                    $module = 'smtp_settings';
                } elseif (strpos($path, 'cache-settings') !== false) {
                    $module = 'cache_settings';
                } elseif (strpos($path, 'gdpr-settings') !== false) {
                    $module = 'gdpr_settings';
                } elseif (strpos($path, 'sitemap-settings') !== false) {
                    $module = 'sitemap_settings';
                } elseif (strpos($path, 'rss-settings') !== false) {
                    $module = 'rss_settings';
                }
                if (in_array($module, ['services', 'important_information', 'image_gallery', 'products', 'jobs', 'downloads']) && (strpos($path, 'category') !== false || strpos($path, 'subcategory') !== false)) {
                    if ($request->isMethod('delete') || strpos($path, 'delete') !== false || strpos($path, 'bulk-action') !== false) {
                        $action = 'category_delete';
                    } elseif (!$request->isMethod('get') && !$request->isMethod('head')) {
                        if (strpos($path, 'update') !== false) {
                            $action = 'category_edit';
                        } else {
                            $action = 'category_create';
                        }
                    } else {
                        $action = 'category_view';
                    }
                } elseif (strpos($path, 'page-settings') !== false) {
                    $action = 'settings';
                } elseif ($request->isMethod('delete') || strpos($path, 'delete') !== false || strpos($path, 'bulk-action') !== false || strpos($path, 'clear-all') !== false) {
                    $action = 'delete';
                } elseif (!$request->isMethod('get') && !$request->isMethod('head')) {
                    if ($module === 'achievement' || $module === 'services' || $module === 'important_information' || $module === 'image_gallery' || $module === 'video_gallery' || $module === 'products' || $module === 'jobs' || $module === 'support_ticket' || $module === 'support_ticket_department' || $module === 'locations' || $module === 'downloads' || $module === 'auction' || $module === 'notice' || $module === 'complaint' || $module === 'exchange_rate' || $module === 'tender' || $module === 'useful_links' || $module === 'popup_builder' || $module === 'faq') {
                        if (strpos($path, 'update') !== false) {
                            $action = 'edit';
                        } else {
                            $action = 'create';
                        }
                    } else {
                        $action = 'edit';
                    }
                }

                if ($action === 'delete' && in_array($module, ['general_settings', 'appearance_settings'])) {
                    $action = 'edit';
                }

                $required_permission = $module . '_' . $action;

                if ($required_permission === 'visitor_log_edit') {
                    $required_permission = 'visitor_log_delete';
                }

                if ($required_permission === 'media_manage_edit' || $required_permission === 'media_manage_delete' || $required_permission === 'media_manage_create') {
                    $required_permission = 'media_manage_view';
                }



                if (in_array($required_permission, $all_permission)) {
                    return $next($request);
                }
            }

            if (in_array($permission, $all_permission) || (isset($permission_aliases[$permission]) && in_array($permission_aliases[$permission], $all_permission))) {
                return $next($request);
            }
        }

        // checklist 3.b — record access attempts to permission-restricted areas
        AuditLogger::log('access.denied', [
            'level' => 'warning',
            'meta' => ['required_permission' => $param],
            'description' => 'Denied access to a restricted area requiring "' . $param . '" permission',
        ]);

        return redirect()->route('admin.home');
    }
}
