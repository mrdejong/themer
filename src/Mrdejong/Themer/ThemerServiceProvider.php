<?php namespace Mrdejong\Themer;

use Illuminate\View\ViewServiceProvider;

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
		parent::register();
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

			// Don't you worry reader, I will be changing this one very very very soon!
			return new FileViewFinder($app['files'], $view_paths);
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
