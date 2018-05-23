<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/23
 * Time: 9:56
 */

namespace home\controller;


class CheckoutController extends HomeController {
    public function checkout(){
        if (!$this->checkLogin()){
            exit;
        }
        $this->display('checkout.html');
    }
}