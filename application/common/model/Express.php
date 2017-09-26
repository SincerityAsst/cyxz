<?php

namespace app\common\model;

use think\Model;

class Express extends Model
{
    public function user(){
    	return $this->belongsTo('user', 'user_id');
    }
}
