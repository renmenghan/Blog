<?php
namespace app\admin\controller;
use think\Controller;

class Blog extends Base
{
    public function add()
    {

        if (request()->isPost()){

            $data = input('post.');
//            print_r($data);exit();
            try{
                $id = model('blog')->add($data);
            }catch (\Exception $e){
                return $this->result('',0,'新增失败');
            }
            if ($id){
                return $this->result(['jump_url'=>url('blog/add')],1,'ok');
            }else{
                return $this->result('',0,'新增失败');
            }
        }else{
            $firstCategorys = model('Category')->getNormalFirstCategory();
            $ids =$sedcatArr =$recomCats= [];
            foreach ($firstCategorys as $firstCategory){
                $ids[] = $firstCategory->id;
            }
//        print_r($ids);exit();
            $sedCats = model('Category')->getCategoryIdByParentId($ids);
            foreach ($sedCats as $sedcat){
                $sedcatArr[$sedcat->parent_id][]=[
                    'id' => $sedcat->id,
                    'name' =>$sedcat->name
                ];
            }
//        return json_encode($recomCats);

            foreach ($firstCategorys as $firstCategory){
                $recomCats[$firstCategory->id] = [$firstCategory->name,
                    empty($sedcatArr[$firstCategory->id]) ? [] : $sedcatArr[$firstCategory->id]];
            }

//        print_r($recomCats);exit();

//        return json_encode($recomCats);
            return $this->fetch('',['recomCats'=>$recomCats]);
        }

    }

    public function index(){

        $data = input('param.');
//        $news = model('Blog')->getNews();
        // page size from to limit from size
        $whereData = [];
        $whereData['page'] = !empty($data['page']) ? $data['page'] : 1;
        $whereData['size'] = !empty($data['size']) ? $data['page']:config('paginate.list_rows');
        // 获取表里数据


        $news =  model('Blog')->getNewsByCondition($whereData);
        // 获取满足条件的数据总数
        $total = model('Blog')->getNewsCountCondition($whereData);
        $pageTotal = ceil($total / $whereData['size']);

//echo  $pageTotal;exit();
        return $this->fetch('',[
            'news' =>$news,
            'pageTotal'=>$pageTotal,
            'curr'=>$whereData['page']
            ]);
    }

    public function edit()
    {

        if (request()->isPost()){
            $data = input('post.');
            $id = input('param.')['id'];
            // 数据需要做校验 validate机制
            try{
                $id = model('Blog')->save($data,['id'=>$id]);
            }catch (\Exception $e){
                return $this->result('',0,'新增失败');
            }
            if ($id){
                return $this->result(['jump_url'=>url('blog/index')],1,'ok');
            }else{
                return $this->result('',0,'新增失败');
            }
        }else{
            $data = input('param.');
            $model = model('Blog')->get(['id'=>$data['id']]);
            $firstCategorys = model('Category')->getNormalFirstCategory();
            $ids =$sedcatArr =$recomCats= [];
            foreach ($firstCategorys as $firstCategory){
                $ids[] = $firstCategory->id;
            }
//        print_r($ids);exit();
            $sedCats = model('Category')->getCategoryIdByParentId($ids);
            foreach ($sedCats as $sedcat){
                $sedcatArr[$sedcat->parent_id][]=[
                    'id' => $sedcat->id,
                    'name' =>$sedcat->name
                ];
            }
//        return json_encode($recomCats);

            foreach ($firstCategorys as $firstCategory){
                $recomCats[$firstCategory->id] = [$firstCategory->name,
                    empty($sedcatArr[$firstCategory->id]) ? [] : $sedcatArr[$firstCategory->id]];
            }

//        print_r($recomCats);exit();

//        return json_encode($recomCats);
            return $this->fetch('',['recomCats'=>$recomCats,'model'=>$model]);
        }

    }
    public function status($id,$status)
    {

        $res = model('Blog')->save(['status'=>$status],['id'=>$id]);

        if ($res){
            $this->success('更新成功');
        }else{
            $this->success('更新失败');
        }
    }

}
