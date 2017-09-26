<?php
function api_return($code, $msg, $data)
{
    return ['code' => $code, 'msg' => $msg, 'result' => $data];
}

/**
 * 作用：产生随机字符串，不长于32位
 * @param int $length
 * @return string
 */
function create_nonce_str($length = 32)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * 验证
 * @param $request
 * @return array
 */
function check_token($request)
{
    if ($request->isPost()) {
        $uid = $request->post('uid');
        $token = $request->post('token');
    } elseif ($request->isGet()) {
        $uid = $request->get('uid');
        $token = $request->get('token');
    }

    if (empty($uid) || empty($token)) {
        return api_return(401, '参数错误', null);
    }

    $user_service = new \app\common\service\UserService();
    $result = $user_service->checkToken($uid, $token);

    if (empty($result)) {
        return api_return(9999, '用户未允许或在其他设备登录', null);
    }
}