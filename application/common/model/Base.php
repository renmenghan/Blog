<?php
/**
 * Created by PhpStorm.
 * User: rmh
 * Date: 2018/9/14
 * Time: 上午10:42
 */
namespace app\common\model;
use think\Model;

class Base extends Model {

    protected  $autoWriteTimestamp = true;

    public function add($data) {

        $data['status'] = 0;
        $data ['author'] = '光头金项链的和尚';
        $this->save($data);

        return $this->id;
    }




}