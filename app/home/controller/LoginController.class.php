<?php
/**
 * Created by PhpStorm.
 * User: z888
 * Date: 2018/5/22
 * Time: 15:21
 */

namespace home\controller;


use core\Controller;
//创建一个前台的类
class LoginController extends Controller {
   public function login(){
       $this->display('login.html');
   }
   //前台注册功能
    public function register(){
       //接收传递过来的值
        $acc=trim($_POST['acc']);
        $pwd =md5(trim($_POST['pwd']));
        // //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql ="insert into sp_user(acc,pwd) values ('{$acc}','{$pwd}') ";
        $re =$UserModel->setData($sql);
        if($re){
            echo "注册成功";
        }else{
            echo "注册失败";
        }
        $url = C('URL.main') . "/index.php/?p=home&m=Login&a=login";
        header('Refresh:2;url=' . $url);
   }
   //前台登录功能
    public function showlogin(){
        //接收表单提交的数据
        $acc=trim($_POST['acc']);
        $pwd =md5(trim($_POST['pwd']));

        //调用模型检查账号和密码是否正确
        $UserModel = M('UserModel');
        $sql ="select * from sp_user where acc='{$acc}'and is_admin=0";
        $user =$UserModel->getRow($sql);

        if(isset($user)&&$user['pwd']===$pwd){
            @session_start();
            $_SESSION['home']=$user;
            echo "<script>alert('登陆成功');this.href='http://shop.com/index.php/?p=home&m=Login&a=showlogin'</script>";
        }else{
            echo "<script>alert('登陆失败');this.href='http://shop.com/index.php/?p=home&m=Login&a=showlogin'</script>";
        }

    }
}