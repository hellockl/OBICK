<?php
namespace Index\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        
        $goods_list = M("Goods")->where($where)->order("create_time desc")->limit(6)->select();
        
        $guest_list = M("Guest")->where($where)->order("create_time asc")->limit(6)->select();

        $news_list = M("News")->where()->order("create_time asc")->limit(2)->select();

        $partner_list = M("Partner")->where()->order("create_time asc")->limit(6)->select();
        $this->assign("type",$type);
        $this->assign("goods_list",$goods_list);
        $this->assign("guest_list",$guest_list);
        $this->assign("news_list",$news_list);
        $this->assign("partner_list",$partner_list);
        $this->display();
    }
    
    public function exhibition(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        $info_arr = array();
        if($type){
            $where = "type=".$type;//展会
            if($type==1){
                $where_a = "id=2";
            }else if($type==2){
                $where_a = "id=3";
            }else{
                $where_a = "id=1";
            }
            $list = M("Exhibition")->where($where_a)->select();
            
        }else{
            $where = "is_index=1";//首页显示
            $where_a = "id=1";
            $list = M("Exhibition")->where("id!=1")->select();
        }
        $this->assign("type",$type);
        $activity_list = M("Activity")->where($where)->order("create_time asc")->limit(6)->select();
        $partner_list =  M("Partner")->where($where)->order("create_time asc")->limit(6)->select();
        $exhibition_info = M("Exhibition")->where($where_a)->find();
        $this->assign("list",$list);
        $this->assign("exhibition_info",$exhibition_info);
        $this->assign("activity_list",$activity_list);
        $this->assign("partner_list",$partner_list);
        
        $this->display();
    }
    
    public function experience(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        $this->assign("type",$type);
        $this->display();
    }
    
    public function goods(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        $category = isset($_GET['type'])?$_GET['type']:"";
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        if($category){
            $where .=" AND category=".$category;
        }
        $category = M("GoodsCategory")->where()->select();
        $this->assign("category",$category);
        $this->assign("type",$type);
        $count      = M("Goods")->where($where)->count();
        $page       = new \Think\Page($count,6);
        $show       = $page->show();
        $goods_list = M("Goods")->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        //$goods_list = M("Goods")->where($where)->order("create_time desc")->limit(6)->select();
        $this->assign("page",$show);
        $this->assign("goods_list",$goods_list);
        $this->display();
    }
    public function goods_detail(){
        $this->display();
    }


    
    public function guest(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        $this->assign("type",$type);
        $count      = M("Guest")->where($where)->count();
        $page       = new \Think\Page($count,6);
        $show       = $page->show();
        $guest_list = M("Guest")->where($where)->order("create_time asc")->limit(6)->select();
        //$activity_list = M("Activity")->where()->order("create_time asc")->limit(5)->select();
        //$this->assign("activity_list",$activity_list);
        $this->assign("page",$show);
        $this->assign("guest_list",$guest_list);
        $this->display();
    }
    public function guest_detail(){
        $this->display();
    }
    
    public function information(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        $this->assign("type",$type);
        $this->display();
    }
}