<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/22
 * Time: 15:17
 */

namespace home\controller;


class AccountController extends HomeController {
    public function show(){
        if (!$this->checkLogin()){
            exit;
        }

        $this->display('account.html');
    }
}