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

   public function logout(){
       unset($_SESSION['home']);
       setcookie('rememberMe','');
       echo "<script>alert('退出成功');location.href='" . C('URL.main') . "/index.php/?p=home&m=index&a=index'</script>";
   }


   //前台注册功能
    public function register(){
        // //new UserModel模型类对象
        $UserModel = M('UserModel');

       //接收传递过来的值
        $acc=addslashes(htmlspecialchars(trim($_POST['acc'])));
        $pwd =md5(addslashes(htmlspecialchars(trim(trim($_POST['pwd'])))));

        $sql = "select * from sp_user where acc='{$acc}'";
        $re = $UserModel->getRow($sql);
        if ($re) {
            echo "<script>alert('用户名 {$acc} 已存在，注册失败');location.href='" . C('URL.main') . "/index.php/?p=home&m=login&a=login'</script>";
        }

        $sql ="insert into sp_user(acc,pwd) values ('{$acc}','{$pwd}') ";
        $re =$UserModel->setData($sql);
        if($re){
            echo "<script>alert('注册成功');location.href='" . C('URL.main') . "/index.php/?p=home&m=login&a=login'</script>";
        }else{
            echo "<script>alert('注册失败');location.href='" . C('URL.main') . "/index.php/?p=home&m=login&a=register'</script>";
        }
   }
   //前台登录功能
    public function showlogin(){
        //接收表单提交的数据
        $acc=addslashes(htmlspecialchars(trim($_POST['acc'])));
        $pwd =md5(addslashes(htmlspecialchars(trim($_POST['pwd']))));

        //调用模型检查账号和密码是否正确
        $UserModel = M('UserModel');
        $sql ="select * from sp_user where acc='{$acc}'and is_admin=0";
        $user =$UserModel->getRow($sql);

        if(isset($user)&&$user['pwd']===$pwd){
            @session_start();
            $_SESSION['home']=$user;
            echo "<script>alert('登陆成功');location.href='" . C('URL.main') . "/index.php/?p=home&m=index&a=index'</script>";
        }else{
            echo "<script>alert('登陆失败');location.href='" . C('URL.main') . "/index.php/?p=home&m=login&a=login'</script>";
        }

    }
}