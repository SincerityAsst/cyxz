<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use GuzzleHttp\Client;
use EasyWeChat\Foundation\Application;
use app\common\service\UserService;

class Index extends Base
{

    public function index1()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    public function index(){
    	//初始化微信配置
    	$options = config('wx');
    	$app = new Application($options);    	
    	//微信授权
    	$response = $app->oauth->scopes(['snsapi_userinfo'])->redirect();
		$response->send();
    }

    //微信授权回调页
    public function oauth_callback(){
    	$config = config('wx');
    	$app = new Application($config);
		$oauth = $app->oauth;
		// 获取 OAuth 授权结果用户信息
		$user = $oauth->user();
		// echo "getId = ".$user->getId().'<br/>';
		// echo "getNickname = ".$user->getNickname().'<br/>';
		// echo "getName = ".$user->getName().'<br/>';
		// echo "getAvatar = ".$user->getAvatar().'<br/>';		
		// echo "getToken = ".$user->getToken().'<br/>';

		// var_dump($user);

		$service = new UserService();
		$login_user = $service->selectByOpenid($user->getId());

		//注册用户
		if (!$login_user) {			
			$user_data = array();
			$user_data['openid'] = $user->getId();
			$user_data['nickname'] = $user->getNickname();
			$user_data['avatar'] = $user->getAvatar();		
			$user_id = $service->register($user_data);
		}

		//登录用户
		$res = $service->login($user->getId());
		if ($res) {
			$this->redirect('User/index');
		}else{
			$this->error('登录失败，请退出页面重试');
		}
    }

    //获取accessToken
	private function getAccessToken(){
		$appid = config('wx_app_id');
    	$secret = config('wx_secret');
    	// $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret';
    	$client = new Client();
    	$response = $client->request('GET', 'https://api.weixin.qq.com/cgi-bin/token?', [
		    'query' => 
		    [
		    	'grant_type' => 'client_credential',		    	
		    	'appid' => $appid,		    	
		    	'secret' => $secret,		    	
		    ]
		]);
    	$body = $response->getBody();
		$json = json_decode($body);
		return $json->access_token;
	}    
}
