<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{

    public function initialize(){
        $isLogin = $this->isLogin();
        if (!$isLogin){
            $this->redirect('login/index');
        }
    }


    public function isLogin(){

        $user = session('admin_user','','admin');

        if ($user && $user->id){
            return true;
        }else{
            return false;
        }
    }


}
