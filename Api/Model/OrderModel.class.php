<?php
namespace Api\Model;

class OrderModel extends BaseModel
{
    protected $tableName = 'order';
    
    public function createNewOrder($data){
        $data['create_time'] = time();
        $data['order_sn'] = date("YmdHis").rand(1000, 9999);
        
        return $this->add($data);
        
    }
    
    public function getOrderInfo($order_id){
        $where = array(
            'order_id'     => $order_id,         
        );
        return $this->where($where)->find();
    }

    public function getOrderListByUserId($user_id){
        $where = array(
            'user_id'     => $user_id,
        );
        return $this->where($where)->select();
    }
    
    
}