<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['year', 'item_id', 'title', 'gallery_url', 'gallery_plus_url', 'view_item_url', 'currency_id', 'currency_value', 'time_left', 'start_time', 'end_time'];

    public function getDates()
    {
        return array('created_at', 'updated_at', 'start_time', 'end_time');
    }
}
