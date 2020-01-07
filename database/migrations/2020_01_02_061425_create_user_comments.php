<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('user_id');
			$table->bigInteger('to_id');
			$table->bigInteger('org_id');
			$table->string('comment', 1000);
            $table->timestamps();
            $table->index(['id', 'user_id', 'to_id', 'org_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_comments');
    }
}
