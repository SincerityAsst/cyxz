<?php namespace app\admin\controller;

use app\common\entity\CommonEntity;
use app\common\model\PermissionsRole;
use app\common\service\AuthService;
use app\common\service\RoleService;
use think\Request;
use app\common\model\Role as RoleModel;

class Role extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $role_service = new RoleService();
        $data = $role_service->selectAll();

        return $this->fetch('index', ['list' => $data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        // 获取所有权限列表
        $auth_service = new AuthService();

        // 获取所有一级权限
        $permissions = $auth_service->selectByPid();

        if (!empty($permissions)) {
            foreach ($permissions as $key => $item) {
                $item_permissions = $auth_service->selectByPid($item->id);

                $permissions[$key]->child = $item_permissions ? $item_permissions : [];
            }
        }

        return $this->fetch('create', compact('permissions'));
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        if ($request->isPost()) {
            $name = $request->post('name');
            $description = $request->post('description');
            $permission_ids = $request->post('permission_ids/a');

            $data = compact('name', 'description');

            $role_service = new RoleService();
            $result = $role_service->store($data);
            if ($result) {
                // 保存权限
                if (!empty($permission_ids)) {
                    $str_ids = join(',', $permission_ids);

                    $auth_service = new AuthService();

                    $permission_role_data = [
                        'role_id' => $result,
                        'permissions' => $str_ids
                    ];

                    $auth_service->storePermissionsRole($permission_role_data);
                }

                $this->success('新增成功', url('index'));
            }

            $this->error('新增失败');
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $role_service = new RoleService();
        $info = $role_service->selectById($id);

        // 获取所有权限列表
        $auth_service = new AuthService();

        // 获取所有一级权限
        $permissions = $auth_service->selectByPid();

        if (!empty($permissions)) {
            foreach ($permissions as $key => $item) {
                $item_permissions = $auth_service->selectByPid($item->id);

                $permissions[$key]->child = $item_permissions ? $item_permissions : [];
            }
        }

        // 获取角色的权限
        $permissions_role = new PermissionsRole();
        $map = [
            'role_id' => $info->id
        ];
        $permissions_role_info = $permissions_role->where($map)->find();

        $list = explode(',', $permissions_role_info->permissions);

        return $this->fetch('edit', ['info' => $info, 'permissions' => $permissions, 'list' => $list]);
    }

    /**
     * 保存更新的资源
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function update(Request $request)
    {
        if ($request->isPost()) {
            $id = $request->post('id');
            $name = $request->post('name');
            $description = $request->post('description');
            $permission_ids = $request->post('permission_ids/a');

            $data = compact('id', 'name', 'description');

            $role_service = new RoleService();
            $result = $role_service->update($data);
            if ($result) {
                // 修改权限
                if (!empty($permission_ids)) {
                    $str_ids = join(',', $permission_ids);

                    $auth_service = new AuthService();

                    $permission_role_data = [
                        'role_id' => $id,
                        'permissions' => $str_ids
                    ];

                    $auth_service->editPermissionsRole($permission_role_data);
                }
                $this->success('修改成功', url('index'));
            }

            $this->error('修改失败');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $role = new RoleModel();
        $map = [
            'id' => $id,
            'status' => CommonEntity::STATUS_VALID
        ];
        $update_data = [
            'status' => CommonEntity::STATUS_INVALID,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $role->where($map)->update($update_data);
        if ($result) {
            $this->success('删除成功');
        }

        $this->error('删除失败');
    }
}