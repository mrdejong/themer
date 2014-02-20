<?php

//use Mrdejong\Themer\Facades\Themer;

/**
 * This will enable the user to activate a theme per route.
 *
 * @usage
 * array('before' => 'theme:themename,[optional]force it') 
 */
Route::filter('theme', function($route, $requiest, $name, $force = false)
{
	Themer::activate($name, (bool)$force);
});

App::before(function($request)
{

});