<?php namespace Mrdejong\Themer;

use Illuminate\Foundation\Application;

use Cache;
use Config;
use Carbon\Carbon;

/**
 * Lets manage those little suckers!!! uhhmm I ment themes...
 */
class Themer {
	/**
	 * @var Illuminate\Foundation\Application
	 */
	private $app;

	private $themes = array();

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Boot up all the themes, and validate them.
	 *
	 * Also check if there listed in the database.
	 *
	 * This function will be called in the service provider. So don't worry about it!
	 * 
	 * @return void
	 */
	public function boot()
	{
		if (Cache::has('themer.themes'))
		{
			$this->themes = Cache::get('themer.themes');
			return; 
		}

		$themes_path 			= Config::get('themer::themer.themes_path'); // Location to the themes folder.
		$validate_info 			= Config::get('themer::themer.validate_info'); // Boolean wheter to check the info array.
		$require_info_file 		= Config::get('themer::themer.require_info_file'); // Boolean wheter to check for an info file.

		$theme_info = array();

		$dirs = glob($themes_paths . '/*');
		
		foreach($dirs as $dir)
		{
			if($require_info_file)
			{
				if(!file_exists($dir . '/info.php'))
					break; // Lets just not at the theme to the stack.

				$theme_info = include $dir . '/info.php';

				if($validate_info && !$this->validateInfoParameters($theme_info))
					break;
			}

			// Filter out the theme name.
			$name = str_replace($themes_path, '', $dir);

			$this->themes[$name] = new Theme($name, $dir, $theme_info);
		}

		Cache::put('themer.themes', $this->themes, Carbon::now()->addMinutes(10));
	}

	/**
	 * Get the active theme.
	 * 
	 * @return Mrdejong\Themer\Theme
	 */
	public function getActiveTheme()
	{
		$priority = \Config::get('themer::themer.active_theme_priority');

		switch ($priority)
		{
			case -1:
				// In this case, we going for the active theme defined in our configuration file.
				$active_theme = \Config::get('themer::themer.active_theme');
				return $this->themes[$active_theme];
			break;
		}
	}

	/**
	 * Get a theme.
	 * 
	 * @param  string $name The name of the theme you want to get.
	 * @return Theme
	 */
	public function getTheme($name)
	{
		return (isset($this->themes[$name])) ? $this->themes[$name] : null;
	}

	protected function validateInfoParameters(array $info)
	{
		$required_info = Config::get('themer::themer.required_info'); // Array with the required info parameters.

		foreach($required_info as $key => $value)
		{
			if(!$value)
				break;

			if(!array_key_exists($key, $info))
				return false;
		}

		return true;
	}
}