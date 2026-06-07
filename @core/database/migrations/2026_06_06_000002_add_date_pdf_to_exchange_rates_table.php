<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatePdfToExchangeRatesTable extends Migration
{
    public function up()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->date('date')->nullable()->after('value');
            $table->string('pdf', 255)->nullable()->after('date');
        });
    }

    public function down()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn(['date', 'pdf']);
        });
    }
}
