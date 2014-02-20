<?php namespace Mrdejong\Themer\Model;

use Eloquent;

class UserActiveTheme extends Eloquent {

	protected $table = 'user_active_theme';
	public $timestamps = false;
	protected $softDelete = false;

	public function theme()
	{
		return $this->belongsTo('Theme');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}