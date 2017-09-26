<?php
/**
 * Created by PhpStorm.
 * User: pgz
 * Date: 2017/9/22
 * Time: 15:10
 */

namespace app\admin\controller;

use think\Request;
use app\common\service\ExpressReplaceService;

class ExpressReplace extends Base
{
    private $service;

    public function _initialize(){
        parent::_initialize();
        $this->service = new ExpressReplaceService();
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = $this->service->selectWithPage();

        return $this->fetch('index', compact('list'));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $info = $this->service->selectById($id);

        if (empty($info)) {
            $this->error('数据不存在', null, '', 1);
        }

        return $this->fetch('edit', compact('info'));
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->isPost()) {
            $input = $request->param();

            $res = $this->service->edit($input);
            if ($res) {
                $this->success('修改成功', url('index'), '', 1);
            }
            $this->error('修改失败');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $result = $this->service->remove($id);

        if ($result) {
            $this->success('删除成功', null, '', 1);
        }

        $this->error('删除失败');
    }

}