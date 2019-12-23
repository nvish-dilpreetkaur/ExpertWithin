<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type_of_notification')->comment('1:share_opportunity,2:share_acknowledgement');
            $table->bigInteger('key_value');
            $table->bigInteger('sender_id')->foreign('sender_id')->references('id')->on('users');
            $table->bigInteger('recipient_id')->foreign('recipient_id')->references('id')->on('users');            $table->tinyInteger('is_unread')->default(0)->comment('0:unread,1:read');
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
        Schema::dropIfExists('notifications');
    }
}
