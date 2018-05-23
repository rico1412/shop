<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/22
 * Time: 14:48
 */

namespace home\controller;


class ShowController extends HomeController {
    public function about(){
        $this->display('about.html');
    }

    public function blog(){
        $this->display('blog.html');
    }

    public function contact(){
        $this->display('contact.html');
    }
}