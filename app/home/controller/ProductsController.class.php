<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 16:27
 */

namespace home\controller;


use core\Controller;

class ProductsController extends Controller {
    public function showList(){
        $this->display('shopList.html');
    }
}