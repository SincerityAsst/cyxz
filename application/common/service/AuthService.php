<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\Permissions;
use app\common\model\PermissionsRole;

/**
 * Created by PhpStorm.
 * User: lennon
 * Date: 2017/5/13
 * Time: 下午1:32
 */
class AuthService
{
    /**
     * 获取权限
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function selectById($id)
    {
        $permissions = new Permissions();
        $map = [
            'id' => $id,
            'status' => CommonEntity::STATUS_VALID
        ];

        return $permissions->where($map)->find();
    }

    public function selectByPid($pid = 0)
    {
        $permissions = new Permissions();
        $map = [
            'pid' => $pid,
            'status' => CommonEntity::STATUS_VALID
        ];

        return $permissions->where($map)->select();
    }

    public function selectBySlug($slug)
    {
        $permissions = new Permissions();

        $map = [
            'slug' => $slug,
            'status' => CommonEntity::STATUS_VALID
        ];
        $result = $permissions->where($map)->find();

        return $result ? true : false;
    }

    /**
     * 权限列表
     * @param $params
     * @param int $per_page
     * @return \think\Paginator
     */
    public function selectPermissions($params, $per_page = 10)
    {
        $permissions = new Permissions();
        $map = [
            'status' => CommonEntity::STATUS_VALID
        ];
        return $permissions->where($map)->order('created_at desc')->paginate($per_page);
    }

    /**
     * 保存权限
     * @param $data
     * @return int|string
     */
    public function storePermission($data)
    {
        $insert_data = [
            'pid' => isset($data['pid']) ? $data['pid'] : '',
            'path' => isset($data['path']) ? $data['path'] : '',
            'name' => isset($data['name']) ? $data['name'] : '',
            'slug' => isset($data['slug']) ? $data['slug'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'status' => isset($data['status']) ? $data['status'] : CommonEntity::STATUS_VALID,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions = new Permissions();
        return $permissions->insertGetId($insert_data);
    }

    public function storePermissionsRole($data)
    {
        $insert_data = [
            'role_id' => isset($data['role_id']) ? $data['role_id'] : 0,
            'permissions' => isset($data['permissions']) ? $data['permissions'] : '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions_role = new PermissionsRole();
        return $permissions_role->data($insert_data)->save();
    }

    public function editPermissionsRole($data)
    {
        $update_data = [
            'permissions' => isset($data['permissions']) ? $data['permissions'] : '',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions_role = new PermissionsRole();
        $map = [
            'role_id' => $data['role_id']
        ];
        return $permissions_role->where($map)->update($update_data);
    }

    /**
     * 更新权限
     * @param $id
     * @param $data
     * @return $this
     */
    public function updatePermission($id, $data)
    {
        $update_data = [
            'pid' => isset($data['pid']) ? $data['pid'] : '',
            'path' => isset($data['path']) ? $data['path'] : '',
            'name' => isset($data['name']) ? $data['name'] : '',
            'slug' => isset($data['slug']) ? $data['slug'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $permissions = new Permissions();
        return $permissions->where(array('id' => $id))->update($update_data);
    }

    /**
     * 删除权限
     * @param $id
     * @return $this
     */
    public function removePermission($id)
    {
        $permissions = new Permissions();
        $map = [
            'id' => $id,
            'status' => CommonEntity::STATUS_VALID
        ];

        $update_data = [
            'status' => CommonEntity::STATUS_INVALID,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $permissions->where($map)->update($update_data);
    }
}