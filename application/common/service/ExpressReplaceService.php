<?php
/**
 * Created by PhpStorm.
 * User: pgz
 * Date: 2017/9/22
 * Time: 14:50
 */

namespace app\common\service;


use app\common\model\ExpressReplace;

class ExpressReplaceService
{
    /**
     * 分页列表
     */
    public function selectWithPage()
    {
        $model = new ExpressReplace();
        $data = $model->order('created_at desc')->paginate(config('paginate.list_rows'));
        return $data;
    }


    /**
     * 添加
     */
    public function store($data)
    {
        $insert_data = [
             'user_id' => isset($data['user_id']) ? $data['user_id'] : '',
            'receiver_name' => isset($data['receiver_name']) ? $data['receiver_name'] : '',
            'receiver_phone' => isset($data['receiver_phone']) ? $data['receiver_phone'] : '',
            'receiver_address' => isset($data['receiver_address']) ? $data['receiver_address'] : '',
            'express_name' => isset($data['express_name']) ? $data['express_name'] : '',
            'take_code' => isset($data['take_code']) ? $data['take_code'] : '',
            'take_time' => isset($data['take_time']) ? $data['take_time'] : '',
            'weight_type' => isset($data['weight_type']) ? $data['weight_type'] : '',
            'reward' => isset($data['reward']) ? $data['reward'] : '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s') ,
            'status' => isset($data['status']) ? $data['status'] : ''
        ];

        $model = new ExpressReplace();
        return $model->insertGetId($insert_data);
    }

    /**
     * 编辑
     */
    public function edit($data)
    {
        $update_data = [            
            'receiver_name' => isset($data['receiver_name']) ? $data['receiver_name'] : '',
            'receiver_phone' => isset($data['receiver_phone']) ? $data['receiver_phone'] : '',
            'receiver_address' => isset($data['receiver_address']) ? $data['receiver_address'] : '',
            'express_name' => isset($data['express_name']) ? $data['express_name'] : '',
            'take_code' => isset($data['take_code']) ? $data['take_code'] : '',
            'take_time' => isset($data['take_time']) ? $data['take_time'] : 0,
            'weight_type' => isset($data['weight_type']) ? $data['weight_type'] : 0,
            'reward' => isset($data['reward']) ? $data['reward'] : '',            
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $map = [
            'id' => $data['id']
        ];

        $model = new ExpressReplace();
        return $model->where($map)->update($update_data);
    }

    /**
     * 获取数据
     */
    public function selectById($id)
    {
        $map = [
            'id' => $id
        ];
        $model = new ExpressReplace();
        $info = $model->where($map)->find();
        return $info;
    }

    /**
     * 删除
     */
    public function remove($id)
    {
        $model = new ExpressReplace();
        $map = [
            'id' => $id
        ];
        return $model->where($map)->delete();
    }

}