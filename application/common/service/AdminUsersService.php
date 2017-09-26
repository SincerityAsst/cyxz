<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\AdminUsers;
use app\common\model\AdminUsersRole;

/**
 * Created by PhpStorm.
 * User: lennon
 * Date: 2017/6/13
 * Time: 上午10:01
 */
class AdminUsersService
{
    /**
     * 公司分页列表
     * @param int $per_page
     * @return \think\Paginator
     */
    public function selectWithPage($per_page = 10)
    {
        $admin_users = new AdminUsers();

        $admin_uid = config('admin_uid');
        $map['id'] = array('neq', $admin_uid);
        $map['status'] = CommonEntity::STATUS_VALID;

        $data = $admin_users->where($map)->order('created_at desc')->paginate($per_page);

        return $data;
    }

    /**
     * 新增系统用户
     * @param $data
     * @return int|string
     */
    public function store($data)
    {
        $insert_data = [            
            'account' => isset($data['account']) ? $data['account'] : '',
            'password' => isset($data['password']) ? $data['password'] : md5('123456'),
            'username' => isset($data['username']) ? $data['username'] : '',
            'phone' => isset($data['phone']) ? $data['phone'] : '',
            'status' => isset($data['status']) ? $data['status'] : CommonEntity::STATUS_VALID,
            'forbidden' => isset($data['forbidden']) ? $data['forbidden'] : 0,
            'remarks' => isset($data['remarks']) ? $data['remarks'] : '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $admin_users = new AdminUsers();
        return $admin_users->insertGetId($insert_data);
    }

    /**
     * 编辑系统用户
     * @param $data
     * @return $this
     */
    public function edit($data)
    {
        $update_data = [            
            'account' => isset($data['account']) ? $data['account'] : '',
            'username' => isset($data['username']) ? $data['username'] : '',
            'phone' => isset($data['phone']) ? $data['phone'] : '',
            'remarks' => isset($data['remarks']) ? $data['remarks'] : '',
            'forbidden' => isset($data['forbidden']) ? $data['forbidden'] : '',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (isset($data['password']) && !empty($data['password'])) {
            $update_data['password'] = $data['password'];
        }

        $map = [
            'id' => $data['id']
        ];

        $admin_users = new AdminUsers();
        return $admin_users->where($map)->update($update_data);
    }

    /**
     * 系统用户详情
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function selectById($id)
    {
        $map = [
            'id' => $id
        ];
        $admin_users = new AdminUsers();

        $info = $admin_users->where($map)->find();

        if (empty($info)) {
            return false;
        }       

        // 查询用户角色
        $admin_users_role = new AdminUsersRole();
        $role_map = [
            'admin_users_id' => $info->id,
            'status' => CommonEntity::STATUS_VALID
        ];
        $roles = $admin_users_role->where($role_map)->select();

        $role_ids = array();
        if (!empty($roles)) {
            foreach ($roles as $item) {
                $role_ids[] = $item->role_id;
            }
        }

        $info->roles = !empty($role_ids) ? $role_ids : [];

        return $info;
    }

    //验证用户名是否存在
    public function checkAccount($account)
    {
        $admin_users = new AdminUsers();

        $map = [
            'account' => $account
        ];

        $info = $admin_users->where($map)->find();

        return $info;
    }

    /*
     * 登录
     * @param $account
     * @param $password
     * @return bool
     */
    public function login($account, $password)
    {
        $map = [
            'account' => $account,
            'password' => md5($password),
            'status' => CommonEntity::STATUS_VALID
        ];

        $admin_users = new AdminUsers();
        $info = $admin_users->where($map)->find();

        if ($info) {
            //帐号被禁用
            if($info['forbidden'] == 1){
                return 2; 
            }
            //登录成功
            session('user', $info);
            return 1;
        }
        //帐号或密码错误
        return 0;
        
    }

    /**
     * 删除系统用户
     * @param $id
     * @return $this
     */
    public function remove($id)
    {
        $admin_users = new AdminUsers();
        $map = [
            'id' => $id
        ];

        $update_data = [
            'status' => CommonEntity::STATUS_INVALID,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $admin_users->where($map)->update($update_data);
    }
}