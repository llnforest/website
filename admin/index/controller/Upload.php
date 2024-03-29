<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */
namespace admin\index\controller;

use think\Config;
use think\Request;

class Upload extends BaseController{

	public function __construct()
    {
        // $this->data     = ['pach'=>VIEW_PATH];
        $this->request      = Request::instance();
        $this->param        = $this->request->param();
        $this->post     = $this->request->post();
        $this->id       = isset($this->param['id'])?intval($this->param['id']):'';
        parent::__construct();
    }

    // 上传图片
	public function image(){
		// 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $type = isset($this->param['type'])?$this->param['type']:'';
        if($type == 'info')
            $baseUrl = DS . 'images' . DS . 'info';
        else if($type == 'service')
            $baseUrl = DS . 'images' . DS .'service';
        else if($type == 'cases')
            $baseUrl = DS . 'images' . DS .'cases';
        else if($type == 'partner')
            $baseUrl = DS . 'images' . DS .'partner';
        else if($type == 'contact')
            $baseUrl = DS . 'images' . DS .'contact';
        else if($type == 'product')
            $baseUrl = DS . 'images' . DS .'product';
        else if($type == 'service')
            $baseUrl = DS . 'images' . DS .'service';
        else if($type == 'content')
            $baseUrl = DS . 'images' . DS .'content';
        // 移动到框架应用根目录/public/uploads/ 目录下
        if(in_array($type,['info','service','cases','partner','contact','product','service','content'])){
            $info = $file->validate(['size'=>5*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move(Config::get('upload.path') . DS . $baseUrl);
        }elseif($type == "house"){
            $info = $file->validate(['size'=>5*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->size(200,160)->move(Config::get('upload.path') . DS .  $baseUrl);
        }
        if($info){
            $url = $baseUrl . DS . $info->getSaveName();
            $data = [
                    'code' => 1,
                    'url' => $url,
                    'msg' => lang('sys_upload_success')
                ];
            return json($data);
        }else{
            // 上传失败获取错误信息
            return json(['code' => 0,'msg' =>  $file->getError()]);
        }
	}

	//上传文件
    public function file(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('excelfile');
        $baseUrl = DS . 'file' . DS . 'excel';
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>5*1024*1024,'ext'=>'xlsx'])->move(Config::get('upload.path') . DS . 'uploads' . $baseUrl);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            // echo $info->getExtension();
            // // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getSaveName();
            // // 输出 42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getFilename(); 
            $url = $baseUrl . DS . $info->getSaveName();
            $data = array(
                    'code' => 1,
                    'url' => $url
                );
            return $data;
        }else{
            // 上传失败获取错误信息
            return ['code' => 0,'msg' => $file->getError()];
        }
    }
    public function ueditorimage(){
        $action = isset($this->param['action'])?$this->param['action']:'';
        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(ROOT_PATH."admin/static/admin/ueditor/php/config.json")), true);
        switch ($action) {
            case 'config':
                $result =  $CONFIG;
            break;

            /* 上传图片 */
            case 'uploadimage':
            /* 上传涂鸦 */
            case 'uploadscrawl':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':
                $file = request()->file('upfile');
                $baseUrl = DS . 'images' ;
                $info = $file->validate(['size'=>5*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move(Config::get('upload.path') . DS . 'ueditor' . $baseUrl);
                if($info){
                    // 成功上传后 获取上传信息
                    // 输出 jpg
                    // echo $info->getExtension();
                    // // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                    // echo $info->getSaveName();
                    // // 输出 42a79759f284b767dfcb2a0197904287.jpg
                    // echo $info->getFilename(); 
                    $url = $baseUrl . DS . $info->getSaveName();
                    $result = array(
                            'state'=>'SUCCESS',
                            'url' => Config::get('view_replace_str.__MoblieImage__').$url
                        );
                }else{
                    // 上传失败获取错误信息
                    $result = $file->getError();
                }
                break;

            /* 列出图片 */
            case 'listimage':
                
                break;
            /* 列出文件 */
            case 'listfile':
                
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                
                break;

            default:
                $result = array(
                    'state'=> '请求地址出错'
                );
                break;
        }
        return json($result);
    }


}