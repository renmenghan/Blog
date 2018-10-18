<?php
/**
 * Created by PhpStorm.
 * User: rmh
 * Date: 2018/9/14
 * Time: 上午10:42
 */
namespace app\common\model;
use think\Model;

class Category extends Base {




    public function getNormalFirstCategory(){
        $data = [
            'status' => ['in','1'],
            'parent_id' => '0'
        ];

        $order = [
            'id' => 'desc',
        ];
//        $this->where($data)
//            ->order($order)
//            ->select();
//exit();
       $result =  $this->where($data)
                    ->order($order)
                    ->select();
//        echo $this->getLastSql();
        return $result;

    }

    public  function getFirstCategorys($parent_id){
        $data = [
            'status' => ['in','1'],
            'parent_id' => $parent_id
        ];

        $order = [
            'id' => 'desc',
        ];
        $result =  $this->where($data)
            ->order($order)
            ->select();

        echo $this->getLastSql();
        return $result;
    }


    public function getCategoryIdByParentId($ids=[]){
        $data = [
            ['status','=','1'],
//            'status' => 1,
            ['parent_id','in',implode(',', $ids)]
//            'parent_id' => ['in', implode(',', $ids)],
        ];
        $result =  $this->where($data)->select();
        return $result;

    }

    public function getParentCategory($id = ''){
        $data = [
           'id' => $id
        ];
        $result =  $this->where($data)->select();
        return $result;

    }

}