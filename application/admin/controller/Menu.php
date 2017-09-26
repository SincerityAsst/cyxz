<?php

namespace app\admin\controller;

use app\common\service\MenuService;
use think\Request;
use app\common\model\Menu as MenuModel;

class Menu extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $menu_service = new MenuService();
        $list = $menu_service->selectAll();

        if (!empty($list)) {
            foreach ($list as $item) {
                $space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', count(explode(',', $item->path)) - 2);
                $item->path_tag = $space . $item->name;
            }
        }

        return $this->fetch('index', compact('list'));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $menu_service = new MenuService();
        $list = $menu_service->selectByPid();

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
            $input = $request->param();

            if ($input['pid'] == 0) {
                $path = '0,';
            } else {
                $menu = new MenuModel();
                $menu_info = $menu->where(array('id' => $input['pid']))->find();
                $path = $menu_info->path . $menu_info->id . ',';
            }

            $input['path'] = $path;

            $menu_service = new MenuService();
            $result = $menu_service->store($input);

            if ($result) {
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
        $menu_service = new MenuService();
        $list = $menu_service->selectByPid();

        $info = $menu_service->selectById($id);

        return $this->fetch('edit', compact('list', 'info'));
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

            if ($input['pid'] == 0) {
                $path = '0,';
            } else {
                $menu = new MenuModel();
                $menu_info = $menu->where(array('id' => $input['pid']))->find();
                $path = $menu_info->path . $menu_info->id . ',';
            }

            $input['path'] = $path;

            $menu_service = new MenuService();
            $result = $menu_service->edit($input);

            if ($result) {
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
        $menu_service = new MenuService();
        $result = $menu_service->remove($id);
        if ($result) {
            $this->success('删除成功');
        }

        $this->error('删除失败');
    }
}
