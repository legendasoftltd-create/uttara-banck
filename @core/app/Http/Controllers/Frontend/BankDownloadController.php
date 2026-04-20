<?php

namespace App\Http\Controllers\Frontend;

use App\BankDownload;
use App\BankDownloadCategory;
use App\BankDownloadSubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankDownloadController extends Controller
{
    const BASE_PATH = 'frontend.pages.bank-download.';

    public function page()
    {
        $lang = get_current_language()->slug;
        
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
        $lang = get_current_language()->slug;
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
        $lang = get_current_language()->slug;
        
        $category = BankDownloadCategory::where(['id' => $category_id, 'status' => 'publish', 'lang' => $lang])->firstOrFail();
        
        $all_categories = BankDownloadCategory::where(['status' => 'publish', 'lang' => $lang])
            ->with(['subcategories' => function ($q) use ($lang) {
                $q->where(['status' => 'publish', 'lang' => $lang]);
            }])
            ->get();
        
        $all_downloads = BankDownload::where(['category_id' => $category_id, 'status' => 'publish', 'lang' => $lang])
            ->orderBy('publish_date', 'desc')
            ->with(['category', 'subcategory'])
            ->paginate(12);
        
        return view(self::BASE_PATH . 'index')->with([
            'all_downloads' => $all_downloads,
            'all_categories' => $all_categories,
            'current_category' => $category,
            'page_title' => $category->title
        ]);
    }

    public function subcategory($subcategory_id, $slug = null)
    {
        $lang = get_current_language()->slug;
        
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
        $lang = get_current_language()->slug;
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
