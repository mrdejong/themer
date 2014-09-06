<?php

/**
 * Routes for the themer api.
 */


Route::group(['prefix' => 'themer/assets'], function($theme) {
	Route::get('css/{file}', function($file) {
         
    });
});

$api_routes = function() {
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
};

if (Config::get('themer::themer.enable_api_routes'))
	Route::group(['prefix' => 'themer/api', 'before' => 'is_ajax'], $api_routes);