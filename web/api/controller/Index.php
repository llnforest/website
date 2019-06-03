<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace web\api\controller;

use model\BaseCaseModel;


class Index extends BaseController{

    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //案例列表
    public function caseList(){
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $where = empty($this->param['cate_id'])?[]:['cate_id'=>$this->param['cate_id']];

        $data['list'] = BaseCaseModel::where($where)
            ->order('sort asc')
            ->limit(($page-1) * 6,6)
            ->select();
        foreach($data['list'] as $v){
            $v['url'] = str_replace('\\','/',$v['url']);
        }
        if(!empty($this->param['is_cate'])){
            $count = BaseCaseModel::where($where)->count();
            $data['total'] = ceil($count/6);
        }
        return json(['code'=>1,'data'=>$data]);
    }

}