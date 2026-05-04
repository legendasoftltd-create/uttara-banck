<?php

namespace App\Http\Controllers;

use App\Actions\SlugChecker;
use App\Brand;
use App\Http\Requests\SlugCheckRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $all_brand = Brand::all();
        return view('backend.pages.brand')->with(['all_brand' => $all_brand]);
    }

    public function store(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191',
            'image' => 'nullable|string|max:191',
            'url' => 'nullable|string|max:191',
        ]);

        Brand::create([
            'title' => $request->title,
            'slug' => $this->prepareSlug($request->slug, $request->title),
            'image' => $request->image,
            'url' => $request->url,
        ]);

        return redirect()->back()->with(['msg' => __('New Brand Added...'),'type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'id' => 'required|integer|exists:brands,id',
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191',
            'image' => 'nullable|string|max:191',
            'url' => 'nullable|string|max:191',
        ]);

        Brand::find($request->id)->update([
            'title' => $request->title,
            'slug' => $this->prepareSlug($request->slug, $request->title, $request->id),
            'image' => $request->image,
            'url' => $request->url,
        ]);

        return redirect()->back()->with(['msg' => __('Brands Updated...'),'type' => 'success']);
    }

    public function delete($id){

        Brand::find($id)->delete();
        return redirect()->back()->with(['msg' =>__( 'Delete Success...'),'type' => 'danger']);
    }

    public function bulk_action(Request $request){
        Brand::whereIn('id',$request->ids)->delete();
        return response()->json(['status' => 'ok']);
    }

    public function slug_check(SlugCheckRequest $request){
        $query = Brand::where('slug', $request->slug);

        return SlugChecker::Check($request, $query);
    }

    private function prepareSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($slug ?: $title);
        $baseSlug = !empty($baseSlug) ? $baseSlug : 'brand';
        $currentSlug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($currentSlug, $ignoreId)) {
            $currentSlug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $currentSlug;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return Brand::when($ignoreId, function ($query) use ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        })->where('slug', $slug)->exists();
    }
}
