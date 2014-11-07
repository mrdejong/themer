<?php namespace Mrdejong\Themer;

use Illuminate\View\ViewServiceProvider;
use Illuminate\Foundation\Application;
use Mrdejong\Themer\Finder\ThemeViewFinder;
use Mrdejong\Themer\Parser\MetaParser;

class ThemerServiceProvider extends ViewServiceProvider {
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (self::isVersion(5))
		{
			throw new \Exception("Laravel 5 is not yet supported.");
		}

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

	/**
	 * Register themer master class.
	 *
	 * @return void
	 */
	public function registerThemer()
	{
		$this->app->bindShared('themer', function($app) {
			if (self::isVersion(4))
			{
				// Laravel version 4
				$path = $app['config']['themer::themer.themes_path.laravel4'];
			}

			return new Themer($app, $path);
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

	/**
	 * Checks the laravel version, this is done via the major version number.
	 *
	 * @param int $version The major of the version you want to compare.
	 */
	public static function isVersion($version)
	{
		return (version_compare(Application::VERSION, $version . '.0.0', '>=') && version_compare(Application::VERSION, $version+1 . '.0.0', '<'));
	}
}
