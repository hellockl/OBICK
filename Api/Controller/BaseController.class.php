<?php
namespace Api;
use Think\Controller;

class BaseController extends Controller
{
    static function preLogin() {
    
        $appinfo = self::checkSign($_POST);
        if ($appinfo == null) {
            return self::needLogin();
        }
        return true;
    }

    static function checkSign($content) {        
        $str = '';
        $str .= "user_id:".$content['user_id']."time_stamp:".$content['time_stamp']."token:";
        $usersModel = D("Users");
        $str.= $usersModel->where("user_id=".$content['user_id'])->getField("token");      
        if ($content['token'] == md5($str)) {
            return true;
        } else {
            return null;
        }
    }


    static function needLogin() {
        $data = array("code"=>'201',"msg"=>"未登录");
        self::ajaxReturn($data);
    }
}