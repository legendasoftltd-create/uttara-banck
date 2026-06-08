<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('concerned_division')->nullable();
            $table->string('concerned_branch')->nullable();
            $table->string('full_name');
            $table->string('address')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->boolean('has_account')->default(false);
            $table->string('nature_of_complain')->nullable();
            $table->string('amount_involved')->nullable();
            $table->text('details');
            $table->text('suggestion')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}
