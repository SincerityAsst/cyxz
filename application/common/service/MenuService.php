<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\Menu;

/**
 * Created by PhpStorm.
 * User: lennon
 * Date: 2017/5/24
 * Time: 下午3:44
 */
class MenuService
{
    public function selectAll()
    {
        $menu = new Menu();
        $map = [
            'status' => CommonEntity::STATUS_VALID
        ];

        return $menu->where($map)->order('concat(path,id)')->select();
    }

    public function selectByPid($pid = 0)
    {
        $menu = new Menu();
        $map = [
            'pid' => $pid,
            'status' => CommonEntity::STATUS_VALID
        ];

        return $menu->where($map)->select();
    }

    public function selectByPidOrderSort($pid = 0)
    {
        $menu = new Menu();
        $map = [
            'pid' => $pid,
            'status' => CommonEntity::STATUS_VALID
        ];

        return $menu->where($map)->order('sort asc')->select();
    }

    public function selectById($id)
    {
        $map = [
            'id' => $id
        ];

        $menu = new Menu();

        return $menu->where($map)->find();
    }

    public function store($data)
    {
        $insert_data = [
            'pid' => isset($data['pid']) ? $data['pid'] : 0,
            'path' => isset($data['path']) ? $data['path'] : '',
            'name' => isset($data['name']) ? $data['name'] : '',
            'controller' => isset($data['controller']) ? $data['controller'] : '',
            'action' => isset($data['action']) ? $data['action'] : '',
            'icon' => isset($data['icon']) ? $data['icon'] : '',
            'url' => isset($data['url']) ? $data['url'] : '',
            'status' => isset($data['status']) ? $data['status'] : CommonEntity::STATUS_VALID,
            'sort' => isset($data['sort']) ? $data['sort'] : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $menu = new Menu();
        return $menu->data($insert_data)->save();
    }

    public function edit($data)
    {
        $update_data = [
            'pid' => isset($data['pid']) ? $data['pid'] : 0,
            'path' => isset($data['path']) ? $data['path'] : '',
            'name' => isset($data['name']) ? $data['name'] : '',
            'controller' => isset($data['controller']) ? $data['controller'] : '',
            'action' => isset($data['action']) ? $data['action'] : '',
            'icon' => isset($data['icon']) ? $data['icon'] : '',
            'url' => isset($data['url']) ? $data['url'] : '',
            'sort' => isset($data['sort']) ? $data['sort'] : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $menu = new Menu();
        $map = [
            'id' => $data['id']
        ];
        return $menu->where($map)->update($update_data);
    }

    public function remove($id)
    {
        $map = [
            'id' => $id
        ];

        $update_data = [
            'status' => CommonEntity::STATUS_INVALID,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $menu = new Menu();
        return $menu->where($map)->update($update_data);
    }
}