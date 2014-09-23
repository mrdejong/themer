<?php namespace Mrdejong\Themer;

use Illuminate\Support\Facades\Config;

use Mrdejong\Themer\Exceptions\ThemeNotFoundException;

/**
 * Basic finder class for finding themes.
 */
class ThemeFinder implements ThemeFinderInterface {
	/**
	 * Takes the name of the theme and checks if the folder with that name
	 * exists within the themes folder (@see config option themer::themer.themes_path for the location.)
	 * 
	 * @param string 	$name 			The name of the theme
	 * @return string 	The location of the theme.
	 * @throws ThemeNotFoundException	If the folder doesn't exist.
	 */
	public function find($name)
	{
		$path = Config::get('themer::themer.themes_path');
		$themePath = $path . '/' . $name;

		if(!is_dir($themePath))
		{
			throw new ThemeNotFoundException($name);
		}

		return realpath($themePath);
	}

	/**
	 * This function looks throw the themes directory and returns all the themes.
	 * 
	 * This method is not tested, please don't expect the right behaviour. 
	 * 
	 * @return array|null 	The directories listed in the themes folder.
	 */
	public function list()
	{
		$path = Config::get('themer::themer.themes_path');

		return glob($path . '/*', GLOB_ONLYDIR);
	}
}