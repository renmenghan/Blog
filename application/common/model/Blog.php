<?php
/**
 * Created by PhpStorm.
 * User: rmh
 * Date: 2018/9/14
 * Time: 上午10:42
 */
namespace app\common\model;
use think\Model;

class Blog extends Base {



    /**
     * 后台自动化分页
     * @param array $data
     * @return array
     */
    public function getNews($data=[],$ids=[]){
//        $data['status'] = [
//            'neq',-1
//        ];
//        $data = [
//            ['status','=','1'],
////            'status' => 1,
//
////            'parent_id' => ['in', implode(',', $ids)],
//        ];
//        $data['status'] = ['in','1'];
//
//        print_r($data);exit();
        if (count($ids) > 0)
        {
            $data[] = ['catid','in',implode(',', $ids)];
        }
//        $data['status'] = ['in','1'];
        $order = ['read_count' => 'desc'];
        $result = $this->where($data)
            ->where('status','=',1)
            ->order($order)
            ->paginate();

//        echo $this->getLastSql();exit();
        return $result;
    }

    // 根据条那件获取数据
    public function  getNewsByCondition($param = []) {
        $condition['status'] = ['in','1'];
//        $condition=[];
        $order = ['id' => 'desc'];

        $from = ($param['page']-1) * $param['size'];

        $result = $this->where($condition)
            ->limit($from,$param['size'])
            ->order($order)
            ->select();
//        echo $this->getLastSql();
        return $result;
    }
    // 根据条件获取列表的数据总数/
    public function getNewsCountCondition($param = [])
    {
        $condition['status'] = ['in','1'];

        $result= $this->where($condition)
            ->count();
//        echo $this->getLastSql();
        return $result;
    }

    public  function  getPositionNormalNews($num = 5){

        $data = [
            'status'=>1,
            'is_position'=>1,
        ];

        $order = ['id'=>'desc'];

        $result = $this->where($data)
                ->order($order)
                ->limit($num)
                ->select();
//                echo $this->getLastSql();
        return $result;
    }

    public  function  getRunkNormalNews($num = 5){

        $data = [
            'status'=>1,
        ];

        $order = ['read_count'=>'desc'];

        $result = $this->where($data)
            ->order($order)
            ->limit($num)
            ->select();
//                echo $this->getLastSql();
        return $result;
    }

    public function getBlog($id = ''){
        $data = [
//            'status'=>1,
            'id' => $id
        ];
        $result = $this->where($data)
            ->select();
                        echo $this->getLastSql();
//exit();
        return $result;
    }

    public  function  getHeader($num = 5){

        $data = [
            'status'=>1,
            'is_head_figure'=>1
        ];

//        $order = ['read_count'=>'desc'];

        $result = $this->where($data)
            ->limit($num)
            ->select();
//                echo $this->getLastSql();
        return $result;
    }


    public  function  getsPositonNews($num = 5){

        $data = [
            'status'=>1,
        ];

        $order = [
            'is_position'=>1,
            'read_count'=>'desc'];

        $result = $this->where($data)
            ->order($order)
            ->limit($num)
            ->select();
//                echo $this->getLastSql();
        return $result;
    }




}