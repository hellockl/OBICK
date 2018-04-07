<?php
namespace Admin\Controller;

class PartnerController extends CommonController
{
    protected   $partner_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $partner_model = D('Partner');

        $this->user_info = session('user_info');
        $this->partner_model = $partner_model;
    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        $search['title']      = I('title');
        $search['start_time'] = I('start_time');
        $search['end_time']   = I('end_time');

        $partner_list = $this->partner_model->selectAllPartner(10,$search);
        $site_arry = array("广州站","杭州站");
        foreach($partner_list['list'] as $key=>$val){
            $partner_list['list'][$key]['site'] = $site_arry[$val['type']-1];
        }
        $this->assign('partner_list',$partner_list['list']);
        $this->assign('page',$partner_list['page']);
        $this->assign('search',$search);

        $this->display();
    }
    public function uploadImgForContent()
    {
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/partner/',
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
                $url = C('HTTP_UPLOAD').'partner/'.$first['savename'];
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
    public function addPartner(){
        if(IS_POST) {
            $partner_info = array(
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'type'          => I('post.type'),
                'is_index'      => I('post.is_index'),
                'create_time'   => time(),
            );
            if ($this->partner_model->addPartner($partner_info)) {
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
    public function editPartner(){
        if(IS_POST){
            $partner_info = array(
                'id'            => I('post.id'),
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'type'          => I('post.type'),
                'is_index'      => I('post.is_index'),
                'update_time'   => time(),
            );
            if($this->partner_model->editPartner($partner_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $partner_id = I('get.partner_id','','intval');
            $partner_info = $this->partner_model->findPartnerById($partner_id);
            $this->assign('partner_info',$partner_info);
            $this->display();
        }
    }
    /**
     * @description:删除资讯
     * @author wuyanwen(2016年12月1日)
     */
    public function deletePartner(){
        $partner_id = I('post.partner_id','','intval');
        $result = $this->partner_model->deletePartner($partner_id);
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}