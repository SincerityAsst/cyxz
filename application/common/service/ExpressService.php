<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\Express;

/**
 * 快递
 */
class ExpressService
{

    /**
     * 分页列表
     */
    public function selectWithPage()
    {
        $model = new Express();
        $data = $model->order('created_at desc')->paginate(config('paginate.list_rows'));
        return $data;
    }

    /**
     * 添加
     */
    public function store($data)
    {
        $insert_data = [
            'user_id' => isset($data['user_id']) ? $data['user_id'] : 0,            
            'goods_name' => isset($data['goods_name']) ? $data['goods_name'] : '',
            'weight_type' => isset($data['weight_type']) ? $data['weight_type'] : 0,
            'sender_address_id' => isset($data['sender_address_id']) ? $data['sender_address_id'] : null,
            'sender_name' => isset($data['sender_name']) ? $data['sender_name'] : '',            
            'sender_phone' => isset($data['sender_phone']) ? $data['sender_phone'] : '',
            'sender_address' => isset($data['sender_address']) ? $data['sender_address'] : '',
            'receiver_address_id' => isset($data['receiver_address_id']) ? $data['receiver_address_id'] : null,
            'receiver_name' => isset($data['receiver_name']) ? $data['receiver_name'] : '',            
            'receiver_phone' => isset($data['receiver_phone']) ? $data['receiver_phone'] : '',
            'receiver_address' => isset($data['receiver_address']) ? $data['receiver_address'] : '',    
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $model = new Express();
        return $model->insertGetId($insert_data);
    }

    /**
     * 编辑     
     */
    public function edit($data)
    {
        $update_data = [            
            // 'user_id' => isset($data['user_id']) ? $data['user_id'] : 0,            
            'goods_name' => isset($data['goods_name']) ? $data['goods_name'] : '',
            'weight_type' => isset($data['weight_type']) ? $data['weight_type'] : 0,
            'sender_address_id' => isset($data['sender_address_id']) ? $data['sender_address_id'] : null,
            'sender_name' => isset($data['sender_name']) ? $data['sender_name'] : '',            
            'sender_phone' => isset($data['sender_phone']) ? $data['sender_phone'] : '',
            'sender_address' => isset($data['sender_address']) ? $data['sender_address'] : '',
            'receiver_address_id' => isset($data['receiver_address_id']) ? $data['receiver_address_id'] : null,
            'receiver_name' => isset($data['receiver_name']) ? $data['receiver_name'] : '',            
            'receiver_phone' => isset($data['receiver_phone']) ? $data['receiver_phone'] : '',
            'receiver_address' => isset($data['receiver_address']) ? $data['receiver_address'] : '',                
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $map = [
            'id' => $data['id']
        ];

        $model = new Express();
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
        $model = new Express();
        $info = $model->where($map)->find(); 
        return $info;
    }

    /**
     * 删除
     */
    public function remove($id)
    {
        $model = new Express();
        $map = [
            'id' => $id
        ];
        return $model->update($update_data);
    }
}