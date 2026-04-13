<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddSlugToBrandsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('brands', 'slug')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
        }

        $brands = DB::table('brands')->select('id', 'title', 'slug')->orderBy('id')->get();
        $usedSlugs = [];

        foreach ($brands as $brand) {
            $baseSlug = Str::slug($brand->slug ?: $brand->title);
            $baseSlug = !empty($baseSlug) ? $baseSlug : 'brand';
            $slug = $baseSlug;
            $counter = 1;

            while (in_array($slug, $usedSlugs, true)) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table('brands')->where('id', $brand->id)->update([
                'slug' => $slug,
            ]);

            $usedSlugs[] = $slug;
        }

        Schema::table('brands', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down()
    {
        if (!Schema::hasColumn('brands', 'slug')) {
            return;
        }

        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
}
