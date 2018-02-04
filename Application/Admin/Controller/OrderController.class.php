<?php
namespace Admin\Controller;

class OrderController extends CommonController
{
    protected   $order_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $order_model = D('Order');

        $this->user_info = session('user_info');
        $this->order_model = $order_model;
    }
    
    /**
     * @description:订单列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        $search['title']      = I('title');
        $search['start_time'] = I('start_time');
        $search['end_time']   = I('end_time');

        $order_list = $this->order_model->selectAllOrder(5,$search);
        
        $this->assign('order_list',$order_list['list']);
        $this->assign('page',$order_list['page']);
        $this->assign('search',$search);

        $this->display();
    }
    public function uploadImgForContent()
    {
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/ordercontent/',
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
                $url = C('HTTP_UPLOAD').'ordercontent/'.$first['savename'];
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
     * @description: 新增订单
     */
    public function addOrder()
    {
        if(IS_POST) {

            $order_info = array(
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'author'        => $this->user_info['user_name'],
                'create_time'   => time(),
                'hits'          => 0,
                'status'        => 1,
            );

//            if ($this->admin_user_model->findAdminUserByName($user_info['user_name'])) {
//                $this->ajaxSuccess('该用户已经被占用');
//            }

            if ($this->order_model->addOrder($order_info)) {
                $this->ajaxSuccess('添加成功');
            } else {
                $this->ajaxError('添加失败');
            }
        }else{
            $this->display();
        }
    }

    /**
     * @description:编辑订单
     */
    public function editOrder()
    {
        if(IS_POST){
            $order_info = array(
                'id'            => I('post.id'),
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'author'        => $this->user_info['user_name'],
                'update_time'   => time(),
                'status'        => 1,
            );

            if($this->order_model->editOrder($order_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $order_id = I('get.order_id','','intval');
            $order_info = $this->order_model->findOrderById($order_id);
            $this->assign('order_info',$order_info);
            $this->display();
        }
    }
    /**
     * @description:删除订单
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteOrder()
    {
        $order_id = I('post.order_id','','intval');

        $result = $this->order_model->deleteOrder($order_id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}