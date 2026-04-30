<?php

namespace App\Http\Controllers;

use App\Actions\SlugChecker;
use App\BankDownload;
use App\BankDownloadCategory;
use App\BankDownloadSubcategory;
use App\Language;
use App\Helpers\SanitizeInput;
use App\Http\Requests\SlugCheckRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BankDownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display all downloads
     */
    public function index()
    {
        $all_downloads = BankDownload::all()->groupBy('lang');
        return view('backend.pages.bank-download.index')->with([
            'all_downloads' => $all_downloads
        ]);
    }

    /**
     * Show create form
     */
    public function new_download()
    {
        $all_categories = BankDownloadCategory::where('lang', get_default_language())->get();
        $all_subcategories = BankDownloadSubcategory::where('lang', get_default_language())->get();
        $all_languages = Language::all();

        return view('backend.pages.bank-download.new')->with([
            'all_categories' => $all_categories,
            'all_subcategories' => $all_subcategories,
            'all_languages' => $all_languages,
        ]);
    }

    /**
     * Store new download
     */
    public function store_new_download(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'status' => 'required',
            'lang' => 'required',
            'file' => 'nullable|file|max:102400',
        ]);

        // Validate file extension
        $file_data = [];
        if ($request->hasFile('file')) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'txt', 'csv'];
            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowed_extensions)) {
                return redirect()->back()->withErrors([
                    'file' => 'File type .' . $extension . ' is not allowed. Allowed types: ' . implode(', ', $allowed_extensions)
                ])->withInput();
            }

            // Get file info before moving
            $original_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $mime_type = $file->getMimeType();

            $upload_dir = 'assets/uploads/bank-downloads';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move($upload_dir, $filename);
            
            $file_data = [
                'name' => $filename,
                'original_name' => $original_name,
                'size' => $file_size,
                'mime' => $mime_type,
            ];
        }

        $slug = Str::slug($request->title);
        // Check if slug already exists for this language
        $slug_exists = BankDownload::where('slug', $slug)->where('lang', $request->lang)->exists();
        if ($slug_exists) {
            $slug = $slug . '-' . time();
        }

        BankDownload::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'files' => json_encode($file_data ? [$file_data] : []),
            'publish_date' => $request->publish_date,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->route('admin.bank.download')->with('success', 'Download created successfully');
    }

    /**
     * Edit download
     */
    public function edit_download($id)
    {
        $download = BankDownload::find($id);
        if (!$download) {
            abort(404);
        }

        $all_categories = BankDownloadCategory::where('lang', $download->lang)->get();
        $all_subcategories = BankDownloadSubcategory::where('lang', $download->lang)->get();
        $all_languages = Language::all();

        return view('backend.pages.bank-download.edit')->with([
            'download' => $download,
            'all_categories' => $all_categories,
            'all_subcategories' => $all_subcategories,
            'all_languages' => $all_languages,
        ]);
    }

    /**
     * Update download
     */
    public function update_download(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'status' => 'required',
            'file' => 'nullable|file|max:102400',
        ]);

        $download = BankDownload::find($id);
        if (!$download) {
            abort(404);
        }

        $files = json_decode($download->files, true) ?? [];

        // Validate file extension
        if ($request->hasFile('file')) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'txt', 'csv'];
            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowed_extensions)) {
                return redirect()->back()->withErrors([
                    'file' => 'File type .' . $extension . ' is not allowed. Allowed types: ' . implode(', ', $allowed_extensions)
                ])->withInput();
            }

            // Get file info before moving
            $original_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $mime_type = $file->getMimeType();

            // Delete old file if exists
            if (count($files) > 0 && file_exists('assets/uploads/bank-downloads/' . $files[0]['name'])) {
                unlink('assets/uploads/bank-downloads/' . $files[0]['name']);
            }

            $upload_dir = 'assets/uploads/bank-downloads';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move($upload_dir, $filename);
            
            $files = [[
                'name' => $filename,
                'original_name' => $original_name,
                'size' => $file_size,
                'mime' => $mime_type,
            ]];
        }

        $download->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'files' => json_encode($files),
            'publish_date' => $request->publish_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.bank.download')->with('success', 'Download updated successfully');
    }

    /**
     * Delete download
     */
    public function delete_download($id)
    {
        $download = BankDownload::find($id);
        if (!$download) {
            abort(404);
        }

        // Delete files from storage
        $files = json_decode($download->files, true) ?? [];
        foreach ($files as $file) {
            if (file_exists('assets/uploads/bank-downloads/' . $file['name'])) {
                unlink('assets/uploads/bank-downloads/' . $file['name']);
            }
        }

        $download->delete();
        return redirect()->route('admin.bank.download')->with('success', 'Download deleted successfully');
    }

    /**
     * Bulk action
     */
    public function bulk_action(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if ($action == 'delete') {
            foreach ($ids as $id) {
                $this->delete_download($id);
            }
            return redirect()->route('admin.bank.download')->with('success', 'Downloads deleted successfully');
        }

        if ($action == 'change-status') {
            BankDownload::whereIn('id', $ids)->update(['status' => $request->status]);
            return redirect()->route('admin.bank.download')->with('success', 'Status updated successfully');
        }
    }

    /**
     * Slug check
     */
    public function slug_check(SlugCheckRequest $request)
    {
        $slug = Str::slug($request->slug);
        $slug_check = SlugChecker::check($slug);
        return response()->json(['status' => $slug_check]);
    }

    /**
     * Delete file from download
     */
    public function delete_file(Request $request)
    {
        $download = BankDownload::find($request->download_id);
        if (!$download) {
            return response()->json(['status' => false, 'message' => 'Download not found']);
        }

        $files = json_decode($download->files, true) ?? [];
        $file_to_delete = $request->file_name;

        foreach ($files as $key => $file) {
            if ($file['name'] === $file_to_delete) {
                if (file_exists('assets/uploads/bank-downloads/' . $file['name'])) {
                    unlink('assets/uploads/bank-downloads/' . $file['name']);
                }
                unset($files[$key]);
                break;
            }
        }

        $download->update(['files' => json_encode(array_values($files))]);
        return response()->json(['status' => true, 'message' => 'File deleted successfully']);
    }

    /**
     * Category management
     */
    public function category()
    {
        $all_categories = BankDownloadCategory::all()->groupBy('lang');
        return view('backend.pages.bank-download.category')->with([
            'all_categories' => $all_categories
        ]);
    }

    /**
     * Create new category
     */
    public function new_category(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'lang' => 'required',
            'status' => 'required',
        ]);

        $slug = Str::slug($request->title);
        // Check if slug already exists for this language
        $slug_exists = BankDownloadCategory::where('slug', $slug)->where('lang', $request->lang)->exists();
        if ($slug_exists) {
            $slug = $slug . '-' . time();
        }

        BankDownloadCategory::create([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with('success', 'Category created successfully');
    }

    /**
     * Update category
     */
    public function update_category(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'id' => 'required|integer',
        ]);

        $category = BankDownloadCategory::find($request->id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $category->update([
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    /**
     * Delete category
     */
    public function delete_category($id)
    {
        $category = BankDownloadCategory::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    /**
     * Category bulk action
     */
    public function category_bulk_action(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if ($action == 'delete') {
            BankDownloadCategory::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Categories deleted successfully');
        }

        if ($action == 'change-status') {
            BankDownloadCategory::whereIn('id', $ids)->update(['status' => $request->status]);
            return redirect()->back()->with('success', 'Status updated successfully');
        }
    }

    /**
     * Subcategory management
     */
    public function subcategory()
    {
        $all_subcategories = BankDownloadSubcategory::all()->groupBy('lang');
        return view('backend.pages.bank-download.subcategory')->with([
            'all_subcategories' => $all_subcategories
        ]);
    }

    /**
     * Create new subcategory
     */
    public function new_subcategory(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'category_id' => 'required|integer',
            'lang' => 'required',
            'status' => 'required',
        ]);

        $slug = Str::slug($request->title);
        // Check if slug already exists for this language
        $slug_exists = BankDownloadSubcategory::where('slug', $slug)->where('lang', $request->lang)->exists();
        if ($slug_exists) {
            $slug = $slug . '-' . time();
        }

        BankDownloadSubcategory::create([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with('success', 'Subcategory created successfully');
    }

    /**
     * Update subcategory
     */
    public function update_subcategory(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'id' => 'required|integer',
        ]);

        $subcategory = BankDownloadSubcategory::find($request->id);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found');
        }

        $subcategory->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Subcategory updated successfully');
    }

    /**
     * Delete subcategory
     */
    public function delete_subcategory($id)
    {
        $subcategory = BankDownloadSubcategory::find($id);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found');
        }

        $subcategory->delete();
        return redirect()->back()->with('success', 'Subcategory deleted successfully');
    }

    /**
     * Subcategory bulk action
     */
    public function subcategory_bulk_action(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if ($action == 'delete') {
            BankDownloadSubcategory::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Subcategories deleted successfully');
        }

        if ($action == 'change-status') {
            BankDownloadSubcategory::whereIn('id', $ids)->update(['status' => $request->status]);
            return redirect()->back()->with('success', 'Status updated successfully');
        }
    }

    /**
     * Get subcategories by category ID
     */
    public function get_subcategories_by_category($category_id)
    {
        $subcategories = BankDownloadSubcategory::where('category_id', $category_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    }
}
