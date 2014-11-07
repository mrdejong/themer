<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThemerActiveList extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('themer_active_list', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('theme_id');
			$table->integer('order')->default(0);

			// Date controll for activation.
			$table->boolean('temporary')->default(false);
			$table->dateTime('activate_on')->nullable();
			$table->dateTime('deactivate_on')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('themer_active_list');
	}

}
