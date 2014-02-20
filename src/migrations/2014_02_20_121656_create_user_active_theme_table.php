<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserActiveThemeTable extends Migration {

	public function up()
	{
		Schema::create('user_active_theme', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('theme_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('user_active_theme');
	}
}