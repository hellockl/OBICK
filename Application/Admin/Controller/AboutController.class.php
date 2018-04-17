<?php
namespace Admin\Controller;

class AboutController extends CommonController
{
    protected   $about_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $about_model = D('About');

        $this->user_info = session('user_info');
        $this->about_model = $about_model;
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

        $about_list = $this->about_model->selectAllAbout(10,$search);
        foreach ($about_list['list'] as $key=>$val){
            $about_list['list'][$key]['faq'] = htmlspecialchars_decode($val['faq']);
            $about_list['list'][$key]['about_activity'] = htmlspecialchars_decode($val['about_activity']);
            $about_list['list'][$key]['address'] = htmlspecialchars_decode($val['address']);
        }
		
        
        $this->assign('about_list',$about_list['list']);
        $this->assign('page',$about_list['page']);
        $this->assign('search',$search);

        $this->display();
    }
    public function uploadImgForContent()
    {
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/aboutcontent/',
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
                $url = C('HTTP_UPLOAD').'aboutcontent/'.$first['savename'];
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
    public function addAbout()
    {
        if(IS_POST) {

            $about_info = array(
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'author'        => $this->user_info['user_name'],
                 'is_index'      => I('post.is_index'),
                'category'      => I('post.category'),
                'type'      => I('post.type'),
                'create_time'   => time(),
                'hits'          => 0,
                'status'        => 1,
            );

//            if ($this->admin_user_model->findAdminUserByName($user_info['user_name'])) {
//                $this->ajaxSuccess('该用户已经被占用');
//            }

            if ($this->about_model->addAbout($about_info)) {
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
    public function editAbout()
    {
        if(IS_POST){
            $about_info = array(
                'id'            => I('post.id'),
                
                'about_activity'       => I('post.about_activity'),
                'address'         => I('post.address'),
                'faq' => I('post.faq'),
            );

            if($this->about_model->editAbout($about_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $about_id = I('get.about_id','','intval');
            $about_info = $this->about_model->findAboutById($about_id);
            $this->assign('about_info',$about_info);
            $this->display();
        }
    }
    /**
     * @description:删除资讯
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteAbout()
    {
        $about_id = I('post.about_id','','intval');

        $result = $this->about_model->deleteAbout($about_id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}