<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKlUserProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function($table) {
			$table->string('certificate', 1000)->nullable();
			$table->string('about', 1000)->nullable();
			$table->string('manager',10)->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function($table) {
			$table->dropColumn('certificate');
			$table->dropColumn('about');
			$table->dropColumn('manager');
		});
    }
}
