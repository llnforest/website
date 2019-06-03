<?php
/**
 * author: Lynn
 * since: 2018/3/23 12:05
 */

if(!function_exists('getYearNum')){
    /**
     * 获取使用年数
     * @param $start_date 2017-12-23 00:00:00
     * @return string 2017-12-23
     */
    function getYearNum($start_date){
        if(!$start_date) return '';
        $end_date = date('Y-m-d',time());
        $startArr = explode('-',$start_date);
        $endArr = explode('-',$end_date);
        if($endArr[2] - $startArr[2] <= 0) $startArr[1] ++;
        if($endArr[1] - $startArr[1] <= 0) $endArr[0] ++;
        $year = $endArr[0] - $startArr[0];
        return $year;
    }
}

if(!function_exists('excelTime')){
    /**
     * 转换excel时间
     * @param $date 2017/03/09
     * @return string 2017-03-09
     */
    function excelTime($date) {
        if (function_exists('GregorianToJD')) {
            if (is_numeric($date)) {
                $jd = GregorianToJD(1, 1, 1970);
                $gregorian = JDToGregorian($jd + intval($date) - 25569);
                $date = explode('/', $gregorian);
                $date_str = str_pad($date[2], 4, '0', STR_PAD_LEFT) . "-" . str_pad($date[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($date[1], 2, '0', STR_PAD_LEFT);
                return $date_str;
            }
        } else {
            $date = $date > 25568 ? $date + 1 : 25569; /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
            $ofs = (70 * 365 + 17 + 2) * 86400;
            $date = date("Y-m-d", ($date * 86400) - $ofs);
        }
        return $date;
    }
}

if(!function_exists('operateResult')){
    /**
     * 操作结果
     * @param boolean $default
     * @param string $url
     * @param string $operate
     * @return array
     */
    function operateResult($default,$url,$operate = 'add'){
        if ($default) {
            return ['code' => 1, 'msg' => lang('sys_'.$operate.'_success'), 'url' => url($url)];
        } else {
            return ['code' => 0, 'msg' => lang('sys_'.$operate.'_error')];
        }
    }
}

if(!function_exists('inputResult')){
    /**
     * 输入框输入结果
     * @param boolean $default
     * @param string $operate
     * @return array
     */
    function inputResult($default,$operate = 'sort'){
        if ($default) {
            return ['code' => 1, 'msg' => lang('sys_'.$operate.'_success')];
        } else {
            return ['code' => 0, 'msg' => lang('sys_'.$operate.'_error'),'text'=>$default[$operate]];
        }
    }
}

if(!function_exists('switchResult')){
    /**
     * switch操作结果
     * @param boolean $default
     * @param string $operate
     * @return array
     */
    function switchResult($default,$operate = 'status'){
        if ($default) {
            return ['code' => 1, 'msg' => lang('sys_'.$operate.'_success')];
        } else {
            return ['code' => 0, 'msg' => lang('sys_'.$operate.'_error')];
        }
    }
}

if(!function_exists('getGgImg')){
    /**
     * 获取广告图片
     * @param int
     * @param int   //是否为背景图片 需要转换url /
     * @return string 
     */
    function getGgImg($id, $change = 0){
        if($id){
            $where['position_id'] = $id;
            $img = Db('tp_base_img')->where($where)->order('sort asc')->column('url');
            if($img){
                if(!empty($change)){
                    $change_img = str_replace('\\', '/', $img[0]);
                    return $change_img;
                }else{
                    return $img[0];
                }
            }else{
                return false;
            }

        }else{
            return false;
        }

    }
}


if(!function_exists('SendMail')) {
    /**
     * [SendMail 邮件发送]
     * @param [type] $address  [description]
     * @param [type] $title    [description]
     * @param [type] $message  [description]
     * @param [type] $from     [description]
     * @param [type] $fromname [description]
     * @param [type] $smtp     [description]
     * @param [type] $username [description]
     * @param [type] $password [description]
     */
    function SendMail($address)
    {
        Loader::import('phpmailer.PHPMailerAutoload');
        //vendor('PHPMailer.class#PHPMailer');
        $mail = new \PHPMailer();
        // 设置PHPMailer使用SMTP服务器发送Email
        $mail->IsSMTP();
        // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->CharSet = 'UTF-8';
        // 添加收件人地址，可以多次使用来添加多个收件人
        $mail->AddAddress($address);

        $data = \think\Db::name('tp_admin_email_config')->where('id', 1)->find();
        $title = $data['title'];
        $message = $data['content'];
        $from = $data['from_email'];
        $fromname = $data['from_name'];
        $smtp = $data['smtp'];
        $username = $data['username'];
        $password = $data['password'];
        // 设置邮件正文
        $mail->Body = $message;
        // 设置邮件头的From字段。
        $mail->From = $from;
        // 设置发件人名字
        $mail->FromName = $fromname;
        // 设置邮件标题
        $mail->Subject = $title;
        // 设置SMTP服务器。
        $mail->Host = $smtp;
        // 设置为"需要验证" ThinkPHP 的config方法读取配置文件
        $mail->SMTPAuth = true;
        //设置html发送格式
        $mail->isHTML(true);
        // 设置用户名和密码。
        $mail->Username = $username;
        $mail->Password = $password;
        // 发送邮件。
        return ($mail->Send());
    }
}

?>
