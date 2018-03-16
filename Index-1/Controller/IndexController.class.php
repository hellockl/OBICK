<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $goods_list = M("Goods")->where()->order("create_time desc")->limit(6)->select();

        $guest_list = M("Guest")->where()->order("create_time desc")->limit(6)->select();

        $news_list = M("Goods")->where()->order("create_time desc")->limit(2)->select();
        $this->assign("goods_list",$goods_list);
        $this->assign("guest_list",$guest_list);
        $this->assign("news_list",$news_list);
        $this->display();
    }
    
    public function exhibition(){
        $this->display();
    }
    
    public function experience(){
        $this->display();
    }
    
    public function goods(){
        $this->display();
    }
    
    public function guest(){
        $this->display();
    }
    
    public function information(){
        $this->display();
    }
}