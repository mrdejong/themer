<?php namespace Mrdejong\Themer;

use Illuminate\View\FileViewFinder;

class ThemeViewFinder extends FileViewFinder {
	public function prependPath($path)
	{
		$paths = $this->paths;
		$path = array($path);

		$this->paths = array_merge($path, $paths);
	}
}