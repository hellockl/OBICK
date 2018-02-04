<?php
namespace Admin\Controller;

class GoodsController extends CommonController
{
    protected $goods_model;
    
    public function __construct()
    {
        //用户状态；0：待激活；1：已激活,未审核;2：已激活,已审核；3：已禁用
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminGoodsModel */
        $goods_model = D('Goods');

        $this->goods_model = $goods_model;
    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        $goods_list = $this->goods_model->selectAllGoods(8);
        
        $this->assign('goods_list',$goods_list['list']);
        $this->assign('page',$goods_list['page']);
        $this->display();
    }

    /**
     * @description:我推的用户
     * @author ckl(2017年3月1日)
     *
     */
    public function myChild(){
        $goods_id = I('goods_id',0,'intval');
        
        $where['goods_id'] = $goods_id;
        $mychild_list = M("Package")->where($where)->select();
        $this->assign('mychild_list',$mychild_list);
        $this->display();
    }


    
    
    
    /**
     * @description:编辑用户
     * @author wuyanwen(2016年12月1日)
     */
    public function editGoods()
    {            
        if(IS_POST){
            $user_info = array(
                'user_name' => I('post.user_name','','trim'),
                'id'        => I('post.id','','intval'),
            );
           
           if(I('post.password')){
               $user_info['password'] = md5(I('post.password','','trim'));
           }

           if($this->admin_user_model->editAdminGoods($user_info) !== false){
               $this->ajaxSuccess('更新成功');
           }else{
              $this->ajaxError('更新失败');
           }
        }else{
            $user_id = I('get.user_id','','intval');
            $user_info = $this->admin_user_model->findAdminGoodsById($user_id);
            $this->assign('user_info',$user_info);
            $this->display();
        }
    }
    
    
    /**
     * @description:删除用户
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteGoods()
    {
        $user_id = I('post.user_id','','intval');
        
        $result = $this->admin_user_model->deleteAdminGoods($user_id);
        
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }

    /**
     * @description ：审核用户
     *
     *
     */
    public function checkGoods(){
        if(IS_POST){
            $user_info = array(
                'status' => I('post.status','','intval'),
                'user_id'        => I('post.user_id','','intval'),
            );
            $resoult = $this->goods_model->findGoodsById($user_info['user_id']);
            if($resoult['status']==0){
                $this->ajaxError('该用户还未激活，请先激活！');
            }
            if($this->goods_model->editGoods($user_info) !== false){
                $this->ajaxSuccess('审核成功');
            }else{
                $this->ajaxError('审核失败');
            }
        }else{
            $user_id = I('get.user_id','','intval');
            $user_info = $this->goods_model->findGoodsById($user_id);
            $this->assign('user_info',$user_info);
            $this->display();
        }
    }

}