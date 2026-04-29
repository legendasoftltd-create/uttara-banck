<?php

namespace App\Http\Controllers\Frontend;

use App\BankDownload;
use App\BankDownloadCategory;
use App\BankDownloadSubcategory;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankDownloadController extends Controller
{
    const BASE_PATH = 'frontend.pages.bank-download.';

    public function page()
    {
        $lang = $lang = LanguageHelper::user_lang_slug();
        
        $all_categories = BankDownloadCategory::where(['status' => 'publish', 'lang' => $lang])
            ->with(['subcategories' => function ($q) use ($lang) {
                $q->where(['status' => 'publish', 'lang' => $lang]);
            }])
            ->get();
        
        $all_downloads = BankDownload::where(['status' => 'publish', 'lang' => $lang])
            ->orderBy('publish_date', 'desc')
            ->with(['category', 'subcategory'])
            ->paginate(12);
        
        return view(self::BASE_PATH . 'index')->with([
            'all_downloads' => $all_downloads,
            'all_categories' => $all_categories,
            'page_title' => get_static_option('bank_downloads_page_title') ?? 'Bank Downloads'
        ]);
    }

    public function single($slug)
    {
        $lang = LanguageHelper::user_lang_slug();
        $download = BankDownload::where(['slug' => $slug, 'status' => 'publish', 'lang' => $lang])
            ->with(['category', 'subcategory'])
            ->firstOrFail();
        
        // Related downloads from same category
        $related_downloads = BankDownload::where(['category_id' => $download->category_id, 'status' => 'publish', 'lang' => $lang])
            ->where('id', '!=', $download->id)
            ->limit(6)
            ->get();
        
        return view(self::BASE_PATH . 'single')->with([
            'download' => $download,
            'related_downloads' => $related_downloads
        ]);
    }

    public function category($category_id, $slug = null)
    {
        $lang = LanguageHelper::user_lang_slug();
        
        $category = BankDownloadCategory::where(['id' => $category_id, 'status' => 'publish', 'lang' => $lang])
            ->with(['subcategories' => function ($query) use ($lang) {
                $query->where(['status' => 'publish', 'lang' => $lang])
                    ->with(['downloads' => function ($downloadQuery) use ($lang) {
                        $downloadQuery->where(['status' => 'publish', 'lang' => $lang])
                            ->orderBy('publish_date', 'desc');
                    }]);
            }])
            ->firstOrFail();
        
        $all_categories = BankDownloadCategory::where(['status' => 'publish', 'lang' => $lang])
            ->with(['subcategories' => function ($q) use ($lang) {
                $q->where(['status' => 'publish', 'lang' => $lang]);
            }])
            ->get();
        
        $all_downloads = BankDownload::where([
                'category_id' => $category_id,
                'status' => 'publish',
                'lang' => $lang,
            ])
            ->whereNull('subcategory_id')
            ->orderBy('publish_date', 'desc')
            ->with(['category', 'subcategory'])
            ->get();

        $subcategory_sections = $category->subcategories
            ->filter(function ($subcategory) {
                return $subcategory->downloads->count() > 0;
            })
            ->values();
        
        return view(self::BASE_PATH . 'index')->with([
            'all_downloads' => $all_downloads,
            'all_categories' => $all_categories,
            'current_category' => $category,
            'subcategory_sections' => $subcategory_sections,
            'page_title' => $category->title
        ]);
    }

    public function subcategory($subcategory_id, $slug = null)
    {
        $lang = LanguageHelper::user_lang_slug();
        
        $subcategory = BankDownloadSubcategory::where(['id' => $subcategory_id, 'status' => 'publish', 'lang' => $lang])->firstOrFail();
        
        $all_categories = BankDownloadCategory::where(['status' => 'publish', 'lang' => $lang])
            ->with(['subcategories' => function ($q) use ($lang) {
                $q->where(['status' => 'publish', 'lang' => $lang]);
            }])
            ->get();
        
        $all_downloads = BankDownload::where(['subcategory_id' => $subcategory_id, 'status' => 'publish', 'lang' => $lang])
            ->orderBy('publish_date', 'desc')
            ->with(['category', 'subcategory'])
            ->paginate(12);
        
        return view(self::BASE_PATH . 'index')->with([
            'all_downloads' => $all_downloads,
            'all_categories' => $all_categories,
            'current_subcategory' => $subcategory,
            'page_title' => $subcategory->title
        ]);
    }

    public function search(Request $request)
    {
        $lang = LanguageHelper::user_lang_slug();
        $search_term = $request->get('q', '');
        
        $all_categories = BankDownloadCategory::where(['status' => 'publish', 'lang' => $lang])
            ->with(['subcategories' => function ($q) use ($lang) {
                $q->where(['status' => 'publish', 'lang' => $lang]);
            }])
            ->get();
        
        $all_downloads = BankDownload::where(['status' => 'publish', 'lang' => $lang])
            ->where(function ($q) use ($search_term) {
                $q->where('title', 'like', '%' . $search_term . '%')
                  ->orWhere('description', 'like', '%' . $search_term . '%');
            })
            ->orderBy('publish_date', 'desc')
            ->with(['category', 'subcategory'])
            ->paginate(12);
        
        return view(self::BASE_PATH . 'index')->with([
            'all_downloads' => $all_downloads,
            'all_categories' => $all_categories,
            'search_term' => $search_term,
            'page_title' => 'Search Results'
        ]);
    }
}
