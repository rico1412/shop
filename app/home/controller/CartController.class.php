<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/23
 * Time: 9:35
 */

namespace home\controller;


class CartController extends HomeController {
    public function showCart(){

        $this->display('cart.html');
    }

    public function del_h(){
        $id = $_GET['id'];

        $cartUnSer = isset($_COOKIE['Cart']) ? unserialize($_COOKIE['Cart']) : array();

        if (!empty($cartUnSer) || !isset($cartUnSer[$id])){
            unset($cartUnSer[$id]);
            $cart = serialize($cartUnSer);
            setcookie('Cart', $cart, time() + 7*24*3600);
            echo "<script>alert('商品删除成功！！');location.href='" . C('URL.main') . "/index.php/?p=home&m=cart&a=showCart'</script>";
        } else {
            echo "<script>alert('无法删除该商品！！');location.href='" . C('URL.main') . "/index.php/?p=home&m=cart&a=showCart'</script>";
        }
    }
}