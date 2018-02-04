<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
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
        $usersModel = D('Users');
        $result = $usersModel->findUserByPhone($phone);
        if($result){
            $data = array("code"=>"201","msg"=>"该手机号已注册过");
            $this->ajaxReturn($data);
        }
        $data_info = array(
            "user_name" => $user_name,
            "phone" => $password,
            "password" => md5($password),
            "create_time" => time()
        );
        $res = $usersModel->addUser($data_info);
        if($res){
            $data = array("code"=>"200","msg"=>"注册成功");
            
        }else{
            $data = array("code"=>"201","msg"=>"注册失败");
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
                $goodsList[$key]['priceList'] = $packageModel->where("goods_id=".$v['goods_id'])->select(); 
            }
            $data  = array("code"=>"200","msg"=>"成功","data"=>$goodsList);
        }else{
            $data = array("code"=>"201","msg"=>"获取失败");
        }
        $this->ajaxReturn($data);
    }
}