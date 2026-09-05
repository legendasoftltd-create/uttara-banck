<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageCourtesyToImageGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('image_galleries', 'image_courtesy')) {
            Schema::table('image_galleries', function (Blueprint $table) {
                $table->string('image_courtesy')->nullable()->after('image');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('image_galleries', 'image_courtesy')) {
            Schema::table('image_galleries', function (Blueprint $table) {
                $table->dropColumn('image_courtesy');
            });
        }
    }
}
