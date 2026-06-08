<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionAndThumbnailToBrandsTable extends Migration
{
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (!Schema::hasColumn('brands', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }

            if (Schema::hasColumn('brands', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
}
