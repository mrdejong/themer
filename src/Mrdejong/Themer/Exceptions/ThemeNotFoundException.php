<?php namespace Mrdejong\Themer\Exceptions;

use Exception;
use Config;

class ThemeNotFoundException extends Exception {
	public function __construct($name)
	{
		$themes_dir = Config::get('themer:themer.themes_path');
		$message = "Theme '$name' is not found in '$themes_dir'";

		parent::__construct($message);
	}
}