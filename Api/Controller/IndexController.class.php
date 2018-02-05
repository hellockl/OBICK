<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
    const TOKENSTR = 'abc123xyz';
    public function test(){
        echo 'aaa';
    }
    /**
     * 登录     
     */
    public function login(){
        $user_name = "test";
        $password = "123456";
        $usersModel = D('Users');
        $user_info = $usersModel->findUsers($user_name,$password);
        if($user_info){          
            
            $data_info = array(
                "token" => md5(self::TOKENSTR . time()),
                "user_id" =>$user_info['user_id']
            );
            $result = $usersModel->editUsers($data_info);
            if ($result !== FALSE) {
                $data = array("code"=>"200","msg"=>"登录成功","data"=>$data_info['token']);
            }else{
                $data = array("code"=>"201","msg"=>"登录失败");
            }
        }else{
            $data = array("code"=>"201","msg"=>"登录失败");
        }
        $this->ajaxReturn($data);
    }
    
    /**
     * 注册     
     */
    public function register(){
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $code = $_POST['code'];
        $usersModel = D('Users');
        if($code!==M('Mscode')->where("phone=".$phone)->order("create_time desc")->getField('code')){
            $data = array("code"=>"201","msg"=>"验证码错误");
            $this->ajaxReturn($data);
        }
        $result = $usersModel->findUserByPhone($phone);
        if($result){
            $data = array("code"=>"201","msg"=>"该手机号已注册过");
            $this->ajaxReturn($data);
        }

        $data_info = array(
            "user_name" => $user_name,
            "phone" => $phone,
            "password" => md5($password),
            "create_time" => time()
        );
        $res = $usersModel->addUsers($data_info);
        if($res){
            $data = array("code"=>"200","msg"=>"注册成功");
            
        }else{
            $data = array("code"=>"201","msg"=>"注册失败");
        }
        $this->ajaxReturn($data);
    }

    /**
     * 发送短信验证码
     */
    public function sendMs(){
        Vendor('SendMs.ChuanglanSmsApi');
        $clapi  = new \Vendor\SendMs\ChuanglanSmsApi();
        $code = mt_rand(100000,999999);
        $phone = $_POST['phone'];
        if(empty($phone)){
            $data = array("code"=>"201","msg"=>"手机号不能为空");
            $this->ajaxReturn($data);
        }
        $result = $clapi->sendInternational('86'.$phone, '【253云通讯】this is test,Your validation code is '.$code);
        if(!is_null(json_decode($result))){
            $output=json_decode($result,true);
            if(isset($output['code'])  && $output['code']=='0'){
                $data = array("phone"=>$phone,"code"=>$code,"create_time"=>time());
                M("Mscode")->add($data);
                $data = array("code"=>"200","msg"=>"注册成功");
            }else{
                $data = array("code"=>"201","msg"=>$output['error']);
            }
        }else{
            $data = array("code"=>"201","msg"=> $result);;
        }
        $this->ajaxReturn($data);
    }
    
    /**
     * 得到商品列表
     *      
     */
    public function getGoodsList(){
        $type = $_POST['type'];
        $goodsList = M("Goods")->where()->select();
        if($goodsList){
            $packageModel = M('Package');
            foreach ($goodsList as $key=>$v){
                $goodsList[$key]['priceList'] = $packageModel->where("goods_id=".$v['id'])->select();
            }
            $data  = array("code"=>"200","msg"=>"成功","data"=>$goodsList);
        }else{
            $data = array("code"=>"201","msg"=>"获取失败");
        }
        $this->ajaxReturn($data);
    }
}