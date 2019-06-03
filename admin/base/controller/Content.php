<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace admin\base\controller;

use admin\index\controller\BaseController;
use model\BaseContentCategoryModel;
use model\BaseContentModel;
use model\BaseContentImagesModel;
use think\Config;
use think\Validate;

class Content extends BaseController{

    private $roleValidate = ['title|信息标题' => 'require','img|封面图片' => 'require','sort|排序' => 'number|lt:256'];
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //信息列表页
    public function index(){

        $orderBy  = 'sort asc';
   
        $where  = getWhereParam(['a.title'=>'like','a.cate_id'],$this->param);
        $where['a.mark'] = request()->controller();
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseContentModel::alias('a')
            ->join('tp_base_content_category b','a.cate_id = b.id','left')
            ->where($where)
            ->field('a.*,b.name')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();

        $whe['mark'] = request()->controller();
        $data['cateList'] = BaseContentCategoryModel::order('sort asc')->where($whe)->select();

        return view('index',$data);
 
    }

    //添加信息
    public function contentAdd(){
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);
            if(!$validate->check($this->param)) return ['code' => 0, 'msg' => $validate->getError()];
            $content = BaseContentModel::create($this->param);

            if($content){
                $imgList = json_decode($this->param['img_data'],true);
                if(count($imgList) > 0){
                    foreach($imgList as &$item){
                        $item['content_id'] = $content['id'];
                    }
                    $imgModel = new BaseContentImagesModel();
                    $imgModel->saveAll($imgList);
                }
            }

            return operateResult($content,'content/index','add');
        }
        $whe['mark'] = request()->controller();
        $cateList= BaseContentCategoryModel::order('sort asc')->where($whe)->select();
        $this->assign('cateList',$cateList);
        return view('contentAdd',['now_time'=>$this->now_time]);
    }



    //修改信息
    public function contentEdit(){
        $data['info'] = BaseContentModel::get($this->id);
        if(!$data['info']) $this->error(lang('sys_param_error'));
        if($this->request->isPost()){
            $validate = new Validate($this->roleValidate);

            if(!$validate->check($this->param)) return ['code' => 0,'msg' => $validate->getError()];
            $data['info']->save($this->param);
            BaseContentImagesModel::where(['content_id'=>$this->id])->delete();
            $imgList = json_decode($this->param['img_data'],true);
            if(count($imgList) > 0){
                foreach($imgList as &$item){
                    $item['content_id'] = $this->id;
                }
                $imgModel = new BaseContentImagesModel();
                $imgModel->saveAll($imgList);
            }
          
           return operateResult(true,'content/index','edit');
        }
        $data['imgList'] = BaseContentImagesModel::where(['content_id'=>$this->id])->order('sort asc')->select();
        $whe['mark'] = request()->controller();
        $cateList = BaseContentCategoryModel::order('sort asc')->where($whe)->select();
        //print($cateList);
        $this->assign('cateList',$cateList);
        return view('contentEdit',$data);
    }



    
    // 删除信息
    public function contentDelete(){
        if($this->request->isPost()) {
            $result = BaseContentModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            @unlink(Config::get('upload.path').$result['img']);

            $imgList = BaseContentImagesModel::all(['content_id' => $this->id]);
            foreach ($imgList as $v) {
                @unlink(Config::get('upload.path') . $v['url']);
            }
            BaseContentImagesModel::destroy(['content_id' => $this->id]);
  
            return operateResult($result->delete(),'content/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 排序信息
    public function inputContent(){
        if($this->request->isPost()) {        
            $result = BaseContentModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'sort');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 推荐信息
    public function contentIsgood(){
        if($this->request->isPost()) {
            $result = BaseContentModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = [$this->param['name'] => $this->param['data']];
            return inputResult($result->save($data),'is_good');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量删除信息
    public function batchDelContent(){
        if($this->request->isPost()) {
            $result = BaseContentModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = BaseContentModel::destroy($this->param['ids']);
            foreach ($result as $v) {
                @unlink(Config::get('upload.path') . $v['img']);
            }
            return operateResult($data,'content/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

}