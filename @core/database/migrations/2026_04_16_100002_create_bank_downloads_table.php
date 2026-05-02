<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_downloads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->longText('files')->nullable(); // JSON format for storing multiple files
            $table->date('publish_date')->nullable();
            $table->string('status')->default('draft');
            $table->string('lang')->nullable();
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('bank_download_categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('bank_download_subcategories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_downloads');
    }
}
