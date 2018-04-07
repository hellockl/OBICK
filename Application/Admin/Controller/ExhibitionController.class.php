<?php
namespace Admin\Controller;

class ExhibitionController extends CommonController
{
    protected   $exhibition_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $exhibition_model = D('Exhibition');
        $this->user_info = session('user_info');
        $this->exhibition_model = $exhibition_model;
    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index(){
        $search['title']      = I('title');
        $search['start_time'] = I('start_time');
        $search['end_time']   = I('end_time');
        $exhibition_list = $this->exhibition_model->selectAllExhibition(10,$search);        
        $this->assign('exhibition_list',$exhibition_list['list']);
        $this->assign('page',$exhibition_list['page']);
        $this->assign('search',$search);

        $this->display();
    }
    public function uploadImgForContent(){
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/exhibition/',
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
                $url = C('HTTP_UPLOAD').'exhibition/'.$first['savename'];
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
    public function addExhibition(){
        if(IS_POST) {
            $exhibition_info = array(
                'site'           => I('post.site', '', 'trim'),
                'date_time'      => I('post.date_time'),
                'address'        => I('post.address'),
                'introduce'      => I('post.introduce'),
                'sponsor'        => I('post.sponsor'),
                'cooperation'    => I('post.cooperation'),
                'zhanzhu'        => I('post.zhanzhu'),
                'zhanzhu_logo1'  => I('post.zhanzhu_logo1'),
                'zhanzhu_logo2'  => I('post.zhanzhu_logo2'),
                'create_time'    => time(),             
            );
            if ($this->exhibition_model->addExhibition($exhibition_info)) {
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
    public function editExhibition(){
        if(IS_POST){
            $exhibition_info = array(
                'id'             => I('post.id'),
                'site'           => I('post.site', '', 'trim'),
                'date_time'      => I('post.date_time'),
                'address'        => I('post.address'),
                'introduce'      => I('post.introduce'),
                'sponsor'        => I('post.sponsor'),
                'cooperation'    => I('post.cooperation'),
                'zhanzhu'        => I('post.zhanzhu'),
                'zhanzhu_logo1'  => I('post.zhanzhu_logo1'),
                'zhanzhu_logo2'  => I('post.zhanzhu_logo2'),               
            );
            if($this->exhibition_model->editExhibition($exhibition_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $exhibition_id = I('get.exhibition_id','','intval');
            $exhibition_info = $this->exhibition_model->findExhibitionById($exhibition_id);
            $this->assign('news_info',$exhibition_info);
            $this->display();
        }
    }
    /**
     * @description:删除资讯
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteExhibition(){
        $exhibition_id = I('post.exhibition_id','','intval');
        $result = $this->exhibition_model->deleteExhibition($exhibition_id);
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}