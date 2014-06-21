<?php namespace Mrdejong\Themer;

use Illuminate\Foundation\Application;
use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;
use Illuminate\View\ViewFinderInterface;
use Illuminate\Support\ServiceProvider;

class ThemerServiceProvider extends ViewServiceProvider { 
	protected $defer = false;

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
		$this->app->bindShared('themer', function($app)
		{
			return new Themer($app);
		});
        
        $this->app->bindShared('themer.active_theme', function($app) {
            return new ActiveThemes(); 
        });

		parent::register();
	}

	/**
	 * Register the view finder implementation.
	 *
	 * @return void
	 */
	public function registerViewFinder()
	{
		$this->app->bindShared('view.finder', function($app)
		{
			return new ThemeViewFinder($app['files'], $app['config']['view.paths']);
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
