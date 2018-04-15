<?php
namespace Admin\Controller;

class BannerController extends CommonController
{
    protected $banner_model;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $banner_model = D('Banner');

        $this->banner_model = $banner_model;
    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        //var_dump(111);exit;
        $banner_list = $this->banner_model->selectAllbanner(1);

        $this->assign('list',$banner_list['list']);
        $this->assign('page',$banner_list['page']);
        $this->display();
    }

    /**
     * @description:添加菜单
     * @author wuyanwen(2016年12月1日)
     */
    public function addBanner()
    {
        if(IS_POST){
            $data = I('post.');

            $data['create_time'] = time();
           // var_dump($data);exit;
            if($this->banner_model->addBanner($data)){
                $this->ajaxSuccess("Banner添加成功");
            }else{
                $this->ajaxError("Banner添加失败");
            }
        }else{

            $this->display();
        }
    }

    /**
     * @description:更新菜单
     * @author wuyanwen(2016年12月1日)
     */
    public function editBanner()
    {
        if(IS_POST){
            $data = I('post.');
            $data_info = array(
                'id'=>$data['id'],
                'banner_name'=>$data['banner_name'],
                'is_index' => $data['is_index'],
                'banner_img'=>$data['banner_img'],
                'type'=>$data['type'],
                'position'=>$data['position']
            );
            if($this->banner_model->editBanner($data_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id','','intval');
            $banner_info = $this->banner_model->findBannerById($id);
            $this->assign("banner_info",$banner_info);
            $this->display();
        }
    }

    public function deleteBanner(){
        $id = I('post.id','','intval');



        if(!$this->banner_model->deleteBannerById($id)){
            $this->ajaxError('删除失败');
        }else{
            $this->ajaxSuccess('删除成功');
        }
    }

    public function upload(){
        $config = array(
            'rootPath' => './Public/',
            'savePath' => 'upload/banner/',
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
                $url = C('HTTP_UPLOAD').'banner/'.$first['savename'];
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
    

}