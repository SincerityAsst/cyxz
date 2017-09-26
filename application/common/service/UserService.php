<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\User as UserModel;

/**
 *用户
 */
class UserService
{
    /**
     * 分页列表
     * @param int $per_page
     * @return \think\Paginator
     */
    public function selectWithPage()
    {
        $model = new UserModel();
        $data = $model->order('created_at desc')->paginate(config('paginate.list_rows'));
        return $data;
    }

    /**
     * 注册用户     
     */
    public function register($data)
    {
        $insert_data = [            
            'openid' => isset($data['openid']) ? $data['openid'] : '',            
            'nickname' => isset($data['nickname']) ? $data['nickname'] : '',
            'avatar' => isset($data['avatar']) ? $data['avatar'] : '',        
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $model = new UserModel();
        return $model->insertGetId($insert_data);
    }

    /**
     * 编辑用户     
     */
    public function edit($data)
    {
        $update_data = [            
            // 'openid' => isset($data['openid']) ? $data['openid'] : '',            
            'nickname' => isset($data['nickname']) ? $data['nickname'] : '',
            // 'avatar' => isset($data['avatar']) ? $data['avatar'] : '',                    
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $map = [
            'id' => $data['id']
        ];

        $model = new UserModel();
        return $model->where($map)->update($update_data);
    }

    /**
     * 用户详情
     */
    public function selectById($id)
    {
        $map = [
            'id' => $id
        ];
        $model = new UserModel();
        $info = $model->where($map)->find(); 
        return $info;
    }

    /**
     * 用户详情
     */
    public function selectByOpenid($openid)
    {
        $map = [
            'openid' => $openid
        ];
        $model = new UserModel();
        $info = $model->where($map)->find();     
        return $info;
    }
    
    /*
     * 登录
     */
    public function login($openid)
    {
        $map = [
            'openid' => $openid, 
        ];

        $model = new UserModel();
        $info = $model->where($map)->find();

        if ($info) {      
            //登录成功
            session('user', $info);
            return true;
        }
        //登录失败
        return false;
        
    }

    /**
     * 删除用户     
     */
    public function remove($id)
    {
        $model = new UserModel();
        $map = [
            'id' => $id
        ];

        $update_data = [
            'status' => CommonEntity::STATUS_INVALID,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $model->where($map)->update($update_data);
    }
}