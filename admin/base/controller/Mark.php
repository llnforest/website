<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */
namespace admin\base\controller;

use admin\index\controller\BaseController;
use model\BaseMarkModel;
use think\Config;
use think\Validate;


class Mark extends BaseController{
    private $roleValidate = ['title|标识名称' => 'require','mark|标识' => 'require','sort|排序' => 'number|lt:256'];
    //构造函数
    public function __construct(){
        parent::__construct();
    }

    //分类标识列表页
    public function index(){
        $orderBy  = 'sort asc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseMarkModel::order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加分类标识
    public function markAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            return operateResult(BaseMarkModel::create($this->param),'mark/index','add');
        }
        return view('markAdd');
    }

    //修改分类标识
    public function markEdit(){
        $data['info'] = BaseMarkModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            return operateResult($data['info']->save($this->param),'mark/index','edit');
        }
        return view('markEdit',$data);
    }

    // 删除分类标识
    public function markDelete(){
        if($this->request->isPost()) {
            $result = BaseMarkModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            return operateResult($result->delete(),'mark/index','del');

        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 排序分类标识
    public function inputMark(){
        if($this->request->isPost()) {
            $result = BaseMarkModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'sort');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量删除信息
    public function batchDelMark(){
        if($this->request->isPost()) {
            $result = BaseMarkModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = BaseMarkModel::destroy($this->param['ids']);
            return operateResult($data,'mark/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

}