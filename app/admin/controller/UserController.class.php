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
        $id = htmlspecialchars($_GET['id']);
        $nickname = htmlspecialchars($_POST['nickname']);
        $pwd = htmlspecialchars(addslashes($_POST['pwd']));
        $is_admin = htmlspecialchars($_POST['is_admin']);

        $condition = "nickname='{$nickname}',is_admin='{$is_admin}'";

        if (empty($pwd)) {
            $pwd = md5($pwd);
            $condition .= ",pwd='{$pwd}'";
        }

        //调用图像
        $img = '';
        if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
            $UpFileTool = M('UpFileTool');
            $img = $UpFileTool->upfile($_FILES['img']);
        }

        if ($img) {
            $condition .= ",img='{$img}'";
        }

        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "update sp_user set {$condition} where id='{$id}'";
        $re = $UserModel->setData($sql);

        if ($re) {
            $str = "编辑成功！";
        } else {
            $str = "编辑失败，请联系管理员！";
        }

        $url = C('URL.main') . "/index.php/?p=admin&m=user&a=showList";
        $this->showTips($re, $str, $url);
    }

    //删除
    public function showDat(){
        $id = $_GET['id'];
        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "delete from sp_user where id={$id}";
        $re=$UserModel->setData($sql);

        if ($re) {
            $str = "删除成功！";
        } else {
            $str = "删除失败，请联系管理员！";
        }

        $url = C('URL.main') . "/index.php/?p=admin&m=user&a=showList";

        $this->showTips($re, $str, $url);
    }

    //添加用户
    public function showAdd(){

        $this->display('user/add.html');
    }

    //添加处理用户
    public function showAdh(){
        $nickname = htmlspecialchars($_POST['nickname']);
        $acc =htmlspecialchars( addslashes($_POST['acc']));
        $pwd = htmlspecialchars(addslashes(md5($_POST['pwd'])));
        $is_admin = htmlspecialchars($_POST['is_admin']);
        $regtime = time();

        $condition = "null, '{$acc}','{$pwd}','{$nickname}','{$is_admin}',{$regtime}";

        //调用图像
        $img = '';
        if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
            $UpFileTool = M('UpFileTool');
            $img = $UpFileTool->upfile($_FILES['img']);
        }

        if ($img) {
            $condition .= ",'{$img}'";
        }

        //new UserModel模型类对象
        $UserModel = M('UserModel');
        $sql = "insert into sp_user value ($condition)";
        $re = $UserModel->setData($sql);

        if ($re) {
            $str = "新增用户 {$nickname} 成功！";
        } else {
            $str = "新增用户 {$nickname} 失败，请联系管理员！";
        }

        $url = C('URL.main') . "/index.php/?p=admin&m=user&a=showList";

        $this->showTips($re, $str, $url);
    }
}