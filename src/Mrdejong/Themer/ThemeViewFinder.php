<?php namespace Mrdejong\Themer;

use Illuminate\View\FileViewFinder;

class ThemeViewFinder extends FileViewFinder {
	public function prependPath($path)
	{
		$this->paths = array_merge(array($path), $this->paths);
	}
}