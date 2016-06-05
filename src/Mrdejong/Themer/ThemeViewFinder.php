<?php namespace Mrdejong\Themer;

use Illuminate\View\FileViewFinder;

class ThemeViewFinder extends FileViewFinder {
	/**
	 * @deprecated use prepandLocation(string|array $path)
	 */
	public function prependPath($path)
	{
		$this->prepandLocation($path);
	}

	/**
	 * Prepands a path/paths to the array of paths which is used to look up view files.
	 * 
	 * @param string|array  	$path 		A path to a folder containing views.
	 * @return void
	 */
	public function prepandLocation($path)
	{
		$path = (array) $path;

		$this->paths = array_merge($path, $this->paths);
	}

	/**
	 * Resets the paths to it's original (laravels default. @see(configuriation view.php[paths]))
	 */
	public function resetPaths()
	{
		$this->paths = config('view.paths');
	}
}
