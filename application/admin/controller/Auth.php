<?php

namespace app\admin\controller;

use app\common\model\Permissions;
use app\common\service\AuthService;
use think\Request;

class Auth extends Base
{

    public function index(Request $request)
    {
        $auth_service = new AuthService();
        $params = [];
        $data = $auth_service->selectPermissions($params);

        return $this->fetch('index', ['list' => $data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $auth_service = new AuthService();
        $list = $auth_service->selectByPid();

        return $this->fetch('create', compact('list'));
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
            $data = $request->param();

            if (empty($data['name'])) {
                $this->error('名称不能为空');
            }
            if (empty($data['slug'])) {
                $this->error('操作不能为空');
            }

            $slug = strtolower(trim($data['slug']));

            if ($data['pid'] == 0) {
                $path = '0,';
            } else {
                $menu = new Permissions();
                $menu_info = $menu->where(array('id' => $data['pid']))->find();
                $path = $menu_info->path . $menu_info->id . ',';
            }

            $data = array(
                'pid' => $data['pid'],
                'path' => $path,
                'name' => trim($data['name']),
                'slug' => $slug,
                'description' => $data['description'],
            );

            $auth_service = new AuthService();

            // 检测是否添加了权限
            $check_slug = $auth_service->selectBySlug($slug);
            if ($check_slug) {
                $this->error('权限已存在');
            }

            $result = $auth_service->storePermission($data);
            if ($result) {
                $this->success('新增成功', url('index'));
            }

            $this->error('新增失败', url('create'));
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
        $auth_service = new AuthService();
        $info = $auth_service->selectById($id);

        if (empty($info)) {
            $this->error('权限不存在', url('index'), '', 1);
        }

        $auth_service = new AuthService();
        $list = $auth_service->selectByPid();

        return $this->fetch('edit', ['info' => $info, 'list' => $list]);
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
            $data = $request->param();

            if (empty($data['name'])) {
                $this->error('名称不能为空');
            }
            if (empty($data['slug'])) {
                $this->error('操作不能为空');
            }

            $slug = strtolower(trim($data['slug']));

            if ($data['pid'] == 0) {
                $path = '0,';
            } else {
                $menu = new Permissions();
                $menu_info = $menu->where(array('id' => $data['pid']))->find();
                $path = $menu_info->path . $menu_info->id . ',';
            }

            $update_data = array(
                'pid' => $data['pid'],
                'path' => $path,
                'name' => trim($data['name']),
                'slug' => $slug,
                'description' => $data['description'],
            );

            $id = $data['id'];            
            $auth_service = new AuthService();

            $result = $auth_service->updatePermission($id, $update_data);
            if ($result) {
                $this->success('修改成功', url('index'));
            }

            $this->error('修改失败', url('create'));
        }
    }

    /**
     * 删除权限
     * @param $id
     */
    public function delete($id)
    {
        $auth_service = new AuthService();
        $result = $auth_service->removePermission($id);
        if ($result) {
            $this->success('删除成功');
        }

        $this->error('删除失败');
    }
}
