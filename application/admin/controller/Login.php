<?php
namespace app\admin\controller;

use app\common\service\AdminUsersService;
use think\Controller;
use think\Request;

class Login extends Controller
{
    /** 加载后台登录页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('login/index');
    }

    /**
     * 用户登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $account = $request->post('account');
        $password = $request->post('password');

        if (empty($account)) {
            $this->error('用户名不能为空', null, '', 1);
        }
        if (empty($password)) {
            $this->error('密码不能为空', null, '', 1);
        }

        $admin_users_service = new AdminUsersService();
        $result = $admin_users_service->login($account, $password);
        
        if ($result == 1) {
            $this->success('登录成功', url('index/index'), '', 1);            
        } elseif ($result == 2) {
            $this->error('此用户已被禁用', null, '', 1);
        }
        $this->error('账号或密码错误', null, '', 1);
    }

    /**
     * 用户退出登录
     */
    public function logout()
    {
        session('user', null);
        $this->success('退出成功', url('login/index'), '', 1);
    }
    
}
