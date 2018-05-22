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
    }
}