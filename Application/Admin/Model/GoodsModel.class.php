<?php
namespace Admin\Model;

class GoodsModel extends BaseModel
{
    protected $tableName = 'goods';
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num 分页数
     * @return multitype:unknown string
     */
    public function selectAllGoods($num=10,$search=array()){
        $where = array(
            'status' => parent::NORMAL_STATUS,
        );
        
        if(is_array($search) && isset($search['name']) && !empty($search['name'])){
            $where['title'] = array('like',"%{$search['name']}%");
            
        }
        
        $count      = $this->where($where)->count();
		
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        
        return array('page' => $show , 'list' => $list);
    }
    /**
     * @description:添加资讯
     * @param unknown $data
     * @return boolean
     */
    public function addGoods($data)
    {
        return $this->add($data) ? true : false;
    }

    /**
     * @description:根据id查询资讯
     * @param unknown $goods_id
     */
    public function findGoodsById($goods_id)
    {
        $where = array(
            'id'     => $goods_id,
            'status' => parent::NORMAL_STATUS,
        );

        return $this->where($where)->find();
    }

    /**
     * @description:更新资讯信息
     * @param unknown $data
     */
    public function editGoods($data)
    {
        $where = array(
            'id'    => $data['id'],
        );

        unset($data['id']);

        return $this->where($where)->save($data);
    }

    /**
     * @description:删除资讯
     * @param unknown $goods_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteGoods($goods_id)
    {
        $where = array(
            'id' => $goods_id,
        );


        return $this->where($where)->delete();
    }
}