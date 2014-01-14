<?php namespace Mrdejong\Themer;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;

class ThemerServiceProvider extends ViewServiceProvider {
	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	public function boot()
	{
		$this->package('mrdejong/themer');
	}

	/**
	 * Override the parent's register function
	 * to add our own functionality!
	 *
	 * @return void
	 */
	public function register()
	{
		// First register our stuff!
		$this->app->bindShared('themer', function($app)
		{
			$themer = new Themer($app);

			$themer->boot();

			return $themer;
		});

		//$this->app->resolve('themer.themer');

		// Let the parent do the it's work too!
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
			$theme = $app['themer']->getActiveTheme();

			$vanilla_paths = $app['config']['view.paths'];
			$themes_paths = array($theme->getViewLocation());

			$paths = array_merge($themes_paths, $vanilla_paths);

			return new FileViewFinder($app['files'], $paths);
		});
	}
}