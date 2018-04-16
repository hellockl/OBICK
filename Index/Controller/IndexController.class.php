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

        $news_list = M("News")->where($where." AND category=1")->order("create_time asc")->limit(2)->select();

        $partner_list = M("Partner")->where()->order("create_time asc")->limit(6)->select();
        
        $banner_list = M("Banner")->where($where." AND position=0")->order()->limit(3)->select();
        $this->assign("banner_list",$banner_list);
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
        $category = isset($_GET['category'])?$_GET['category']:1;
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        $banner_list = M("Banner")->where("position=1")->limit(1)->select();
        $this->assign("banner_list",$banner_list);
        $where .= " AND category=".$category;
        $count      = M("News")->where($where)->count();
        $page       = new \Think\Page($count,4);
        $show       = $page->show();
        $news_list = M("News")->where($where)->select();
        foreach ($news_list as $key=>$val){
            $news_list[$key]['content'] = htmlspecialchars_decode($val['content']);
        }
        $this->assign("category",$category);
        $this->assign("news_list",$news_list);
        $this->assign("type",$type);
        $this->assign("page",$show);
        $this->display();
    }
    
    public function goods(){
        $type = isset($_GET['type'])?$_GET['type']:"";
        $is_limit = isset($_GET['n'])?$_GET['n']:0;
        
        $category = isset($_GET['category'])?$_GET['category']:"";
        if($type){
            $where = "type=".$type;//展会
        }else{
            $where = "is_index=1";//首页显示
        }
        $where .= " AND is_limit=".$is_limit;
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
//        foreach ($goods_list as $key=>$val){
//            $goods_list[$key]['content'] = htmlspecialchars_decode($val['content']);
//        }
        //$goods_list = M("Goods")->where($where)->order("create_time desc")->limit(6)->select();
        $this->assign("is_limit",$is_limit);
        $this->assign("page",$show);
        $this->assign("goods_list",$goods_list);
        $this->display();
    }
    public function goods_detail(){
        $id = $_GET['id'];
        $type = isset($_GET['type'])?$_GET['type']:"";
        if(!$id){
            $this->error("页面错误");
        }
        $goods_info = M("Goods")->where("id=".$id)->find();
        $this->assign("type",$type);
        $goods_info['content'] = htmlspecialchars_decode($goods_info['content']);
        $this->assign("goods_info",$goods_info);
        $this->display();
    }


    
    public function guest(){
        $type = isset($_GET['type'])?$_GET['type']:0;
        $n = isset($_GET['n'])?$_GET['n']:1;
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
        $id = $type + 1;
        $schedule = M("Exhibition")->where("id=".$id)->getField("schedule");
        //echo M("Exhibition")->getLastSql();
        //$activity_list = M("Activity")->where()->order("create_time asc")->limit(5)->select();
        //$this->assign("activity_list",$activity_list);
        $this->assign("page",$show);
        $this->assign("n",$n);
        $this->assign("schedule",htmlspecialchars_decode($schedule));
        $this->assign("guest_list",$guest_list);
        $this->display();
    }
    public function guest_detail(){
        $id = $_GET['id'];
        $type = isset($_GET['type'])?$_GET['type']:"";
        if(!$id){
            $this->error("页面错误");
        }
        $info = M("Guest")->where("id=".$id)->find();
        $this->assign("type",$type);
        $info['content'] = htmlspecialchars_decode($info['content']);
        $this->assign("info",$info);
        $this->display();
    }
    public function report_detail(){
        $id = $_GET['id'];
        if(!$id){
            $this->error("页面错误");
        }
        $news_info = M("News")->where("id=".$id)->find();
        $news_info['content'] = htmlspecialchars_decode($news_info['content']);
        $this->assign("news_info",$news_info);
        
        $this->display();
    }


    public function information(){
        $type = isset($_GET['type'])?$_GET['type']:0;
        $id = $type+1;
        $where = "id = ".$type+1;
        $info = M("About")->where($where)->find();
        $info['about_activity'] = htmlspecialchars_decode($info['about_activity']);
        $info['faq'] = htmlspecialchars_decode($info['faq']);
        $info['address'] = htmlspecialchars_decode($info['address']);
        $this->assign("info",$info);
        $this->assign("type",$type);
        $this->display();
    }
}