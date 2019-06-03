<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace admin\base\controller;


use admin\index\controller\BaseController;
use model\BaseImgPositionModel;
use model\BaseImgModel;
use think\Validate;


class ImgPosition extends BaseController{

    private $roleValidate = ['name|广告位置名称' => 'require','sort|排序'=>'number|lt:256'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //图片位置分类列表页
    public function index(){
        $orderBy  = 'sort asc';
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseImgPositionModel::order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        return view('index',$data);
    }

    //添加图片位置分类
    public function positionAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            return operateResult(BaseImgPositionModel::create($this->param),'imgPosition/index','add');
        }
        return view('positionAdd');
    }

    //修改图片位置分类
    public function positionEdit(){
        $data['info'] = BaseImgPositionModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            return operateResult($data['info']->save($this->param),'imgPosition/index','edit');
        }
        return view('positionEdit',$data);
    }

    // 删除图片位置分类
    public function positionDelete(){
        if($this->request->isPost()) {
            $result = BaseImgPositionModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            if(empty(BaseImgModel::get(['position_id' => $this->id])))
                return operateResult($result->delete(),'imgPosition/index','del');
            else return ['code' => 0,'msg' => '该图片位置分类已经应用，不能删除'];
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

     // 排序图片分类
    public function inputPosition(){
        if($this->request->isPost()) {
            $result = BaseImgPositionModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'sort');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }
    //批量删除信息
    public function batchDelPosition(){
        if($this->request->isPost()) {
            $result = BaseImgPositionModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $temp = BaseImgModel::where('position_id','in',$this->param['ids'])->select()->toarray();
            if(empty($temp)){
                $data = BaseImgPositionModel::destroy($this->param['ids']);
                return operateResult($data,'imgPosition/index','del');
            }else{
                return ['code' => 0,'msg' => '该广告位置已经应用，不能删除'];
            }

        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }


}