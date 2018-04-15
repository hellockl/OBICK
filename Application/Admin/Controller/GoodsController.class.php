<?php
namespace Admin\Controller;

class GoodsController extends CommonController
{
    protected   $goods_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $goods_model = D('Goods');

        $this->user_info = session('user_info');
        $this->goods_model = $goods_model;
    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index(){
        $search['name']      = I('name');
        $goods_list = $this->goods_model->selectAllGoods(10,$search); 
        $site_arry = array("广州站","杭州站");
        foreach($goods_list['list'] as $key=>$val){
            $goods_list['list'][$key]['site'] = $site_arry[$val['type']-1];
        }
        
        $this->assign('goods_list',$goods_list['list']);
        $this->assign('page',$goods_list['page']);
        $this->assign('search',$search);
        $this->display();
    }
    
    
    

    public function uploadImgForContent(){
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/goods/',
            'maxSize' => 11048576,
            'saveName' => array('uniqid', ''),
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub' => false,
        );
        $upload = new \Think\Upload($config);//
        $info = $upload->upload();
        //开始上传
        if ($info) {
            //上传成功
            $first = array_shift($info);
            if (!empty($first['url'])) {
                $url = $first['url'];
            } else {
                $url = C('HTTP_UPLOAD').'goods/'.$first['savename'];
            }
            $arr['code'] = 0;
            $arr['msg'] = '';
            $arr['data']['src'] = $url;
            $arr['data']['title'] = $first['savename'];
            echo json_encode($arr);
        } else {
            $arr['code'] = 300;
            $arr['msg'] = $upload->getError();
            $arr['data']['src'] = '';
            $arr['data']['title'] = '';
            echo json_encode($arr);
        }
    }
    /*
     * @description: 新增商品
     */
    public function addGoods()
    {
        if(IS_POST) {

            $goods_info = array(
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'image'         => I('post.image'),
                'is_index'      => I('post.is_index'),
                'is_limit'      => I('post.is_limit'),
                'category'          => I('post.category'),
                'type'      => I('post.type'),
                'create_time'   => time(),
                'hits'          => 0,
                'status'        => 1,
            );

            if ($this->goods_model->addGoods($goods_info)) {
                $this->ajaxSuccess('添加成功');
            } else {
                $this->ajaxError('添加失败');
            }
        }else{
            $category_list = M("GoodsCategory")->where()->select();
            $this->assign('category_list',$category_list);
            $this->display();
        }
    }

    /**
     * @description:编辑商品
     */
    public function editGoods()
    {
        if(IS_POST){
            $goods_info = array(
                'id'            => I('post.id'),
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'image'         => I('post.image'),
                'is_index'      => I('post.is_index'),
                'is_limit'      => I('post.is_limit'),
                'type'          => I('post.type'),
                'category'          => I('post.category'),
                'author'        => $this->user_info['user_name'],
                'update_time'   => time(),
                'status'        => 1,
            );

            if($this->goods_model->editGoods($goods_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $goods_id = I('get.goods_id','','intval');
            $goods_info = $this->goods_model->findGoodsById($goods_id);
            $category_list = M("GoodsCategory")->where()->select();
            $this->assign('category_list',$category_list);
            $this->assign('goods_info',$goods_info);
            $this->display();
        }
    }
    /**
     * @description:删除资讯
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteGoods()
    {
        $goods_id = I('post.goods_id','','intval');

        $result = $this->goods_model->deleteGoods($goods_id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
    
    public function category(){
        $category_list = M("GoodsCategory")->where()->select();
        $this->assign('category_list',$category_list);
        $this->display();
    }
    
    /*
     * @description: 新增分类
     */
    public function addCategory(){
        if(IS_POST) {
            $data_info = array(
                'name'         => I('post.name', '', 'trim'),
                'create_time'  => time()
            );
            if (M("GoodsCategory")->add($data_info)) {
                $this->ajaxSuccess('添加成功');
            } else {
                $this->ajaxError('添加失败');
            }
        }else{
            $this->display();
        }
    }
    
    /**
     * @description:编辑分类
     */
    public function editCategory(){
        if(IS_POST){
            $data = array(
                'name'            => I('post.name'),              
            );
            $res = M("GoodsCategory")->where("id=".I("post.id"))->save($data);
            if($res!==FALSE){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $category_id = I('get.id','','intval');
            $category_info = M("GoodsCategory")->where("id=".$category_id)->find();
            $this->assign('category_info',$category_info);
            $this->display();
        }
    }
    /**
     * @description:删除分类
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteCategory(){
        $category_id = I('post.category_id','','intval');
        $result = M("GoodsCategory")->where("id=".$category_id)->delete;
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}