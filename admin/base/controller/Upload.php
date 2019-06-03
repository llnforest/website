<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace admin\base\controller;


use admin\index\controller\BaseController;
use model\BaseCaseModel;
use think\Config;

class Upload extends BaseController{


    public function index(){
        $orderBy  = 'sort asc';
        $where  = getWhereParam(['a.title'=>'like','a.cate_id'],$this->param);
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];

        $data['list'] = BaseCaseModel::alias('a')
            ->join('tp_base_case_category b','a.cate_id = b.id','left')
            ->where($where)
            ->field('a.*,b.name')
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['cateList'] = BaseCaseCategoryModel::order('sort asc')->select();

        return view('index',$data);
    }


}