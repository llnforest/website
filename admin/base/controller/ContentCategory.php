<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace admin\base\controller;


use admin\index\controller\BaseController;
use model\BaseContentCategoryModel;
use model\BaseContentModel;
use model\BaseMarkModel;
use think\Validate;


class ContentCategory extends BaseController{

    private $roleValidate = ['name|分类名称' => 'require','sort|排序'=>'number|lt:256'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //信息分类列表页
    public function index(){
        $orderBy  = 'sort asc';
        $where  = getWhereParam(['a.name'=>'like','a.mark'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseContentCategoryModel::alias('a')
            ->join('tp_base_mark b','a.mark = b.mark','left')
            ->where($where)
            ->field('a.*,b.title')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['markList'] = BaseMarkModel::order('sort asc')->select();

        return view('index',$data);
    }

    //添加信息分类
    public function categoryAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            return operateResult(BaseContentCategoryModel::create($this->param),'contentCategory/index','add');
        }
        $data['markList'] = BaseMarkModel::order('sort asc')->select();
        return view('categoryAdd',$data);
    }

    //修改信息分类
    public function categoryEdit(){
        $data['info'] = BaseContentCategoryModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            return operateResult($data['info']->save($this->param),'contentCategory/index','edit');
        }
        $data['markList'] = BaseMarkModel::order('sort asc')->select();
        return view('categoryEdit',$data);
    }

    // 删除信息分类
    public function categoryDelete(){
        if($this->request->isPost()) {
            $result = BaseContentCategoryModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            if(empty(BaseContentModel::get(['cate_id' => $this->id])))
                return operateResult($result->delete(),'contentCategory/index','del');
            else return ['code' => 0,'msg' => '该信息分类已经应用，不能删除'];
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 排序信息分类
    public function inputCategory(){
        if($this->request->isPost()) {
            $result = BaseContentCategoryModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'sort');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量删除信息
    public function batchDelCategory(){
        if($this->request->isPost()) {
            $result = BaseContentCategoryModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $temp = BaseContentModel::where('cate_id','in',$this->param['ids'])->select()->toarray();
            if(empty($temp)){
                $data = BaseContentCategoryModel::destroy($this->param['ids']);
                return operateResult($data,'contentCategory/index','del');
            }else{
                return ['code' => 0,'msg' => '该信息分类已经应用，不能删除'];
            }

        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

}