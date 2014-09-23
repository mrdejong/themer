<?php namespace Mrdejong\Themer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see http://laravel.com/docs/4.2/facades
 */
class Themer extends Facade {
	public static function getFacadeAccessor()
	{
		return 'themer';
	}
}
