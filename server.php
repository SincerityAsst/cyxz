<?php
include __DIR__ . '/vendor/autoload.php'; // 引入 composer 入口文件
use EasyWeChat\Foundation\Application;
$options = [
    'debug'  => true,
    'app_id' => 'wxbb639d0d7dbe4a79',
    'secret' => 'e07a24bbe8952a3977b14e62232fa914',
    'token'  => 'cyxz',
    // 'aes_key' => null, // 可选
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log', // XXX: 绝对路径！！！！
    ],
    //...
];
$app = new Application($options);

$app->server->setMessageHandler(function ($message) {
    return "http://cyxz.tagee.cc/";
});

$response = $app->server->serve();
// 将响应输出
$response->send(); // Laravel 里请使用：return $response;