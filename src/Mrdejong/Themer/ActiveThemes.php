<?php namespace Mrdejong\Themer;

class ActiveThemes {
	/**
	 * Holds the data array
	 * @var array
	 */
	private $list = array();

	public function __construct(array $list = array())
	{
		$this->list = $list;
	}

	public function append($key, $item)
	{
		$this->list[$key] = $item;
	}

	public function toArray()
	{
		return $this->list;
	}

	public function clear()
	{
		$this->list = array();
	}

	public function remove(Theme $value)
	{
		foreach($this->list as $index => $theme)
		{
			if ($theme === $value)
			{
				unset($this->list[$index]);
			}
		}
	}
}