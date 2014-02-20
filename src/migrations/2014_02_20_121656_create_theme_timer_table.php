<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemeTimerTable extends Migration {

	public function up()
	{
		Schema::create('theme_timer', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('theme_id')->unsigned();
			$table->datetime('activate_on');
			$table->datetime('deactivate_on');
		});
	}

	public function down()
	{
		Schema::drop('theme_timer');
	}
}