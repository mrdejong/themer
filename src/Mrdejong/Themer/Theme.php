<?php namespace Mrdejong\Themer;

class Theme {
	private $name;
	private $location;
	private $info;

	/**
	 * Construct Theme. This should be done in Themer.php when booting up.
	 * 
	 * @param string $name
	 * @param string $location
	 * @param array  $info
	 */
	public function __construct($name, $location, $info)
	{
		$this->name = $name;
		$this->location = $location;
		$this->info = $info;
	}

	/**
	 * Get the location to the views folder.
	 * 
	 * @return string
	 */
	public function getViewLocation()
	{
		return $this->location . '/views';
	}

	/**
	 * Get an variable from the info.php file.
	 * 
	 * @return mixed
	 */
	public function __get($key)
	{
		if (isset($this->info[$key]))
			return $this->info[$key];

		return null;
	}

	/**
	 * Magic function for isset. Checks if a variable in info.php exists.
	 * 
	 * @param  string  $key
	 * @return boolean
	 */
	public function __isset($key)
	{
		return isset($this->info[$key]);
	}
}
