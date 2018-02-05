<?php
namespace Api\Controller;
use Think\Controller;
use Vendor\SendMs;
//use Api\BaseController;

class ApiController extends Controller {
    const TOKENSTR = 'abc123xyz';
    public function _initialize(){
        self::preLogin();
    }
    
    
    /**
     * 生成订单     
     */
    public function createOrder(){
        $orderModel = D("Order");
        $res = $orderModel->createNewOrder($_POST);
        if($res){
            $data = array("code"=>"200","msg"=>"下单成功",'data'=>$res);
        }else{
            $data = array("code"=>"201","msg"=>"下单失败");
        }
        $this->ajaxReturn($data);
    }
    
    /**
     * 订单详情
     */
    public function orderInfo(){
        $order_id = $_POST['order_id'];
        if(!$order_id){
            $this->ajaxReturn(array('code'=>'201','msg'=>'订单ID不能为空'));
        }
        $orderModel = D('Order');
        $order_info = $orderModel->getOrderInfo($order_id);
        if($order_info){
            $data = array("code"=>"200","msg"=>"成功",'data'=>$order_info);
        }else{
            $data = array("code"=>"201","msg"=>"失败");
        }
        $this->ajaxReturn($data);
    }
    
    /**
     *  编缉订单收货地址     
     */
    public function editAddress(){
        $order_id = $_POST['order_id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $orderModel = D('Order');
        $data_info = array(
            'order_id'=>$order_id,
            'name' =>$name,
            'phone' =>$phone,
            'address'=>$address
        );
        $res = $orderModel->editOrder($data_info);
        if($res !== FALSE){
            $data = array("code"=>"200","msg"=>"成功");
        }else{
            $data = array("code"=>"201","msg"=>"失败");
        }
        $this->ajaxReturn($data);
    }

    

    /**
     * 首次支付
     *      
     */
    public function firstPay(){
        
    }
    
    public function secondPay(){
        
    }

    
    /**
     * 发送短信验证码   
     */
    public function sendMs(){
        Vendor('SendMs.ChuanglanSmsApi');
        $clapi  = new \Vendor\SendMs\ChuanglanSmsApi();
        $code = mt_rand(100000,999999);
        $result = $clapi->sendInternational('8618701881920', '【253云通讯】this is test,Your validation code is '.$code);
        if(!is_null(json_decode($result))){
            $output=json_decode($result,true);
            if(isset($output['code'])  && $output['code']=='0'){
                echo '短信发送成功！' ;
            }else{
                echo $output['error'];
            }
        }else{
            echo $result;
        }
    }
    
    
    static function preLogin() {
        if(empty($_POST['user_id'])){
            $data = array("code"=>'201',"msg"=>"未登录");
            self::ajaxReturn($data);
        }
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