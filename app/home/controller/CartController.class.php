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
}