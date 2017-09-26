<?php

namespace app\common\model;

use think\Model;

class Address extends Model
{
    public function user(){
    	return $this->belongsTo('user', 'user_id');
    }
}
