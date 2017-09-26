<?php

namespace app\admin\controller;

use app\common\service\AdminUsersService;
use app\common\service\RoleService;
use app\common\model\AdminUsers as AdminUsersModel;
use think\Request;

class AdminUsers extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $admin_users_service = new AdminUsersService();
        $list = $admin_users_service->selectWithPage();

        return $this->fetch('index', compact('list'));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {

        // 角色列表
        $role_service = new RoleService();
        $roles = $role_service->selectRole();

        return $this->fetch('create', compact('roles'));
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
            $input = $request->param();



            $pwd = trim($input['pwd']);
            $password = trim($input['password']);
            if (!empty($pwd) || !empty($password)) {
                $length = strlen($pwd);
                if ($length < 6) {
                    $this->error('密码长度至少6位');
                }

                if ($pwd != $password) {
                    $this->error('密码不一致');
                }
            }

            $input['password'] = md5($input['password']);

            $admin_users_service = new AdminUsersService();

            //判断是否已经存在这个用户
            $res = $admin_users_service->checkAccount($input['account']);

            if($res)
            {
                $this->error('账号已经存在,请重新创建');
            }

            $result = $admin_users_service->store($input);
            if ($result) {
                // 保存角色权限
                $role_ids = $input['role_ids'];
                if (!empty($role_ids)) {
                    $role_service = new RoleService();
                    $role_service->storeAdminUsersRole($result, $role_ids);
                }

                $this->success('新增成功', url('index'));
            }

            $this->error('新增失败');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $admin_users_service = new AdminUsersService();
        $info = $admin_users_service->selectById($id);

        if (empty($info)) {
            $this->error('数据不存在', null, '', 1);
        }

        // 角色列表
        $role_service = new RoleService();
        $roles = $role_service->selectRole();

        return $this->fetch('edit', compact('info', 'roles'));
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function update(Request $request)
    {
        if ($request->isPost()) {
            $input = $request->param();

            // 超级管理不能编辑
            $uid = session('user.id');
            $admin_uid = config('admin_uid');
            if (($uid != $admin_uid) && $input['id'] == $admin_uid) {
                $this->error('您暂无权限修改');
            }

            $admin_users_service = new AdminUsersService();
            $admin_users_info = $admin_users_service->selectById($input['id']);

            if (empty($admin_users_info)) {
                $this->error('用户不存在', null, '', 1);
            }

            $pwd = trim($input['pwd']);
            $password = trim($input['password']);
            if (!empty($pwd) || !empty($password)) {
                $length = strlen($pwd);
                if ($length < 6) {
                    $this->error('密码长度至少6位');
                }

                if ($pwd != $password) {
                    $this->error('密码不一致');
                }

                $input['password'] = md5($input['password']);
            }


            $result = $admin_users_service->edit($input);
            if ($result) {
                $role_service = new RoleService();
                // 删除之前的角色
                $role_service->removeAdminUsersRole($admin_users_info->id);

                // 保存角色权限
                if (isset($input['role_ids']) && !empty($input['role_ids'])) {
                    $role_ids = $input['role_ids'];
                    $role_service->storeAdminUsersRole($admin_users_info->id, $role_ids);
                }

                $this->success('修改成功', url('index'));
            }

            $this->error('修改失败');
        }
    }

    //用户禁用(只有超级管理员才可以禁用其它用户)
    public function disable($id)
    {
        $admin_users_service = new AdminUsersService();
        $input = $admin_users_service->selectById($id);
        $input['forbidden'] = 1;

        $result = $admin_users_service->edit($input);

        if($result)
        {
            $this->success('禁用成功');
        }else{
            $this->error('禁用失败');
        }
    }

    public function profile()
    {

        return $this->fetch('profile');
    }

    public function updatePassword(Request $request)
    {
        if ($request->isPost()) {
            $password = $request->post('password');
            $confirm_password = $request->post('confirm_password');

            if (strlen($password) < 6) {
                $this->error('密码至少6位');
            }
            if ($password != $confirm_password) {
                $this->error('密码不一致');
            }

            $admin_users = new AdminUsersModel();

            $update_password = md5($confirm_password);
            $map = [
                'id' => session('user.id')
            ];

            $update_data = [
                'password' => $update_password,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $admin_users->where($map)->update($update_data);
            if ($result) {
                $this->success('修改密码成功,请重新登录', url('logout'));
            }

            $this->error('修改密码失败');
        }
    }

    public function logout()
    {
        session('user', null);

        $this->success('退出成功', url('login/index'), '', 1);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $admin_users_service = new AdminUsersService();
        $result = $admin_users_service->remove($id);

        if ($result) {
            $this->success('删除成功');
        }

        $this->error('删除失败');
    }
}
