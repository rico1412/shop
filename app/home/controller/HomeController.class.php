<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/22
 * Time: 14:37
 */

namespace home\controller;

use core\Controller;

class HomeController extends Controller {
    public function __construct(){
        parent::__construct();

        # 展示分类
        $c_model = M('CatModel');
        $cats = $c_model->getCatsArr();

        $this->assign('cats', $cats);

        $totalPrice = 0;
        $data = [];
        if (isset($_COOKIE ['Cart'])){
            $cookie = stripslashes($_COOKIE ['Cart']); //去除addslashes添加的反斜杠
            $cartUnSer = unserialize($cookie);//反序列化cookie

            $ProductsModel = M('ProductsModel');
            foreach ($cartUnSer as $val) {
                $num = $val['qtybutton'];
                $id = $val['id'];
                $sql = "select * from sp_goods_info where id={$id}";
                $row = $ProductsModel->getRow($sql);
                $row['qtybutton'] = $num;
                $data[] = $row;

                $totalPrice += ($row['price'] * $row['qtybutton']);
            }

        }
        $this->assign('totalPrice', $totalPrice);
        $this->assign('cart_datas', $data);
    }

    public function checkLogin(){
        @session_start();
        if (!isset($_SESSION['home'])){
            echo "<script>alert('您尚未登录，请先登录！！');location.href='" . C('URL.main') . "/index.php/?p=home&m=login&a=login'</script>";
            return false;
        }
        return true;
    }
}