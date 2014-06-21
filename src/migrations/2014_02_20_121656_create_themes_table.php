<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemesTable extends Migration {

	public function up()
	{
		Schema::create('themes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->boolean('active')->default(false);
            $table->text('flags'); // json formatted
		});
	}

	public function down()
	{
		Schema::drop('themes');
	}
}