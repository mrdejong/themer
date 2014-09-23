<?php namespace Mrdejong\Themer\Generator;

use Illuminate\Support\Facades\Config;
use Mrdejong\Themer\Exceptions\ThemeExistsException;

class ThemeGenerator {
	private $name;
	private $optional;
	private $themePath;

	public function __construct($name)
	{
		$this->name = $name;
		$this->themePath = Config::get('themer::themer.themes_path');

		$this->themeExists($name); // check right away. It'll throw an exception when it exists
	}

	public function addOptional($optional)
	{
		$this->optional = $optional;
	}

	protected function generateFolder($folder, $in = "")
	{
		list($required, $key) = explode(':', $folder);

		if ($required == 'required')
		{
			mkdir($this->themePath . (($in != "") ? '/' . $in : '') . '/' . $this->parseVariable($key));
			return true;
		}
		else
		{
			if ($this->optional)
			{
				mkdir($this->themePath . (($in != "") ? '/' . $in : '') . '/' . $this->parseVariable($key));
				return true;
			}
		}

		return false;
	}

	protected function parseVariable($key)
	{
		$vars = array(
			'theme_name'		=> $this->name
		);

		foreach ($vars as $k => $v)
		{
			$key = str_replace('$' . $k, $v, $key);
		}

		return $key;
	}

	protected function themeExists($name)
	{
		if (is_dir($this->themePath . '/' . $name))
			throw new ThemeExistsException($name);
	}

	public function run()
	{
		$structure = include __DIR__.'/theme_folder_structure.php';

		foreach ($structure['root'] as $key => $v)
		{
			//dd($key);
			$this->generateFolder($key);

			foreach($v as $val)
			{
				$this->generateFolder($val, $this->name);
			}
		}
	}
}