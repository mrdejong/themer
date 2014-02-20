<?php namespace Mrdejong\Themer;

use Config;

use Mrdejong\Themer\Exception\ThemeNotFoundException;

class ThemeFinder implements ThemeFinderInterface {
	public function find($name)
	{
		$path = Config::get('themer::themer.themes_path');
		$themePath = $path . '/' . $name;

		if(!is_dir($themePath))
		{
			throw new ThemeNotFoundException($name);
		}

		return $themePath;
	}
}