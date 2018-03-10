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
        $name = $_POST['name'];//收货人姓名
        $phone = $_POST['phone'];//收货人姓名
        $address = $_POST['address'];//收货人姓名
        $name = $_POST['name'];//收货人姓名
        $user_id = $_POST['user_id'];
        $pay_type = 1;
        $pay_account = $_POST['pay_account'];
        $goodsList = $_POST['goods_list'];
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
     * 我的订单列表
     *
     */
    public function myOrderList(){
        $user_id = $_POST['user_id'];
        $order_list = D("Order")->getOrderListByUserId($user_id);
        if($order_list){
            $data = array("code"=>"200","msg"=>"成功","data"=>$order_list);
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