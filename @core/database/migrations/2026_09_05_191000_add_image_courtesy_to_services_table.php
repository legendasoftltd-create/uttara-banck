<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageCourtesyToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('services', 'image_courtesy')) {
            Schema::table('services', function (Blueprint $table) {
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
        if (Schema::hasColumn('services', 'image_courtesy')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('image_courtesy');
            });
        }
    }
}
