<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActiveThemeTable extends Migration {

	public function up()
	{
		Schema::create('active_theme', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('theme_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('active_theme');
	}
}