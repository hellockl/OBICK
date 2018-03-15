<?php
namespace Admin\Model;

class MatrixModel extends BaseModel
{
    protected $tableName = 'matrix';
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num 分页数
     * @return multitype:unknown string
     */
    public function selectAllMatrix($num=10,$search=array())
    {
        $where = array(
            'status' => parent::NORMAL_STATUS,
        );
        if(is_array($search) && isset($search['title']) && !empty($search['title'])){
            $where['title'] = array('like',"%{$search['title']}%");
        }
        //只有开始时间
        if(is_array($search) && isset($search['start_time']) && !empty($search['start_time']) && empty($search['end_time'])){
            $search['start_time'] .= ' 00:00:00';
            $where['create_time'] = array('egt',strtotime($search['start_time']));
        }
        //只有结束时间
        if(is_array($search) && isset($search['end_time']) && !empty($search['end_time']) && empty($search['start_time'])){
            $search['end_time'] .= ' 23:59:59';
            $where['create_time'] = array('elt',strtotime($search['end_time']));
        }
        //区间时间
        if(is_array($search) && isset($search['start_time']) && !empty($search['start_time']) && !empty($search['end_time'])){
            $search['start_time']   .= ' 00:00:00';
            $search['end_time']     .= ' 23:59:59';
            $where['create_time'] = array(array('egt',strtotime($search['start_time'])),array('elt',strtotime($search['end_time'])));
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
    public function addMatrix($data)
    {
        return $this->add($data) ? true : false;
    }

    /**
     * @description:根据id查询资讯
     * @param unknown $matrix_id
     */
    public function findMatrixById($matrix_id)
    {
        $where = array(
            'id'     => $matrix_id,
            'status' => parent::NORMAL_STATUS,
        );

        return $this->where($where)->find();
    }

    /**
     * @description:更新资讯信息
     * @param unknown $data
     */
    public function editMatrix($data)
    {
        $where = array(
            'id'    => $data['id'],
        );

        unset($data['id']);

        return $this->where($where)->save($data);
    }

    /**
     * @description:删除资讯
     * @param unknown $matrix_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteMatrix($matrix_id)
    {
        $where = array(
            'id' => $matrix_id,
        );


        return $this->where($where)->delete();
    }
}