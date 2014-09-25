<?php namespace Mrdejong\Themer;

use Mrdejong\Themer\Exceptions\MetaTagNotFoundException;

/**
 * Local metadata class.
 * This class interacts with the meta file for themer.
 */
class MetaData {
	/**
	 * This will contain the path and filename for the meta file.
	 * 
	 * @var string 		$meta_file
	 */
	protected $meta_file;

	/**
	 * Just some default data.
	 * Mostly used for testing purposes.
	 * 
	 * @var array 		$default_data
	 */
	protected $default_data = array(
		'default' 			=> ['theme' => 'default']
	);

	/**
	 * The data of the metafile.
	 * 
	 * @var array 		$data
	 */
	protected $data;

	/**
	 * Constructor for this class.
	 * It sets the meta_file variable, and creates the file if it doesn't exists.
	 * 
	 * @return MetaData
	 */
	public function __construct()
	{
		$this->meta_file = storage_path() . '/meta/themer.json';

		if (!file_exists($this->meta_file))
		{
			file_put_contents($this->meta_file, json_encode($this->default_data));
		}
	}

	/**
	 * Get a value from the meta file.
	 * 
	 * @param string 		$tag 		The key to the value
	 * @return string|null	The value
	 */
	public function get($tag)
	{
		$this->getMetaData();


		if ($result = array_get($this->data, $tag))
			return $result;
		
		return null;
	}

	/**
	 * Sets a value for the meta file
	 * 
	 * @param string 		$tag 		The key belonging to the value
	 * @param mixed 		$value 		The value
	 * @return void
	 */
	public function set($tag, $value)
	{
		$this->getMetaData();

		array_set($this->data, $tag, $value);

		$this->setMetaData();
	}

	/**
	 * Removes a value from the metafile.
	 * 
	 * @param string 		$tag 		The key to remove it's value
	 * @return void
	 */
	public function remove($tag)
	{
		$this->getMetaData();

		array_pull($this->data, $tag);

		$this->setMetaData();
	}

	/**
	 * Get the contents of the meta file
	 * 
	 * @return array
	 */
	protected function getMetaData()
	{
		return $this->data = json_decode(file_get_contents($this->meta_file), true);
	}

	/**
	 * Sets the  contents of the meta file.
	 * 
	 * @return void
	 */
	protected function setMetaData()
	{
		file_put_contents($this->meta_file, json_encode($this->data));
	}
}