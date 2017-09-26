<?php namespace app\admin\controller;

use app\common\entity\CommonEntity;
use app\common\model\Permissions;
use app\common\model\PermissionsRole;
use app\common\service\FlowService;
use app\common\service\MenuService;
use app\common\service\RoleService;
use think\Controller;
use think\Request;

class Base extends Controller
{

    public function _initialize()
    {
        $user = session('user');
        if (empty($user)) {
            return $this->error('请登录', url('login/index'), '', 1);
            // return $this->redirect(url('login/index'));
        }

        $request = Request::instance();
        $controller_name = strtolower($request->controller());
        $action = strtolower($request->action());

        $admin_uid = config('admin_uid');

        // 获取所有菜单
        $menu_service = new MenuService();
        $menus = $menu_service->selectByPidOrderSort();
        if (!empty($menus)) {
            foreach ($menus as $key => $item) {
                $child = $menu_service->selectByPidOrderSort($item->id);

                $menus[$key]->child = !empty($child) ? $child : [];
            }
        }

        $navs = array();
        foreach ($menus as $item) {
            $nav = [
                'cate' => $item->name,
                'class' => !empty($item->controller) && in_array($controller_name, explode(',', $item->controller)) ? 'active' : '',
                'icon' => $item->icon,
                'url' => $item->url            
            ];

            if (!empty($item->child)) {
                $childs = array();
                foreach ($item->child as $val) {
                    $child = [
                        'name' => $val->name,
                        'class' => $controller_name == $val->controller && in_array($action, explode(',', $val->action)) ? 'active' : '',
                        'icon' => $val->icon,
                        'url' => $val->url,
                    ];

                    $childs[] = $child;
                }

                $nav['child'] = $childs;
            } else {
                $nav['child'] = array();
            }

            $navs[] = $nav;
        }

        // 管理员不用判断权限
        if ($user['id'] != $admin_uid) {
            // 获取用户的权限
            $role_service = new RoleService();
            $role_ids = $role_service->selectByAdminUsersId($user['id']);

            // 获取角色权限
            $auth = array();
            $permissions_role = new PermissionsRole();
            if (!empty($role_ids)) {
                $role_map = [
                    'role_id' => array('in', $role_ids)
                ];
                $role = $permissions_role->where($role_map)->select();
                if (!empty($role)) {
                    $permissions_ids = array();
                    foreach ($role as $item) {
                        $permissions_ids[] = $item->permissions;
                    }

                    if (!empty($permissions_ids)) {
                        $auth = join(',', $permissions_ids);
                    }
                }
            }

            if (empty($auth)) {
                return $this->redirect('login/logout');
            }

            $auth = array_unique(explode(',', $auth));

            $permissions = new Permissions();
            $permissions_map = [
                'id' => array('in', $auth),
                'status' => CommonEntity::STATUS_VALID
            ];
            $auth_list = $permissions->where($permissions_map)->select();

            $slugs = array();
            if (!empty($auth_list)) {
                foreach ($auth_list as $item) {
                    $slugs[] = $item->slug;
                }
            }

            // 查询访问的权限是否在权限列表之内
            $all_permissions_map = [
                'status' => CommonEntity::STATUS_VALID
            ];
            $all_permissions = $permissions->where($all_permissions_map)->field('slug')->select();

            $all_auth = array();
            if ($all_permissions) {
                foreach ($all_permissions as $item) {
                    $all_auth[] = $item->slug;
                }
            }

            $current_operation = $request->module() . DS . $controller_name . DS . $action;

            if (!empty($all_auth) && in_array($current_operation, $all_auth)) {
                if (!in_array($current_operation, $slugs)) {
                    $this->error('您没有权限', url('index/index'), '', 1);
                }
            }

            // 菜单权限
            foreach ($navs as $key => $item) {
                if (empty($item['child'])) {
                    unset($navs[$key]);
                } else {
                    foreach ($item['child'] as $k => $val) {
                        if (!in_array(strtolower($val['url']), $slugs)) {
                            unset($navs[$key]['child'][$k]);
                        }
                    }

                    if (empty($navs[$key]['child'])) {
                        unset($navs[$key]);
                    }
                }
            }
        }

        $this->assign('title', '诚毅小助管理系统');
        $this->assign('nav', $navs);
    }
}
