<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{



    public function index()
    {

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

        foreach ($firstCategorys as $firstCategory){
            $recomCats[$firstCategory->id] = [$firstCategory->name,
                empty($sedcatArr[$firstCategory->id]) ? [] : $sedcatArr[$firstCategory->id],$firstCategory->id];
        }

//        return json_encode($recomCats);

        $listModel  = model('Blog')->getNews()->toArray();
        $listPosition = model('Blog')->getPositionNormalNews()->toArray();
        $listRank = model('Blog')->getRunkNormalNews()->toArray();
        $header = model('Blog')->getHeader()->toArray();
        $sPositon = model('Blog')->getsPositonNews()->toArray();




//        return  json_encode($header);exit();

//        return json_encode($recomCats);exit();
        return $this->fetch('',
            [
                'recomCats'=>$recomCats,
                'listModel'=>$listModel,
                'positionList'=>$listPosition,
                'rankList'=>$listRank,
                'header'=>$header,
                'sPositon'=>$sPositon
            ]);



    }

    public function feedlist( $id=0 , $name='' ,$isParent=false ){
//        echo $id;exit();
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
                empty($sedcatArr[$firstCategory->id]) ? [] : $sedcatArr[$firstCategory->id],$firstCategory->id];
        }



        $listModel =[];
        if ($isParent)
        {
            $cArrays = model('Category')->getCategoryIdByParentId([$id])->toArray();
            $qArray = [];

            foreach ($cArrays as $cmodel)
            {
                $qArray[] = $cmodel['id'];

            }
//            $str = implode(',',$qArray);
//            print_r($str);exit();
            $listModel = model('Blog')->getNews([],$qArray);

//            print_r($listModel);exit();
        }else{
            $listModel = model('Blog')->getNews(['catid'=>$id]);
        }
        $listPosition = model('Blog')->getPositionNormalNews()->toArray();
        $listRank = model('Blog')->getRunkNormalNews()->toArray();
        $sPositon = model('Blog')->getsPositonNews()->toArray();



//        return  json_encode($listModel);exit();
//        exit();
//        return json_encode($recomCats);
        return $this->fetch('list',
            [
                'id'=>$id,
                'name'=>$name,
                'recomCats'=>$recomCats,
                'listModel'=>$listModel,
                'positionList'=>$listPosition,
                'rankList'=>$listRank,
                'sPositon'=>$sPositon
            ]);
    }


    public function info($id=0 , $name=''){

//        try {
            model('Blog')->where(['id' => $id])->setInc('read_count');
//        }catch(\Exception $e) {
//            return new ApiException('error', 400);
//        }

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
                empty($sedcatArr[$firstCategory->id]) ? [] : $sedcatArr[$firstCategory->id],$firstCategory->id];
        }


        $listPosition = model('Blog')->getPositionNormalNews()->toArray();
        $listRank = model('Blog')->getRunkNormalNews()->toArray();

        $blog = model('Blog')->getBlog($id);
        $sPositon = model('Blog')->getsPositonNews()->toArray();


//        return $id ;exit();

//        return json_encode($recomCats);


        return $this->fetch('',
            [
                'id'=>$id,
                'name'=>$name,
                'recomCats'=>$recomCats,
                'positionList'=>$listPosition,
                'rankList'=>$listRank,
                'blog'=>$blog[0],
                'sPositon'=>$sPositon
            ]);
    }

    public function like($id = 0){
        try {
            $id =  model('Blog')->where(['id' => $id])->setInc('upvote_count');
        }catch(\Exception $e) {
            $this->result('','0','点赞失败');
        }
        if ($id){
            $this->result('','1','感谢点赞');
        }
    }

    public function search(){
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
                empty($sedcatArr[$firstCategory->id]) ? [] : $sedcatArr[$firstCategory->id],$firstCategory->id];
        }
        $key = input('get.')['keyboard'];
        if (!empty($key)){
            $whereData =[
                ['title|small_title', 'like', '%'.$key.'%'],
//                ['status', '=', 1],
            ];
        }
        $listModel = model('Blog')->getNews($whereData);
        $listPosition = model('Blog')->getPositionNormalNews()->toArray();
        $listRank = model('Blog')->getRunkNormalNews()->toArray();
        $sPositon = model('Blog')->getsPositonNews()->toArray();



//        return  json_encode($listModel);exit();
//        exit();
//        return json_encode($recomCats);
        return $this->fetch('list',
            [
                'name'=>$key,
                'recomCats'=>$recomCats,
                'listModel'=>$listModel,
                'positionList'=>$listPosition,
                'rankList'=>$listRank,
                'sPositon'=>$sPositon
            ]);

    }
}
