<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Departments
        if (!Schema::hasColumn('departments', 'company_id')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            });
            DB::table('departments')->whereNull('company_id')->update(['company_id' => 1]);
        }
        
        // Locations
        if (!Schema::hasColumn('locations', 'company_id')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            });
            DB::table('locations')->whereNull('company_id')->update(['company_id' => 1]);
        }
        
        // Units
        if (!Schema::hasColumn('units', 'company_id')) {
            Schema::table('units', function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            });
            DB::table('units')->whereNull('company_id')->update(['company_id' => 1]);
        }
    }

    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};