<?php
namespace Admin\Model;

class GoodsModel extends BaseModel
{
    protected $tableName = 'goods';

    /**
     * @description:查询用户
     * @author wuyanwen(2016年11月22日)
     */
    public function findGoods($name, $pwd)
    {
        $where = array(
            'goods_name' => $name,
            'password' => md5($pwd),
            'status'   => parent::NORMAL_STATUS,
        );

        $result = $this->where($where)->find();

        return $result;
    }


    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllGoods($num=10)
    {
        $where = "1=1";

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->order('create_time desc')->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);

    }

    /**
     * @description:添加后台用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addGoods($data)
    {
        return $this->add($data) ;
    }

    /**
     * @description:更新用户信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editGoods($data)
    {
        $where = array(
            'goods_id'    => $data['goods_id'],
        );
        unset($data['goods_id']);

        return $this->where($where)->save($data);
    }

    /**
     * @description:删除用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $goods_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteGoods($goods_id)
    {
        $where = array(
            'id' => $goods_id,
        );

        $data = array(
            'status' => parent::DEL_STATUS,
        );

        return $this->where($where)->save($data);
    }


    /**
     * @description:根据id查询用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $goods_id
     */
    public function findGoodsById($goods_id)
    {
        $where = array(
            'goods_id'     => $goods_id,
            //'status' => parent::NORMAL_STATUS,
        );

        return $this->where($where)->find();
    }

    public function findGoodsByName($goods_name)
    {
        $where = array(
            'goods_name' => $goods_name,
            //'status'    => parent::NORMAL_STATUS,
        );


        return $this->where($where)->find();
    }

    public function findGoodsNameById($goods_id){
        $where = array(
            'goods_id'=>$goods_id,
        );
        return $this->where($where)->getField('goods_name');
    }
}