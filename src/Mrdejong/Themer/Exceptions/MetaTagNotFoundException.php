<?php namespace Mrdejong\Themer\Exceptions;

class MetaTagNotFoundException extends \Exception {
	public function __construct($tag)
	{
		$message = "Tag '$tag' not found in metadata registry (Themer)";
		parent::__construct($message);
	}
}