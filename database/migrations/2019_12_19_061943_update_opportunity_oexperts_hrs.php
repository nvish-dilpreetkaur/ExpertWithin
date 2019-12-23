<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOpportunityOexpertsHrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('org_opportunity', function (Blueprint $table) {
            $table->integer('expert_hrs')->after('expert_qty')->default(0);
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
            $table->dropColumn('expert_hrs');
        });
    }
}
