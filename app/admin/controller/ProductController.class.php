<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 17:05
 */

namespace admin\controller;

use core\Controller;

class ProductController extends Controller {
    public function showList(){

        $model = M('ProductModel');

        # 分页相关
        $nowPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $numPerPage = 5;
        $sql = "select count(*) AS num from sp_goods_info where 1";
        $num = $model->getRow($sql)['num'];
        $totalPage = (int)ceil($num / $numPerPage);
        $url = C('URL.main') . "/index.php?p=admin&m=product&a=showList&page";
        $pageHtml = pageHtml($nowPage, $totalPage, $url);

        # 展示数据
        $x = ($nowPage - 1) * $numPerPage;
        $sql = "select p.id, p.name, p.ori_price, p.price, p.status, p.add_time, c.name AS c_name from sp_goods_info AS p join sp_category AS c on p.category_id=c.id order by add_time desc limit {$x}, {$numPerPage}";
        $p_data = $model->getRows($sql);

        $this->assign('pageHtml', $pageHtml);
        $this->assign('p_data', $p_data);
        $this->display('product/list.html');
    }

    public function showAdd(){
        $this->display('product/add.html');
    }

    public function add_h(){

        $name = htmlEncode($_POST['name']);
        $ori_price = htmlEncode($_POST['ori_price']) / 100;
        $price = htmlEncode($_POST['price']) / 100;
        $c_id = $_POST['c_id'];
        $status = $_POST['status'];
        $intro = htmlEncode($_POST['intro']);
        $description = htmlEncode($_POST['description']);
        $add_time = time();

        $img = '';
        if (isset($_FILES['img']) && !empty($_FILES['img']['name'])){
            $upTool = M('UpFileTool');
            $img = $upTool->upfile($_FILES['img']);
        }

        $sql = "insert into sp_goods_info value(null, '{$name}', '{$intro}', '{$description}', {$price}, {$c_id}, 0, '{$img}', {$add_time}, {$status}, {$ori_price})";

        $model = M('ProductModel');
        $re = $model->setData($sql);

        if ($re) {
            $str = '新增成功！';
        } else {
            $str = '新增失败！';
        }

        $jumpUrl = C('URL.main') . "/index.php?p=admin&m=product&a=showList";
        $this->showTips($re, $str, $jumpUrl);
    }

    public function showEdit(){

        $id = $_GET['id'];

        $sql = "select * from sp_goods_info where id={$id}";

        $model = M('ProductModel');
        $p_data = $model->getRow($sql);

        $this->assign('p_data', $p_data);
        $this->display('product/edit.html');
    }

    public function upd_h(){

        $id = $_GET['id'];
        $name = htmlEncode($_POST['name']);
        $ori_price = htmlEncode($_POST['ori_price']);
        $price = htmlEncode($_POST['price']);
        $c_id = $_POST['c_id'];
        $status = $_POST['status'];
        $intro = htmlEncode($_POST['intro']);
        $description = htmlEncode($_POST['description']);
        $add_time = time();

        $img = '';
        if (isset($_FILES['img']) && !empty($_FILES['img']['name'])){
            $upTool = M('UpFileTool');
            $img = $upTool->upfile($_FILES['img']);
        }

        $sql = "update sp_goods_info set name='{$name}', intro='{$intro}', descript='{$description}', price={$price}, category_id={$c_id}, is_collection=0, img='{$img}', add_time={$add_time}, status={$status}, ori_price={$ori_price} where id={$id}";

        $model = M('ProductModel');
        $re = $model->setData($sql);

        if ($re) {
            $str = '修改成功！';
        } else {
            $str = '修改失败！';
        }

        $jumpUrl = C('URL.main') . "/index.php?p=admin&m=product&a=showList";
        $this->showTips($re, $str, $jumpUrl);
    }

    public function del_h(){

        $id = $_GET['id'];

        $sql = "delete from sp_goods_info where id={$id}";

        $model = M('ProductModel');
        $re = $model->setData($sql);

        if ($re) {
            $str = '删除成功！';
        } else {
            $str = '删除失败！';
        }

        $jumpUrl = C('URL.main') . "/index.php?p=admin&m=product&a=showList";
        $this->showTips($re, $str, $jumpUrl);
    }
}