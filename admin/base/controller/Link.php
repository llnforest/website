<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */
namespace admin\base\controller;

use admin\index\controller\BaseController;
use model\BaseLinkModel;
use think\Config;
use think\Validate;


class Link extends BaseController{
    private $roleValidate = ['name|网站名称' => 'require','linkurl|网站地址' => 'require','sort|排序' => 'number|lt:256'];
    //构造函数
    public function __construct(){
        parent::__construct();
    }

    //友情链接列表页
    public function index(){
        $orderBy  = 'sort asc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseLinkModel::order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加友情链接
    public function linkAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            return operateResult(BaseLinkModel::create($this->param),'link/index','add');
        }
        return view('linkAdd');
    }

    //修改友情链接
    public function linkEdit(){
        $data['info'] = BaseLinkModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            return operateResult($data['info']->save($this->param),'link/index','edit');
        }
        return view('linkEdit',$data);
    }

    // 删除友情链接
    public function linkDelete(){
        if($this->request->isPost()) {
            $result = BaseLinkModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            return operateResult($result->delete(),'link/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 排序友情链接
    public function inputLink(){
        if($this->request->isPost()) {
            $result = BaseLinkModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'sort');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量删除信息
    public function batchDelLink(){
        if($this->request->isPost()) {
            $result = BaseLinkModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = BaseLinkModel::destroy($this->param['ids']);
            return operateResult($data,'link/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }
}