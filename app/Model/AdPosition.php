<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    //
    protected $table = 'jy_ad_position';

    public $timestamps = false;

    public function doAdd($data)
    {
    	return self::insert($data);
    }

    public function getList()
    {
    	return self::get();
    }

    
}
