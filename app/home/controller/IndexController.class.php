<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/22
 * Time: 10:00
 */

namespace home\controller;

use core\Controller;

class IndexController extends Controller {
    public function index(){
        $this->display('index.html');
    }
}