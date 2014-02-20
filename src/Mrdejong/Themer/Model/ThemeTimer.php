<?php namespace Mrdejong\Themer\Model;

use Eloquent;

class ThemeTimer extends Eloquent {

	protected $table = 'theme_timer';
	public $timestamps = false;
	protected $softDelete = false;

	public function theme()
	{
		return $this->belongsTo('Theme');
	}

}