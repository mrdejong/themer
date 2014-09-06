<?php namespace Mrdejong\Themer;

use Config;
use Mrdejong\Themer\Model\Theme as ThemeModel;
use Mrdejong\Themer\Model\ThemeTimer;

/**
 * This is a class wrapper for a single theme.
 */
class Theme {
	/**
	 * Contains the directory name of the theme.
	 */
	private $name;

	/**
	 * Contains the location to the theme.
	 */
 	private $location;

 	/**
 	 * Contains the info.php array (if availible)
 	 */
	private $info = array();

	/**
	 * Is the theme forced to activate and take priority over every other active theme.
	 */
	private $forced = false;

	/**
	 * Construct Theme. This should be done in Themer.php when booting up.
	 * 
	 * @param string 	The name of the theme (usually the directory name the theme is located in)
	 * @param string 	The location to the theme (deprecated)
	 */
	public function __construct($name, $location = "")
	{
		$this->name = $name;
		$this->location = realpath(with(new ThemeFinder())->find($name));
		$infoFile = $location . '/info.php';		

		if(Config::get('themer::themer.require_info_file') && !file_exists($infoFile))
			throw new Exception("Placeholder: Mrdejong\Themer\Theme.php 1st exception, function __construct");

		if (file_exists($infoFile))
			$this->info = $this->validateInfo(include $infoFile);
	}

	public function toArray($withInfo = false)
	{
		$data = array(
			'name'		=> $this->name,
			'path'		=> $this->location
		);

		if ($withInfo)
			$data['info'] = $this->info;

		return $data;
	}

	/**
	 * Register the theme in the database.
	 */
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

		if (isset($this->info['activate_on']))
		{
			$timer = new ThemeTimer;
			$timer->theme_id = $theme->id;
			$timer->activate_on = $this->info['activate_on']['start'];
			$timer->deactivate_on = $this->info['activate_on']['end'];
			$timer->save();
		}

	}

	/**
	 * Check if the theme is registered in the database.
	 * 
	 * @return boolean 		true if the theme is registered in the database, false if not.
	 */
	public function isInstalled()
	{
		return (ThemeModel::where('name', '=', $this->name)->count() > 0) ? true : false;
	}

	/**
	 * Get the model for the theme.
	 * 
	 * @return Mrdejong\Themer\Model\Theme 
	 */
	public function getModel()
	{
		return ThemeModel::where('name', '=', $this->name)->first();
	}

	/**
	 * Get the location to the views folder.
	 * 
	 * @return string 		The location of the view files
	 */
	public function getViewLocation()
	{
		return $this->location . '/views';
	}

	/**
	 * Validates the info.php file.
	 * 
	 * @param array 		The array of that info.php returns.
	 * @throws Exception 
	 * @return array 		Returns the exact same array as the input
	 */
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

	/**
	 * Set or unset forcing the theme.
	 * 
	 * @param boolean 		True to force the theme
	 */
	public function setForced($force = false)
	{
		$this->forced = $force;
	}

	/**
	 * Check if the theme is forced
	 * 
	 * @return boolean 		True if the theme is forced
	 */
	public function isForced()
	{
		return $this->forced;
	}

	/**
	 * Activate the theme
	 */
	public function activate()
	{
		if (!$this->isInstalled())
			$this->install();

		\Themer::deactivateAll();

		$model = $this->getModel();
		$model->active = true;
		$model->save();
	}

	public function deactivate()
	{
		if (!$this->isInstalled())
			return;

		$model = $this->getModel();
		$model->active = false;
		$model->save();
	}

	/**
	 * Gets the name of the theme.
	 * 
	 * @return string 		The theme name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the info of the theme.
	 * 
	 * @return array 		The info provided the themes info.php file
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * Get an variable from the info.php file.
	 * 
	 * @return mixed 		Can be any type.
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
	 * @param  string  		The variable you want to check
	 * @return boolean		if set returns true
	 */
	public function __isset($key)
	{
		return isset($this->info[$key]);
	}
}
