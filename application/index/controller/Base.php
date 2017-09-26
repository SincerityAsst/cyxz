<?php namespace app\index\controller;

use think\Controller;

/**
 * API基类
 */
class Base extends Controller
{
    public function _initialize()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host_url = "$protocol$_SERVER[HTTP_HOST]";

        define('HOST_URL', $host_url);
    }
}