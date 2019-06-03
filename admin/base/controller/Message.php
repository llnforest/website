<?php
/**
 * author: Lynn
 * since: 2018/3/23 13:05
 */
namespace admin\base\controller;

use admin\index\controller\BaseController;
use model\BaseMessageModel;
use think\Config;
use think\Validate;


class Message extends BaseController{

    
    //在线留言列表页
    public function index(){
        $orderBy = "sendtime desc";
        if(!empty($this->param['order'])) $orderBy = $this->param['order'].' '.$this->param['by'];
        $where  = getWhereParam(['name'=>'like'],$this->param);
        $data['list'] = BaseMessageModel::where($where)
            ->order($orderBy)
            ->paginate($this->config_page,'',['query'=>$this->param]);
        $data['page']   = $data['list']->render();
        $data['unread_num'] = BaseMessageModel::where("isstate",0)->count();
        return view('index',$data);

    }

     // 删除留言
    public function messageDel(){
        if($this->request->isPost()) {
            $result = BaseMessageModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            
            return operateResult($result->delete(),'message/index','del');
            
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    // 审核留言状态
    public function messageIsstate(){
        if($this->request->isPost()) {
            $result = BaseMessageModel::get($this->id);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            return operateResult($result->save(['isstate' => 1]),'message/index','status');
            
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量删除信息
    public function batchDelMessage(){
        if($this->request->isPost()) {
            $result = BaseMessageModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            $data = BaseMessageModel::destroy($this->param['ids']);
            return operateResult($data,'message/index','del');
        }
        return ['code'=>0,'msg'=>lang('sys_method_error')];
    }

    //批量已读留言
    public function batchReadMessage(){
        if($this->request->isPost()){
            $result = BaseMessageModel::all($this->param['ids']);
            if (empty($result)) return ['code' => 0, 'msg' => lang('sys_param_error')];
            foreach ($this->param['ids'] as $v){
                $data = BaseMessageModel::where('id',$v)->update(['isstate'=>1]);
            }
            return operateResult($data,'message/index','status');
        }
        return ['code'=>0,'msg'=>lang('sys_status_error')];
    }

}