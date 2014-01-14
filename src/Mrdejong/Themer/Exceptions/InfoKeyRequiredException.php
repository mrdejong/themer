<?php namespace Mrdejong\Themer\Exceptions;

use Exception;

class InfoKeyRequiredException extends Exception {
	public function __construct($key, $themeName, $infoFileLocation)
	{
		parent::__construct("An option with the name '$key' is required in '$infoFileLocation' for theme '$themeName'.");
	}
}