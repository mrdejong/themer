<?php

//use Mrdejong\Themer\Facades\Themer;

/**
 * This will enable the user to activate a theme per route.
 *
 * @usage
 * array('before' => 'theme:{themename}')
 */
// Route::filter('theme', function($route, $request, $name)
// {
//     Themer::activate($name, $route);
// });
//
// Route::filter('is_ajax', function($route, $request)
// {
// 	if (!Request::ajax())
// 		return App::abort(404);
// });
//
// App::before(function($request)
// {
// 	//Themer::boot($request, true);
// });
