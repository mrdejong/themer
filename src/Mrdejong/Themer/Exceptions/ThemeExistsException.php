<?php namespace Mrdejong\Themer\Exceptions;

use Exception;
use Illuminate\Support\Facades\Config;

class ThemeExistsException extends Exception {
	public function __construct($name)
	{
		$message = "Theme '$name' allready exists.";

		parent::__construct($message);
	}
}