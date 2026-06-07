<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeExchangeRatesToBatchStructure extends Migration
{
    public function up()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn(['name', 'value', 'date']);
            $table->json('items')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn('items');
            $table->string('name', 191)->nullable();
            $table->decimal('value', 18, 8)->default(0);
            $table->date('date')->nullable();
        });
    }
}
