<?php namespace Mrdejong\Themer;

interface ThemeFinderInterface {
	/**
	 * Try and find a theme!
	 * 
	 * @param  string $name
	 * @return string
	 */
	public function find($name);
}
