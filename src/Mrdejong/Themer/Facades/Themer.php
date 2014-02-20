<?php namespace Mrdejong\Themer\Facades;

use Illuminate\Support\Facades\Facade;

class Themer extends Facade {
	public static function getFacadeAccessor()
	{
		return 'themer';
	}
}
