<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 500);
            $table->string('slug', 500)->unique();
            $table->longText('description')->nullable();
            $table->string('file', 500)->nullable();
            $table->date('notice_date');
            $table->date('expiry_date')->nullable();
            $table->string('status', 50)->default('draft');
            $table->string('lang', 50)->default('en');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tenders');
    }
}
