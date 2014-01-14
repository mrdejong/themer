<?php namespace Mrdejong\Themer;

class Theme {
	private $name;
	private $location;

	public function __construct($name, $location)
	{
		$this->name = $name;
		$this->location = $location;
	}

	public function getViewLocation()
	{
		return $this->location . '/views';
	}
}