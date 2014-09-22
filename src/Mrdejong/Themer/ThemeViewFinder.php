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

	public function prepandLocation($path)
	{
		$path = (array) $path;

		$this->paths = array_merge($path, $this->paths);
	}

	public function resetPaths()
	{
		$this->paths = \Config::get('view.paths');
	}
}
