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
        $this->display('product/productIndex.html');
    }

    public function showAdd(){
        $this->display('product/productAdd.html');
    }

    public function showEdit(){
        $this->display('product/productEdit.html');
    }
}