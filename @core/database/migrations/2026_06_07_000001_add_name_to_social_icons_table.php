<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToSocialIconsTable extends Migration
{
    public function up()
    {
        Schema::table('social_icons', function (Blueprint $table) {
            $table->string('name')->nullable()->after('icon');
        });
    }

    public function down()
    {
        Schema::table('social_icons', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
