<?php
/**
 * Created by PhpStorm.
 * User: pgz
 * Date: 2017/9/14
 * Time: 9:07
 */

namespace app\common\model;
use think\Model;

class ExpressReplace extends Model
{
    //发起代取的用户
    public function user(){
        return $this->belongsTo('user', 'user_id');
    }

	//代取的用户
    public function takeUser(){
        return $this->belongsTo('user', 'take_user_id');
    }
}