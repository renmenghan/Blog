<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Base
{
    public function initialize(){}
    public function index(){
        // 如果后台用户登录了 跳转到后台首页
        $isLogin = $this->isLogin();
        if ($isLogin){
            return $this->redirect('index/index');
        }
        return $this->fetch();
    }


    public function login()
    {
        $data = input('post.');

        if (!captcha_check($data['code'])){
            $this->error('验证码错误');
        }

//        $validate = validate('')
        if (!empty($data['account']) && !empty($data['password'])){
            try{
                $user = model('AdminUser')->get(['username' => $data['account']]);
            }catch (\Exception $e){

                $this->error($e->getMessage());
            }

            if ($user){

                if (md5($data['password'].$user->code) === $user['password']){

                    $udata = [
                        'last_login_time' => time(),
                        'last_login_ip' => request()->ip(),
                    ];
                    $result = model('AdminUser')->save($udata,['id'=>$user->id]);
                    if ($result){
                        session('admin_user',$user,'admin');
                        $this->success('登录成功','index/index');
                    }

                }else{
                    $this->error('密码不正确');
                }

            }else{
                $this->error('没有该用户');
            }



        }else{
            $this->error('账号密码不能为空');
        }

    }

    public function logout(){

        session('admin_user',null,'admin');

        $this->redirect('login/index');

    }



}
