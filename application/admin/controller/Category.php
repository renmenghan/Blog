<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
    public function index()
    {
        $parentId = input('get.parent_id','0','intval');
//        var_dump($categories);
        $categories = model('Category')->getFirstCategorys($parentId);
        return $this->fetch('',['categories' => $categories]);
    }


    public function add(){
        $categories = model('Category')->getNormalFirstCategory();
        return  $this->fetch('',['categories' => $categories]);
    }

    public function save() {
        $data = input('post.');
        $validate = validate('Category');
        if (!$validate->check($data)){
            $this->error($validate->getError());
        }
        $id = model('Category')->add($data);
        if ($id) {
            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }
//        try {
//            $id = model('Category')->add($data);
//            if ($id) {
//                $this->success('新增成功');
//            }
//        } catch (\Exception $e) {
//            $this->error($e->getMessage());
//        }
    }

    /**
     * @return bool
     */
    public function status($id,$status)
    {

        $res = model('Category')->save(['status'=>$status],['id'=>$id]);

        if ($res){
            $this->success('更新成功');
        }else{
            $this->success('更新失败');
        }
    }

    public function edit($id=0){
        if(intval($id) < 1) {
            $this->error('参数不合法');
        }
        $category = model('Category')->get($id);
        $categories = model('Category')->getNormalFirstCategory();

        return $this->fetch('',[
                'category' => $category,
                'categories'=>$categories
        ]);
    }




}
