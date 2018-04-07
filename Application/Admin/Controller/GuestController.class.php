<?php
namespace Admin\Controller;

class GuestController extends CommonController
{
    protected   $guest_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $guest_model = D('Guest');

        $this->user_info = session('user_info');
        $this->guest_model = $guest_model;
    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        $search['name']      = I('name');
        $site_arry = array("广州站","杭州站");
        $guest_list = $this->guest_model->selectAllGuest(10,$search);
        foreach($guest_list['list'] as $key=>$val){
            $guest_list['list'][$key]['site'] = $site_arry[$val['type']-1];
        }
        
        $this->assign('guest_list',$guest_list['list']);
        $this->assign('page',$guest_list['page']);
        $this->assign('search',$search);

        $this->display();
    }
    public function uploadImgForContent()
    {
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/guest/',
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
                $url = C('HTTP_UPLOAD').'guest/'.$first['savename'];
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
     * @description: 新增资讯
     */
    public function addGuest()
    {
        if(IS_POST) {

            $guest_info = array(
                'name'         => I('post.name', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'image'         => I('post.image'),
                'is_index'      => I('post.is_index'),
                'type'          => I('post.type'),
                'create_time'   => time(),
                'hits'          => 0,
                'status'        => 1,
            );

//            if ($this->admin_user_model->findAdminUserByName($user_info['user_name'])) {
//                $this->ajaxSuccess('该用户已经被占用');
//            }

            if ($this->guest_model->addGuest($guest_info)) {
                $this->ajaxSuccess('添加成功');
            } else {
                $this->ajaxError('添加失败');
            }
        }else{
            $this->display();
        }
    }

    /**
     * @description:编辑资讯
     */
    public function editGuest(){
        if(IS_POST){
            $guest_info = array(
                'id'            => I('post.id'),
                'name'         => I('post.name', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'image'         => I('post.image'),
                'is_index'      => I('post.is_index'),
                'type'          => I('post.type'),
                'update_time'   => time(),
                'status'        => 1,
            );

            if($this->guest_model->editGuest($guest_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $guest_id = I('get.guest_id','','intval');

            $guest_info = $this->guest_model->findGuestById($guest_id);

            $this->assign('news_info',$guest_info);
            $this->display();
        }
    }
    /**
     * @description:删除资讯
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteGuest()
    {
        $guest_id = I('post.guest_id','','intval');

        $result = $this->guest_model->deleteGuest($guest_id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}