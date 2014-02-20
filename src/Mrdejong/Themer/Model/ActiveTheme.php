<?php namespace Mrdejong\Themer\Model;

use Eloquent;

class ActiveTheme extends Eloquent {

	protected $table = 'active_theme';
	public $timestamps = false;
	protected $softDelete = false;

	public function theme()
	{
		return $this->belongsTo('Theme');
	}

}