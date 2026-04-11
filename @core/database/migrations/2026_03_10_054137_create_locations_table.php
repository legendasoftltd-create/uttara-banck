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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->enum('branch_point', ['Branches', 'AD Branches']);
            $table->string('name', 255);
            $table->enum('type', ['branch','atm','agent']);
            $table->string('address');
            $table->string('district')->nullable();
            $table->string('division')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->longtext('map')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('opening_hours')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
