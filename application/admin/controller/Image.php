<?php
/**
 * Created by PhpStorm.
 * User: renmenghan
 * Date: 2018/2/17
 * Time: 下午5:28
 */

namespace app\admin\controller;
use app\common\lib\Upload;
use think\Controller;
use think\Request;

/**
 * 后台图片上传相关逻辑
 * Class Image
 * @package app\admin\controller
 */
class Image extends Base
{


//    public  function  upload0(){
//
//        $file = $this->request->file('file');
//        // 把图片上传到指定文件夹
//
//        $info = $file->move('upload');
//
//        if ($info && $info->getPathname()){
//            $data = [
//                "status" => 1,
//                "message"=>"ok",
//                "data" =>'/'.$info->getPathname(),
//            ];
//            echo json_encode($data);
//        }else {
//            echo json_encode(["status" => 0, "message" => "上传失败"]);
//        }
//
//    }

    public function upload(){
        try{
            $image = Upload::image();
        }catch (\Exception $e){
            echo json_encode(["status" => 0, "message" => $e->getMessage()]);
        }

        if ($image){
            $data = [
                "status" => 1,
                "message"=>"ok",
                "data" => config('txy.image_url')."/".$image,
            ];
            echo json_encode($data);
        }else{
            echo json_encode(["status" => 0, "message" => "上传失败"]);
        }
    }


}
