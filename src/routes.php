<?php

/**
 * Routes for the themer api.
 */

if (!Config::get('themer::themer.enable_api_routes'))
	return; // To bad this option is disabled.

Route::group(['prefix' => '{theme}/assets'], function($theme) {
	
});

Route::group(['prefix' => 'themer/api', 'before' => 'is_ajax'], function() {
	Route::get('activate/{theme}', function($theme)
	{
		$theme = Themer::getTheme($theme);
		$theme->activate();

		return Response::json(array('result' => 'success'));
	});

	Route::get('deactivate/{theme}', function($theme)
	{
		return App::abort(404);
	});

	Route::get('info/active-theme', function()
	{
		$theme = Themer::getActiveTheme();

		return Response::json(array('name' => $theme->getName()));
	});

	Route::get('info/{theme}', function($theme)
	{
		$theme = Themer::getTheme($theme);

		return Response::json($theme->getInfo());
	});

	Route::get('list', function()
	{
		return Response::json(Themer::getThemes());
	});
});