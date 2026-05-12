<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsefulLinksTable extends Migration
{
    public function up()
    {
        Schema::create('useful_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 500);
            $table->string('url', 500);
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status', 50)->default('publish');
            $table->string('lang', 50)->default('en');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('useful_links');
    }
}
