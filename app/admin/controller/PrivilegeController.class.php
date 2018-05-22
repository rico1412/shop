<?php

namespace admin\controller;

use core\Controller;

//设置登录类
class PrivilegeController extends Controller{
    //设置登录的方法
    public function showLogin(){
        $this->display('Privilege/login.html');
    }

    //输出验证码图像方法
    public function Captcha(){
        $CaptchaTool = M('CaptchaTool');
        $CaptchaTool->output();
    }

    //登录处理方法
    public function checkLogin(){
        //接收账号,密码,验证码的值
        $acc = htmlspecialchars(addslashes(trim($_POST['acc'])));
        $pwd = htmlspecialchars(addslashes(md5(trim($_POST['pwd']))));
        $code = htmlspecialchars(addslashes(trim($_POST['code'])));
        $rememberMe = isset($_POST['rememberMe']) ? $_POST['rememberMe'] : 'no';

        var_dump($rememberMe);

        //开启session机制
        @session_start();
        //检查验证码是否正确
        if ($code !== $_SESSION['code']) {
            $str = "验证码填写错误,请重新填写";
            $url = C('URL.main') . "/index.php/?p=admin&m=Privilege&a=showLogin";
            $this->showTips(false, $str, $url);
            exit();
        }

        //检查账号密码
        $UserModel = M('UserModel');
        $sql = "select * from sp_user where acc='{$acc}' and pwd='{$pwd}' and is_admin=1";
        $row = $UserModel->getRow($sql);

        if ($row) {
            $_SESSION['admin'] = $row;//将登录者的信息保存
            if ($rememberMe == 'yes') {//如果勾选了7天免登录
                setcookie('rememberMe', $_SESSION['admin']['id'], time() + 7 * 24 * 3600);//设置一条7天有效期的cookie数据
            }

            $str = "欢迎你，亲爱的 {$row['nickname']}";
            $url = C('URL.main') . "/index.php/?p=admin&m=index&a=index";
        } else {
            $str = "用户名或密码输入错误，请重新登录！";
            $url = C('URL.main') . "/index.php/?p=admin&m=Privilege&a=showLogin";
        }
        $this->showTips($row, $str, $url);
        exit();
    }
    public function output()
    {
        unset($_SESSION['admin']);
        setcookie('admin','');
        echo "退出成功";
        $url = C('URL.main') . "/index.php/?p=admin&m=Privilege&a=showLogin";
        header('Refresh:2;url='.$url);
    }

}