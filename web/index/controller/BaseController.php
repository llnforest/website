<?php
namespace web\index\controller;


use think\Config;
use think\Controller;
use think\Request;
use model\BaseInfoModel;

class BaseController extends Controller
{
    protected $data;
    protected $request;
    protected $param;
    protected $id;
    protected $imgHost;
    //构造函数
    public function __construct()
    {
        $this->request = Request::instance();
        $this->param = $this->request->param();
        $this->list_rows = Config::get('paginate.list_rows');
        $this->id = !empty($this->param['id'])?$this->param['id']:'';
        $this->imgHost = Config::get('upload.img_url');

        if(!Config::get('sys_open')){
            return die(json_encode(['code' =>1001,'msg'=>'系统维护升级中，请稍候再试！']));
        }
        parent::__construct();


        //获取当前控制器 方法
        $request= \think\Request::instance();
        $now_controller=$request->controller();
        $now_action=$request->action();

        $this->assign('now_action',$now_action);  
        $this->assign('now_controller',$now_controller);  

        //网站基本配置信息
        $web_config=BaseInfoModel::where('id',1)->find();
        $this->assign('web_config',$web_config);


    }

}
