<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateOpportunityInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_invites', function (Blueprint $table) {
			
            $table->bigIncrements('id');
			$table->bigInteger('batch_id');
			$table->bigInteger('user_id')->foreign('user_id')->references('id')->on('users');
			$table->bigInteger('opp_id');
			$table->bigInteger('created_by');
			$table->tinyInteger('status')->default(1)->comment('0:inactive,1:active');
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
        Schema::dropIfExists('opportunity_invites');
    }
}
