<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Themes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('themer_themes', function(Blueprint $table)
		{
			$table->increments('id');

			// Theme info
			$table->string('name'); // Display name of the theme.
			$table->string('folder_name'); // The name of the folder
			$table->text('description'); // Makrdown

			// Theme options
			$table->boolean('enalbed')->default(true); // This doesn't mean that the view system will use the theme.
			$table->boolean('development')->default(false); // When true some development options are enabled, and will make things 'n stuff slower.

			/**
			 * Author details
			 * There are all nullable because there not required by all website owners.
			 */
			$table->string('author_name')->nullable();
			$table->string('author_website')->nullable();
			$table->string('author_support_email')->nullable();
			$table->string('author_github')->nullable();

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
		Schema::drop('themer_themes');
	}

}
