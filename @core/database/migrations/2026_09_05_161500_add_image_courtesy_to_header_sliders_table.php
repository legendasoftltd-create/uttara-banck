<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('header_sliders') && !Schema::hasColumn('header_sliders', 'image_courtesy')) {
            Schema::table('header_sliders', function (Blueprint $table) {
                $table->string('image_courtesy')->nullable()->after('image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('header_sliders') && Schema::hasColumn('header_sliders', 'image_courtesy')) {
            Schema::table('header_sliders', function (Blueprint $table) {
                $table->dropColumn('image_courtesy');
            });
        }
    }
};
