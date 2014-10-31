<?php namespace Mrdejong\Themer;

use Illuminate\View\ViewServiceProvider;
use Mrdejong\Themer\Finder\ThemeViewFinder;

class ThemerServiceProvider extends ViewServiceProvider {
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('mrdejong/themer');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerThemer();

		parent::register();
	}

	public function registerThemer()
	{
		$this->app->bindShared('themer', function($app) {
			$path = $app['config']['themer::themer.themes_path'];

			return new Themer($path);
		});
	}

	/**
	 * Reader: So registerViewFinder what de hell do you do?
	 * Code: I'm making sure that the container knows about the view finder.
	 * Reader: O, really and do you do more?
	 * Code: Apart from setting initial data, no nothing more.
	 * Reader: O, really...
	 * Code: Yes really!
	 * Reader: Oke, good thanks
	 * Code: denada.
	 *
	 * @return void
	 */
	public function registerViewFinder()
	{
		$this->app->bindShared('view.finder', function($app) {
			$view_paths = $app['config']['view.paths'];
			$theme_path = $app['themer']->getActiveThemeViewFolder();

			$paths = array_merge($theme_path, $view_paths);
			
			return new ThemeViewFinder($app['files'], $paths);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
