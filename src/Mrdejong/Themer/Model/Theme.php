<?php namespace Mrdejong\Themer\Model;

use Eloquent;

class Theme extends Eloquent {
    protected $table = "themer_themes";

    protected $fillable = ['name', 'folder_name', 'description'];
}
