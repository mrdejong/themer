<?php namespace Mrdejong\Themer\Model;

use Eloquent;

class ThemerActiveList extends Eloquent {
    protected $table = 'themer_active_list';
    public $timestamps = false;

    public function toArray()
    {
        $data = $this->orderby('order')->get();
        $result = array();

        if (count($data) > 0)
        {
            foreach ($data as $item)
            {
                $result[] = $item->name;
            }

            return $result;
        }

        return null; 
    }
}
