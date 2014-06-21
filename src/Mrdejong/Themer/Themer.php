<?php namespace Mrdejong\Themer;

use Illuminate\Foundation\Application;
use Illuminate\View\FileViewFinder;

use Cache;
use Config;
use Carbon\Carbon;
use Session;
use Route;

/**
 * Lets manage those little suckers!!! uhhmm I ment themes...
 */
class Themer {
    /**
     * Contains the string which tells the system to use laravels
     * view folder in other to render the view/mail templates.
     */
    const VANILA_THEME          = "laravel_view_system";
    
	/**
	 * Contains the laravel application instance
	 */
	private $app;

	/**
	 * Contains a stack of validated themes.
	 * 
	 * [String] => Mrdejong\Themer\Theme
	 * @var array
	 */
	private $themes = array();
    
    private $active_theme = null;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->activeThemes = new ActiveThemes();
	}

	public function inDevelopment(Theme $theme = null)
	{
		if ($theme)
			return $theme->inDevelopment();

		return $this->app['env'] == "local" || $this->app['env'] == "development";
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
        
        // Just see if we need to configure anything.
		if ($theme === "laravel_view_system")
			return;
        
        // Some programmers don't need this, so we'll need to think of something
        // so they don't have to go through this if statement.
		if ($autoinstall && !$theme->isInstalled())
		{
			$theme->install();
		}
        
		if ($theme->isInstalled())
		{
            // Not really save, 'prependPath' is not a laravel provided function
            // if a developer didn't install it right, this peace of code can
            // crash the system. We'll have to think of something to prevent it!
			$this->app['view']->getFinder()->prependPath($theme->getViewLocation());
		}
	}

	/**
	 * Reboot the view paths. This will prefend unwanted to be providing views.
	 * 
	 * @param boolean 		Clear the view paths array in the viewfinder.
	 */
	public function reboot($clearViewPaths = false)
	{
		$finder = $this->app['view']->getFinder();
		$theme = $this->getActiveTheme();

		if ($clearViewPaths)
			$finder->resetPaths();

		$finder->prependPath($theme->getViewLocation());
	}

	/**
	 * Get the active theme.
	 * 
	 * @return Mrdejong\Themer\Theme
	 */
	public function getActiveTheme()
	{
		$priority = (int) Config::get('themer::themer.active_theme_priority');
        
        $a = $this->app['themer.active_theme'];
        $active_themes = $a->toArray();
        
        foreach($active_themes as $name => $flags)
        {
            if (Route::current() == $flags['router'])
                return $this->getTheme($name);
        }

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
					if ($theme->isInstalled() && $theme->getModel()->active)
						return $theme;
				}				

				return Themer::VANILA_THEME;
			break;

			default:

				// No active theme!
				return Themer::VANILA_THEME;
			break;
		}

		return Themer::VANILA_THEME;
	}

	/**
	 * Get a theme.
	 * 
	 * @param  string 		The name of the theme you want to get.
	 * @return Theme
	 */
	public function getTheme($name)
	{
		return  new Theme($name);
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
			$name = basename($path);

			$results[] = new Theme($name, $path);
		}

		return $results;
	}

	/**
	 * Activate a theme.
	 * @param  string  		The name of the theme
	 * @param  boolean 		Force activation
	 * @return void
	 */
	public function activate($name, $router = false)
	{
        if ($router)
        {
            $a = $this->app['themer.active_theme'];
            
            $a->append($name, array('router' => $router));
            
            $this->reboot(true);
            
            return;
        }
        
		$theme = $this->getTheme($name);
		
		$theme->activate();

		$this->reboot(true);
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
	 * @param  array  		Contents of the info.php file.
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
