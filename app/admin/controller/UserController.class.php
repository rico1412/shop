<?php
/**
 * Created by PhpStorm.
 * User: z888
 * Date: 2018/5/20
 * Time: 10:13
 */

namespace admin\controller;


use core\Controller;

class UserController extends Controller{
    public function showList(){
        //new UserModel模型类对象
        $UserModel = M('UserModel');
        //执行查询的sql语句
        $sql = "select id,acc,nickname,regtime,is_admin from sp_user ";
        //执行UserModel模型里面的getRows方法
        $re = $UserModel->getRows($sql);
        //分配
        $this->assign('re', $re);
        $this->display('user/list.html');
    }

    //修改方法
    public function showEdd(){
        $id = $_GET['id'];
        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "select id,acc,nickname,pwd,is_admin from sp_user where id={$id}";
        $re = $UserModel->getRow($sql);
        $this->assign('re', $re);
        $this->display('user/cateedit.html');
    }

    public function showEdh(){
        $id = $_GET['id'];
        $nickname = $_POST['nickname'];
        $pwd = md5($_POST['pwd']);
        $is_admin = $_POST['is_admin'];
        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "update sp_user set nickname='{$nickname}',pwd='{$pwd}',is_admin='{$is_admin}' where id='{$id}'";
        $UserModel->setData($sql);

        $url = C('URL.main') . "/index.php/?p=admin&m=user&a=showList";
        header('Refresh:2;url=' . $url);
    }

    //删除
    public function showDat(){
        $id = $_GET['id'];
        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "delete from sp_user where id={$id}";
        $UserModel->setData($sql);

        $url = C('URL.main') . "/index.php/?p=admin&m=user&a=showList";
        header('Refresh:2;url=' . $url);
    }

    //添加用户
    public function showAdd(){

        $this->display('user/add.html');
    }

    //添加处理用户
    public function showAdh(){
        $nickname = $_POST['nickname'];
        $acc = $_POST['acc'];
        $pwd = md5($_POST['pwd']);
        $is_admin = $_POST['is_admin'];
        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "insert into sp_user(nickname,acc,pwd,is_admin) values ('{$nickname}','{$acc}','{$pwd}','{$is_admin}')";
        $UserModel->setData($sql);

        $url = C('URL.main') . "/index.php/?p=admin&m=user&a=showList";
        header('Refresh:2;url=' . $url);


    }
}