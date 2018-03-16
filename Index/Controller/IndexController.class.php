<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $goods_list = M("Goods")->where()->order("create_time desc")->limit(6)->select();

        $guest_list = M("Guest")->where()->order("create_time asc")->limit(6)->select();

        $news_list = M("News")->where()->order("create_time asc")->limit(2)->select();

        $partner_list = M("Partner")->where()->order("create_time asc")->limit(6)->select();

        $this->assign("goods_list",$goods_list);
        $this->assign("guest_list",$guest_list);
        $this->assign("news_list",$news_list);
        $this->assign("partner_list",$partner_list);
        $this->display();
    }
    
    public function exhibition(){
        $activity_list = M("Activity")->where()->order("create_time asc")->limit(5)->select();
        $this->assign("activity_list",$activity_list);
        $this->display();
    }
    
    public function experience(){
        $this->display();
    }
    
    public function goods(){
        $goods_list = M("Goods")->where()->order("create_time desc")->limit(6)->select();
        $this->assign("goods_list",$goods_list);
        $this->display();
    }
    
    public function guest(){
        $guest_list = M("Guest")->where()->order("create_time asc")->limit(6)->select();
        $activity_list = M("Activity")->where()->order("create_time asc")->limit(5)->select();
        $this->assign("activity_list",$activity_list);
        $this->assign("guest_list",$guest_list);
        $this->display();
    }
    
    public function information(){
        $this->display();
    }
}