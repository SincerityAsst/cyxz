<?php namespace app\common\service;

use app\common\entity\CommonEntity;
use app\common\model\Address;

/**
 * 地址
 */
class AddressService
{

    /**
     * 分页列表
     */
    public function selectWithPage()
    {
        $model = new Address();
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
            'name' => isset($data['name']) ? $data['name'] : '',
            'phone' => isset($data['phone']) ? $data['phone'] : '',
            'province' => isset($data['province']) ? $data['province'] : '',
            'city' => isset($data['city']) ? $data['city'] : '',
            'area' => isset($data['area']) ? $data['area'] : '',
            'detail_address' => isset($data['detail_address']) ? $data['detail_address'] : '',
            'is_send' => isset($data['is_send']) ? $data['is_send'] : 0,            
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $model = new Address();
        return $model->insertGetId($insert_data);
    }

    /**
     * 编辑     
     */
    public function edit($data)
    {
        $update_data = [            
            // 'user_id' => isset($data['user_id']) ? $data['user_id'] : 0,
            'name' => isset($data['name']) ? $data['name'] : '',
            'phone' => isset($data['phone']) ? $data['phone'] : '',
            'province' => isset($data['province']) ? $data['province'] : '',
            'city' => isset($data['city']) ? $data['city'] : '',
            'area' => isset($data['area']) ? $data['area'] : '',
            'detail_address' => isset($data['detail_address']) ? $data['detail_address'] : '',
            // 'is_send' => isset($data['is_send']) ? $data['is_send'] : 0,                        
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $map = [
            'id' => $data['id']
        ];

        $model = new Address();
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
        $model = new Address();
        $info = $model->where($map)->find(); 
        return $info;
    }

    /**
     * 删除
     */
    public function remove($id)
    {
        $model = new Address();
        $map = [
            'id' => $id
        ];
        return $model->update($update_data);
    }
}