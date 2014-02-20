<?php namespace Mrdejong\Themer\Model;

use Eloquent;

class Theme extends Eloquent {

	protected $table = 'themes';
	public $timestamps = false;
	protected $softDelete = false;

	public function parent()
	{
		return $this->belongsTo('Theme');
	}

}