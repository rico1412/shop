<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 15:02
 */
namespace admin\controller;

use core\Controller;

class CategoryController extends Controller {
    public function showList(){
        $this->display('category/list.html');
    }
}