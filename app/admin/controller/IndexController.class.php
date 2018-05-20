<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/20
 * Time: 9:35
 */

namespace admin\controller;

use core\Controller;

class IndexController extends Controller {
    public function index(){
        $this->display('index.html');
    }
}