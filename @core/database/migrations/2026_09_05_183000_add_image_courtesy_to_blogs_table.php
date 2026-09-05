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
        if (Schema::hasTable('blogs') && !Schema::hasColumn('blogs', 'image_courtesy')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('image_courtesy')->nullable()->after('image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('blogs') && Schema::hasColumn('blogs', 'image_courtesy')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('image_courtesy');
            });
        }
    }
};
