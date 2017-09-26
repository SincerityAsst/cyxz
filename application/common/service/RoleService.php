<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\AdminUsersRole;
use app\common\model\Role;

/**
 * Created by PhpStorm.
 * User: lennon
 * Date: 2017/5/6
 * Time: 下午4:55
 */
class RoleService
{
    public function selectAll()
    {
        $role = new Role();
        $map = [
            'status' => CommonEntity::STATUS_VALID
        ];

        return $role->where($map)->order('created_at desc')->paginate(config('paginate.list_rows'));
    }

    public function selectRole()
    {
        $role = new Role();

        $map = [
            'status' => CommonEntity::STATUS_VALID
        ];

        $roles = $role->where($map)->field('id,name')->select();
        return $this->formatData($roles);
    }

    public function selectByAdminUsersId($users_id)
    {
        $admin_users_role = new AdminUsersRole();
        $map = [
            'admin_users_id' => $users_id,
            'status' => CommonEntity::STATUS_VALID
        ];

        $users_role_data = $admin_users_role->where($map)->select();

        $ids = array();
        if (!empty($users_role_data)) {
            foreach ($users_role_data as $item) {
                if (!in_array($item->role_id, $ids)) {
                    $ids[] = $item->role_id;
                }
            }
        }

        return $ids;
    }

    public function selectById($id)
    {
        $role = new Role();

        $map = [
            'id' => $id
        ];

        return $role->where($map)->find();
    }

    /**
     * 新增职位
     * @param $data
     * @return false|int
     */
    public function store($data)
    {
        $role = new Role();
        $insert_data = [
            'name' => isset($data['name']) ? $data['name'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'status' => CommonEntity::STATUS_VALID,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $role->insertGetId($insert_data);
    }

    /**
     * 保存用户权限
     * @param $uid
     * @param $ids
     * @return array|bool|false
     */
    public function storeAdminUsersRole($uid, $ids)
    {
        if (!empty($ids)) {
            $datas = array();

            foreach ($ids as $item) {
                $data = [
                    'admin_users_id' => $uid,
                    'role_id' => $item,
                    'status' => CommonEntity::STATUS_VALID,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $datas[] = $data;
            }

            $admin_users_role = new AdminUsersRole();

            return $admin_users_role->saveAll($datas);
        }

        return false;
    }

    public function removeAdminUsersRole($uid)
    {
        $map = [
            'admin_users_id' => $uid
        ];

        $update_data = [
            'status' => CommonEntity::STATUS_INVALID,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $admin_users_role = new AdminUsersRole();
        return $admin_users_role->where($map)->update($update_data);
    }

    public function update($data)
    {
        $role = new Role();
        $update_data = [
            'name' => isset($data['name']) ? $data['name'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $map = [
            'id' => $data['id']
        ];

        return $role->where($map)->update($update_data);
    }

    public function formatData($data)
    {
        $list = array();
        if (!empty($data)) {
            foreach ($data as $item) {
                $list[] = [
                    'id' => $item->id,
                    'name' => $item->name
                ];
            }
        }
        return $list;
    }
}