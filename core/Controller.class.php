<?php

namespace core;//创建一个  全局空间  下的  core空间
use \Smarty;//引入 全局空间  下的 Smarty类

class Controller extends Smarty{
    //protected $smarty;

    public function __construct(){

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

        $this->left_delimiter = '{<';
        $this->right_delimiter = '>}';
    }
}