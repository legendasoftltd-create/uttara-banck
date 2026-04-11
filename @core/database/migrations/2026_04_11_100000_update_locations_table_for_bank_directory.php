<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE locations MODIFY type ENUM('branch','sub_branch','atm','agent') NOT NULL DEFAULT 'branch'");

        if (!Schema::hasColumn('locations', 'slug')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        if (!Schema::hasColumn('locations', 'branch')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('branch')->nullable()->after('type');
            });
        }

        if (!Schema::hasColumn('locations', 'upazila')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('upazila')->nullable()->after('district');
            });
        }

        if (!Schema::hasColumn('locations', 'dhaka_branch')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->boolean('dhaka_branch')->default(0)->after('upazila');
            });
        }

        if (!Schema::hasColumn('locations', 'mobile')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('mobile')->nullable()->after('phone');
            });
        }

        if (!Schema::hasColumn('locations', 'fax')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('fax')->nullable()->after('mobile');
            });
        }

        if (!Schema::hasColumn('locations', 'image')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->unsignedBigInteger('image')->nullable()->after('fax');
            });
        }

        if (!Schema::hasColumn('locations', 'dates')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('dates')->nullable()->after('opening_hours');
            });
        }

        if (!Schema::hasColumn('locations', 'date_opening')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->date('date_opening')->nullable()->after('dates');
            });
        }

        if (!Schema::hasColumn('locations', 'locker')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->boolean('locker')->default(0)->after('date_opening');
            });
        }

        if (!Schema::hasColumn('locations', 'gstatus')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('gstatus')->nullable()->after('locker');
            });
        }

        if (!Schema::hasColumn('locations', 'routing_no')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('routing_no')->nullable()->after('gstatus');
            });
        }
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $columns = [
                'slug',
                'branch',
                'upazila',
                'dhaka_branch',
                'mobile',
                'fax',
                'image',
                'dates',
                'date_opening',
                'locker',
                'gstatus',
                'routing_no',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('locations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
