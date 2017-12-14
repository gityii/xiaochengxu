<?php
/**
 * 小程序接口
 */
class XcxapiController extends Controller {

//public  $_CONFIG = array(
//    'db'=>array(
//        'db_host'=>'localhost',
//        'db_port'=>'3306',
//        'db_user'=>'root',
//        'db_pswd'=>'',
//        'db_db'=>'njgongan',
//        'db_prex'=>'njga_',
//    ),
//    'weixin'=>array(
//        'appid'=>'',
//        'appsecret'=>'',
//        'token'=>'',
//        'mchid'=>'1231423302',
//        'mchkey'=>'jssetjjhjssetjjhjssetjjhjssetjjh'
//    ),
//);
//
//    public $secret = '';
//    public $appid ='';
//
//    private static $url_sessionkey = 'https://api.weixin.qq.com/sns/jscode2session';
//
//    public  function session($name,$value=null,$start=true){
//        $return = false;
//        $start && session_start();
//        if ($value!==null){
//            $_SESSION[$name] = $value;
//            $return = true;
//        }else {
//            $return = isset($_SESSION[$name])?$_SESSION[$name]:'';
//        }
//        $start && session_write_close();
//        return $return;
//    }
//
//    //GET方式请求资源
//    public static function urlget($url,$keysArr,$headers=array()){
//        $url = $url."?";
//        $valueArr = array();
//        foreach($keysArr as $key => $val){
//            $valueArr[] = "$key=$val";
//        }
//        $keyStr = implode("&",$valueArr);
//        $url .= ($keyStr);
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        curl_setopt($ch, CURLOPT_URL, $url);
//        if (!empty($headers)){
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
//            curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE );
//        }
//        $response =  curl_exec($ch);
//        curl_close($ch);
//        return $response;
//    }
//
//    public function actionGetsessionkey()
//    {
//        $msg = '';
//        $sessionkey = '';
//        $openid = '';
//        $unionid = '';
//        $code = isset($_GET['code']) ? $_GET['code'] : '';
//        if ($code == '') {
//            echo "NO CODE";
//        } else {
//            $con = self::urlget(self::$url_sessionkey, array(
//                'appid' => $this->appid,
//                'secret' => $this->secret,
//                'js_code' => $code,
//                'grant_type' => 'authorization_code'
//            ));
//
//            if (empty($con)) { //获取结果为空
//                $msg = '获取结果为空';
//            } else {
//                $arr = json_decode($con, true);
//                if (isset($arr['errcode'])) { //获取结果失败
//
//                } else {
//                    $sessionkey = $arr['session_key'];
//                    $openid = $arr['openid'];
//                    $unionid = $arr['unionid'];
//
//                    $third_session = $sessionkey.'_'.$openid;
//
//                    if (Mod::app()->db->createCommand()->insert('t_xcx_sessionkey',array(
//                        'unionid'=>$unionid,
//                        'openid'=>$openid,
//                        '3rd_session'=>$third_session,
//                        'session_time'=>time()
//                    ))){
//                        $msg = '提交成功';
//                    }else {
//                        $msg = '提交失败';
//                    }
//                }
//            }
//        }
//
//        return array(
//            'sessionkey'=>$sessionkey,
//            'openid'=>$openid,
//            'unionid'=>$unionid,
//        );
//    }
//
//
//    public function actionUser($sessionkey='', $openid='')
//    {
//        if ($sessionkey=='' || $openid==''){
//            $info = $this->actionSessionkey();
//            $sessionkey = $info['sessionkey'];
//            $openid = $info['openid'];
//        }
//
//
//
//    }
//
//    public function actionLogin()
//    {
//
//       $third_session = Mod::app()->session['3rd_session'];
//       //首先判断是否有3rd_session
//        if(!empty($third_session))
//        {
//
//        }
//
//    }
//
//
//
//
//
//
//    public function actionBaoliao()
//    {
//
//
//    }
//
//
//
//    public function actionPinglun()
//    {
//
//
//    }
//

    public function actionUser()
    {
        //$nick = Mod::app()->request->getParam('nick','');
        $uin = Mod::app()->request->getParam('uin','');
        $title = Mod::app()->request->getParam('title','');
        $content = Mod::app()->request->getParam('content','');
        $type = Mod::app()->request->getParam('type','');
        $msg = array();

        if ($title==''){
            $msg[0] = 2;
            $msg[1] = '请输入标题';
        }else if (Input::strlen($title)>100){
            $msg[1] = '称呼长度不能超过12个汉字';
        }

//        if ($nick==''){
//            $msg[0] = 2;
//            $msg[1] = '请输入称呼';
//        }else if (Input::strlen($nick)>24){
//            $msg[1] = '称呼长度不能超过12个汉字';
//        }

        if ($uin == '') {
            $msg[0] = 3;
            $msg[1] = '请输入用户uin';
        } else if (Input::strlen($uin) > 50) {
            $msg[1] = '用户uin长度不能超过50个字节';
        }

        if ($content==''){
            $msg[0] = 4;
            $msg[1] = '请输入内容';
        }else if (Input::strlen($content)>4000){
            $msg[1] = '内容长度不能超过2000个汉字';
        }

        if (Mod::app()->db->createCommand()->insert('t_user', array(
           // 'nick' => $nick,
            'uin' => $uin,
            'type' => $type
        ))) {
        } else {
            $msg[0] = 1;
            $msg[1] = '插入失败';
        }


        $sql = 'select `uid` from `t_user` where `uin`=\''.$uin.'\'';
        $data = Mod::app()->db->createCommand($sql)->queryRow();
        $sql1 ='show table status like \'t_content\'';
        $table = Mod::app()->db->createCommand($sql1)->queryRow();
        if (Mod::app()->db->createCommand()->insert('t_content', array(
            'contentid' => $table['Auto_increment'],
           // 'nick' => $nick,
            'uin' => $uin,
            'uid' => $data['uid'],
            'content' => $content,
            'title'=> $title
        ))) {
            echo $table['Auto_increment'];
        } else {
            $msg[0] = 5;
            $msg[1] = '插入失败';
        }
//        if($msg!='')
//        {
//            echo json_encode($msg);
//        }else{
//            echo $table['Auto_increment'];
//        }
    }


    //上传图片
    public function actionUploadImg(){

        $id = 's'.time().rand(1000,9999);
        $msg = '';
        $url = '';
        $name = 'pic';
        $types = 'jpg,jpeg,gif,png,bmp';
        $position = 'assets/upload/'.date('Ymd',time());
        $limit_size = true;
        $filename = '';
        $filename_mark = '';
        $size = 1024;
//        if (empty($this->uid)){
//            $msg = '请先登录再报料';
//        }else {
//            $limit = User::limit($this->uid);
//            if (is_string($limit)){
//                $msg = $limit;
//            }else {
                if (isset($_FILES[$name]["name"]) && $_FILES[$name]["name"]!='' && $_FILES[$name]["size"]>0){
                    if ($_FILES[$name]["error"] > 0){
                        $msg = '请选择要上传的图片';
                    }else {
                        if (!is_dir($position) && !mkdir($position,0755,true)){
                            $msg = '上传失败';
                        }
                        $type = pathinfo($_FILES[$name]["name"],PATHINFO_EXTENSION);
                        if ($msg=='' && !in_array(strtolower($type),explode(',',strtolower($types)))){
                            $msg = '图片格式有误，允许图片格式：'.$types;
                            @unlink($_FILES[$name]["tmp_name"]);
                        }
                        if ($msg=='' && $limit_size){
                            $filesize = ceil($_FILES[$name]["size"]/1024);
                            if ($filesize>$size){
                                $msg = '图片大小不能超过1M';
                            }
                        }
                        if ($filename==''){
                            $filename = date('YmdHis',time()).rand(0,999).'.'.$type;
                            $filename_mark = date('YmdHis',time()).rand(0,999).'_mark';
                        }
                        if ($msg=='') {
                            if (!move_uploaded_file($_FILES[$name]["tmp_name"],$position.'/'.$filename)){
                                $msg = '图片上传失败，请重新选择';
                            }
//                            else {
//                                $file = $position.'/'.$filename;
//                                $markfile = Image::watermark($file,'static/images/mark.png',$position.'/'.$filename_mark);
//                                if ($markfile!=''){
//                                    $obj = Mod::app()->CWaeStore;
//                                    $re = $obj->fileUploadByName($markfile);
//                                    if (is_string($re)){
//                                        $url = $re;
//                                        @unlink($file);
//                                    }else {
//                                        $msg = '上传失败（'.$re.'）';
//                                    }
//                                }else {
//                                    $msg = '上传失败。';
//                                }
//                            }
                        }
                    }
                }else {
                    $msg = '请选择要上传的图片';
                }
            }
//        }
//        $this->renderPartial('upload',array(
//            'id'=>$id,
//            'msg'=>$msg,
//            'url'=>$url
//        ));
//    }

}