<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ManagerStartEndDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('org_opportunity', function (Blueprint $table) {
            $table->timestamp('job_start_date')->after('apply_before')->nullable();
            $table->timestamp('job_complete_date')->after('job_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('org_opportunity', function (Blueprint $table) {
            $table->dropColumn('job_start_date');
            $table->dropColumn('job_complete_date');
        });
    }
}
