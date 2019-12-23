<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrgOpportunityUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('org_opportunity_users', function (Blueprint $table) {
            $table->integer('approve')->after('apply')->default(0)->comment("1-approved,2-rejected");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('org_opportunity_users', function (Blueprint $table) {
            $table->dropColumn('approve');
        });
    }
}
