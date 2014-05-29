<?php namespace Mrdejong\Themer;

use Illuminate\Foundation\Application;
use Illuminate\View\FileViewFinder;

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

	/**
	 * Contains a stack of validated themes.
	 * 
	 * [String] => Mrdejong\Themer\Theme
	 * @var array
	 */
	private $themes = array();

	private $themeActivationForced = false;

	private $activeTheme;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->activeThemes = new ActiveThemes();
	}

	/**
	 * Boot up themer, this method will be called in `filter.php`
	 * inside the App::before callback.
	 * 
	 * @param Illuminate\Http\Request $request
	 */
	public function boot(\Illuminate\Http\Request $request, $autoinstall = false)
	{
		$theme = $this->getActiveTheme();

		if ($theme === "laravel_view_system")
			return;

		if ($autoinstall && !$theme->isInstalled())
		{
			$theme->install();
		}

		if ($theme->isInstalled())
		{
			$this->app['view']->getFinder()->prependPath($theme->getViewLocation());
		}
	}

	/**
	 * Get the active theme.
	 * 
	 * @return Mrdejong\Themer\Theme
	 */
	public function getActiveTheme()
	{
		$priority = (int) Config::get('themer::themer.active_theme_priority');

		switch ($priority)
		{
			case -1:
				// In this case, we going for the active theme defined in our configuration file.
				$active_theme = Config::get('themer::themer.active_theme');
				$theme = $this->getTheme($active_theme);
				
				return $theme;
			break;

			case 0:
				foreach ($this->getThemes() as $theme)
				{
					var_dump($theme->isInstalled());
					if ($theme->isInstalled() && $theme->getModel()->active)
						return $theme;
				}

				return "laravel_view_system";
			break;

			default:
				if(isset($this->activeTheme))
					return $this->getTheme($this->activeTheme);

				if ($active_theme = Config::get('themer::themer.active_theme') && $theme = $this->getTheme($active_theme))
					return $theme;

				// No active theme!
				return "laravel_view_system";
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
		$location = with(new ThemeFinder())->find($name);

		return  new Theme($name, $location);
	}

	/**
	 * Get all the themes
	 *
	 * @return  Array[Theme]
	 */
	public function getThemes()
	{
		$paths = glob(Config::get("themer::themer.themes_path") . '/*');

		$results = array();

		foreach($paths as $path)
		{
			$name = str_replace(Config::get("themer::themer.themes_path"), "", $path);
			$name = str_replace('/', '', $name);

			$results[] = new Theme($name, $path);
		}

		return $results;
	}

	/**
	 * Activate a theme.
	 * @param  string  $name
	 * @param  boolean $force
	 * @return void
	 */
	public function activate($name, $force = false)
	{
		$theme = $this->getTheme($name);
		
		$theme->setForced($force);

		$this->activeThemes->prepend($theme);

		$this->app['view']->getFinder()->prependPath($theme->getViewLocation());
	}

	/**
	 * Deactive all themes in the database.
	 */
	public function deactivateAll()
	{
		foreach($this->getThemes() as $theme)
		{
			if ($theme->isInstalled())
			{
				$model = $theme->getModel();

				$model->active = false;

				$model->save();
			}
		}
	}

	/**
	 * Validates the info.php file, located in each theme.
	 * @param  array  $info Contents of the info.php file.
	 * @return boolean
	 */
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
