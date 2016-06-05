<?php namespace Mrdejong\Themer;

use Illuminate\Foundation\Application;
use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;
use Illuminate\View\ViewFinderInterface;
use Illuminate\Support\ServiceProvider;

use Mrdejong\Themer\Commands\GenerateCommand;

class ThemerServiceProvider extends ViewServiceProvider { 
	protected $defer = false;

	private $registered = false;

	/**
	 * Put on a package name!
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->package('mrdejong/themer');

		include __DIR__.'/../../filters.php';
		include __DIR__.'/../../routes.php';
	}

	/**
	 * Override the parent's register function
	 * to add our own functionality!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('themer', function($app)
		{
			return new Themer($app);
		});

		$this->app->bind('themer.metadata', function($app)
		{
			return new MetaData();
		});

		$this->registerGenerateCommand();
		
		parent::register();

		$this->registered = true;
	}

	public function registerGenerateCommand()
	{
		$this->app['themer.generate.command'] = $this->app->share(function() {
			return new GenerateCommand();
		});

		$this->commands('themer.generate.command');
	}

	/**
	 * Register the view finder implementation.
	 *
	 * @return void
	 */
	public function registerViewFinder()
	{
		$this->app->bind('view.finder', function($app)
		{
      $finder = new ThemeFinder();
      $theme = $finder->find(config('themer.active_theme'));
      $theme .= '/views';

			$viewFinder = new ThemeViewFinder($app['files'], $app['config']['view.paths']);
      $viewFinder->prepandLocation($theme);
      return $viewFinder;
		});

	}
    
    private function checkInstallation()
    {
        $providers = \Config::get('app.providers');
        
        if (in_array('Illuminate\View\ViewServiceProvider', $providers))
        {
            // Invalid installation
        }
    }
}
