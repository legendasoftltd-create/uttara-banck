<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintCellMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_cell_members', function (Blueprint $table) {
            $table->id();
            $table->enum('section', ['central', 'zonal']);
            $table->string('zone_name')->nullable();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('position')->nullable();
            $table->text('contact')->nullable();
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('complaint_cell_members');
    }
}
