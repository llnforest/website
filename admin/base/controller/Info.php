<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */
namespace admin\base\controller;

use admin\index\controller\BaseController;
use model\BaseInfoModel;
use think\Validate;


class Info extends BaseController{

    //构造函数
    public function __construct(){
        parent::__construct();
    }

    //网站管理页
    public function index(){
        $this->id = $this->id ? $this->id : 1;
        $data['info'] = BaseInfoModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            return operateResult($data['info']->save($this->param),'info/index','edit');
        }
        return view('index',$data);
    }


}