<?php
/**
 * Created by PhpStorm.
 * User: rmh
 * Date: 2018/9/14
 * Time: 上午10:48
 */
namespace app\admin\validate;

use think\Validate;

class Category extends Validate{
    protected $rule = [
        'name' => 'require|max:10',
    ];
}