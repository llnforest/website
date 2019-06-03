<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace admin\base\controller;


use admin\index\controller\BaseController;
use model\BaseImgPositionModel;
use model\BaseImgModel;
use think\Config;
use think\Validate;


class Img extends BaseController{

    private $roleValidate = ['title|广告标题' => 'require','position_id|位置分类' => 'require','url|封面图片'=>'require','sort|排序'=>'number|lt:256'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //图片列表页
    public function index(){
        $orderBy  = 'sort asc';
        $where  = getWhereParam(['a.title'=>'like','a.position_id'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseImgModel::alias('a')
            ->join('tp_base_img_position b','a.position_id = b.id','left')
            ->where($where)
            ->field('a.*,b.name')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['cateList'] = BaseImgPositionModel::select();

        return view('index',$data);
    }

    //添加图片
    public function imgAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            return operateResult(BaseImgModel::create($this->param),'img/index','add');
        }
        $data['cateList'] = BaseImgPositionModel::order('sort asc')->select();
        return view('imgAdd',$data);
    }

    //修改图片
    public function imgEdit(){
        $data['info'] = BaseImgModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            return operateResult($data['info']->save($this->param),'img/index','edit');
        }
        $data['cateList'] = BaseImgPositionModel::order('sort asc')->select();
        return view('imgEdit',$data);
    }

    // 删除图片
    public function imgDelete(){
        if($this->request->isPost()) {
            $result = BaseImgModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            @unlink(Config::get('upload.path').$result['url']);
            return operateResult($result->delete(),'img/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 排序图片
    public function inputImg(){
        if($this->request->isPost()) {
            $result = BaseImgModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'sort');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量删除信息
    public function batchDelImg(){
        if($this->request->isPost()) {
            $result = BaseImgModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = BaseImgModel::destroy($this->param['ids']);
            return operateResult($data,'img/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }


}