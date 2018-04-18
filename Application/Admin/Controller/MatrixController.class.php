<?php
namespace Admin\Controller;

class MatrixController extends CommonController
{
    protected   $matrix_model;
    protected   $user_info;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $matrix_model = D('Matrix');

        $this->user_info = session('user_info');
        $this->matrix_model = $matrix_model;
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

        $matrix_list = $this->matrix_model->selectAllMatrix(10,$search);
        
        $this->assign('matrix_list',$matrix_list['list']);
        $this->assign('page',$matrix_list['page']);
        $this->assign('search',$search);

        $this->display();
    }
    public function uploadImgForContent()
    {
        //处理file上传 这里是调用thinkphp封装好\Think\Upload这个上传类 可以学习写thinkphp官方这个类是怎么写的
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/matrix/',
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
                $url = C('HTTP_UPLOAD').'matrix/'.$first['savename'];
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
    public function addMatrix()
    {
        if(IS_POST) {

            $matrix_info = array(
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'category'      => I('post.category'),
                'is_index'      => I('post.is_index'),
                'url'           => I('post.url'),
                'type'        => I('post.type'),
                'create_time'   => time(),

            );


            if ($this->matrix_model->addMatrix($matrix_info)) {
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
    public function editMatrix()
    {
        if(IS_POST){
            $matrix_info = array(
                'id'            => I('post.id'),
                'title'         => I('post.title', '', 'trim'),
                'content'       => I('post.content'),
                'smeta'         => I('post.smeta'),
                'type'          => I('post.type'),
                'category'      => I('post.category'),
                'is_index'      => I('post.is_index'),
                'url'           => I('post.url'),
                'update_time'   => time(),

            );

            if($this->matrix_model->editMatrix($matrix_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $matrix_id = I('get.matrix_id','','intval');
            $matrix_info = $this->matrix_model->findMatrixById($matrix_id);
            $this->assign('matrix_info',$matrix_info);
            $this->display();
        }
    }
    /**
     * @description:删除资讯
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteMatrix()
    {
        $matrix_id = I('post.matrix_id','','intval');

        $result = $this->matrix_model->deleteMatrix($matrix_id);

        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}