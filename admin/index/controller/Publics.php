<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */
namespace admin\index\controller;

use think\Cache;
use think\Controller;
use think\Db;
use thinkcms\auth\Auth;
use model\AdminModel;


class Publics extends Controller
{
    private $post;

    public function __construct(\think\Request $request)
    {
        parent::__construct($request);
        $this->post = $request->post();
        $this->request = $request;
    }

    /**
     * 登入
     */
    //登录
    public function login(){
        if($this->request->isGet()){
            return view('publics/login');
        }else{
            $userInfo = AdminModel::where(['name'=>$this->post['name'],'password'=>md5($this->post['password']),'status'=>1])->find();
            if(!empty($userInfo)){
                Auth::login($userInfo);
                //手动加入日志
                $auth = new Auth();
                $auth->createLog("管理员{$userInfo['nick_name']}登录后台",'后台登录');
                AdminModel::where(['id'=>$userInfo['id']])->update(['last_login_ip'=>$this->request->ip(),'last_login_time'=>date("Y-m-d H:i:s",time())]);
                return ['code' => 0];
            }else{
                return ['code' => 1];
            }
        }
    }
    /**
     * 退出视图
     */
    public function logout()
    {
        Auth::logout();
        $this->redirect('publics/login');
    }

    public function crontab(){
        Cache::set('a',date('Y-m-d H:i:s'));
    }

    /**
     * 清空缓存
     */
    public function clear(){
        Cache::clear();

        echo lang('sys_cache_clear');
    }
}
