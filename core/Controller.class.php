<?php

namespace core;//创建一个  全局空间  下的  core空间
use \Smarty;//引入 全局空间  下的 Smarty类

class Controller extends Smarty{
    //protected $smarty;

    public function __construct(){

        $this->checkLogin();

        #解决父类构造方法被重写
        parent::__construct();

        #调用smarty展示视图模板文件
        //$this->smarty = new \Smarty;
        //$templateDir = APP_ADMIN_PATH.'view';//   mvc/app/admin/view
        //                    mvc/app/          (home或admin)       /view
        //$templateDir = APP_PATH . $GLOBALS['plat'] . '/view';
        $templateDir = APP_PATH . G('plat') . '/view';

        //$this->smarty->setTemplateDir($templateDir);//设置存放后台模板文件的目录全路径
        $this->setTemplateDir($templateDir);//设置存放后台模板文件的目录全路径

        //$compileDir = APP_ADMIN_PATH.'view_c';//  mvc/app/admin/view_c
        //                   mvc/app       (home或admin)      /view_c
        //$compileDir = APP_PATH . $GLOBALS['plat'] . '/view_c';
        $compileDir = APP_PATH . G('plat') . '/view_c';

        //$this->smarty->setCompileDir($compileDir);//设置存放后台模板编译缓存文件的全路径
        $this->setCompileDir($compileDir);//设置存放后台模板编译缓存文件的全路径
    }

    /**
     * 检查用户是否需要登录的方法
     */
    private function checkLogin(){

        @session_start();
        if (!isset($_SESSION['admin']) && !(G('plat') == 'home' || G('module') == 'Privilege')) {

            if (isset($_COOKIE['rememberMe']) && $_COOKIE['rememberMe']) {
                $sql = "select * from bl_user where id={$_COOKIE['rememberMe']}";
                $model = M('\\model\\UserModel');
                $row = $model->getRow($sql);

                $_SESSION['admin'] = $row;
            }

            echo "当前未登录，请先登录！";
            $url = C('URL.main') . '/index.php?p=admin&m=privilege&a=showLogin';
            header("Refresh: 2; url={$url}");
            exit;
        }
    }
}