<?php namespace Mrdejong\Themer;

use Config;
use Mrdejong\Themer\Model\Theme as ThemeModel;

class Theme {
	private $name;
	private $location;
	private $info = array();
	private $forced = false;

	/**
	 * Construct Theme. This should be done in Themer.php when booting up.
	 * 
	 * @param string $name
	 * @param string $location
	 * @param array  $info
	 */
	public function __construct($name, $location)
	{
		$this->name = $name;
		$this->location = $location;
		$infoFile = $location . '/info.php';		

		if(Config::get('themer::themer.require_info_file') && !file_exists($infoFile))
			throw new Exception("Placeholder: Mrdejong\Themer\Theme.php 1st exception, function __construct");

		if (file_exists($infoFile))
			$this->info = $this->validateInfo(include $infoFile);
	}

	public function install()
	{
		if ($this->isInstalled())
			return;

		$theme = new ThemeModel;

		$theme->name = $this->name;

		if (isset($this->info['parent']))
		{
			$parent = Themer::getTheme($this->info['parent']);

			if (!$parent->isInstalled())
				$parent->install();

			$theme->parent = $parent;
		}

		$theme->save();
	}

	public function isInstalled()
	{
		return (ThemeModel::where('name', '=', $this->name)->count() > 0) ? true : false;
	}

	public function getModel()
	{
		return ThemeModel::where('name', '=', $this->name)->first();
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

	public function validateInfo(array $info)
	{
		if (!Config::get("themer::themer.validate_info"))
			return $info;

		foreach(Config::get("themer::themer.required_info") as $key => $value)
		{
			if ($value)
			{
				if (!array_key_exists($key, $info))
					throw new Exception("Placeholder: Mrdejong\Themer\Theme.php 2nd exception. Function: validateInfo");
			}
		}

		return $info;
	}

	public function setForced($force = false)
	{
		$this->forced = $force;
	}

	public function isForced()
	{
		return $this->forced;
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

	public function activate()
	{
		if (!$this->isInstalled())
			$this->install();

		\Themer::deactivateAll();

		$model = $this->getModel();
		$model->active = true;
		$model->save();
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
