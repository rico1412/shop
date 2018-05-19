<?php

namespace core;//创建一个  全局空间  下的  core空间

class App{
    
    private static $_obj=[];//构建私有化的一个成员属性，用来保存别的类实例化出来的对象
    //time   1                    admin\controller\NewsController
    //time   2                    admin\controller\UserController
    //time   3                    admin\controller\NewsController
    public static function single($className){ 
        
        //time 1    self::$_obj['admin\controller\NewsController']
        //time 2    self::$_obj['admin\controller\UserController']
        //time 3    self::$_obj['admin\controller\NewsController']
        if( !isset(self::$_obj[$className]) ){//判断$_obj静态成员属性保存的  是否是 $className所代表的类  实例化出来的对象
            //time  1   self::$_obj['admin\controller\NewsController']= new admin\controller\NewsController;
            //time  2   self::$_obj['admin\controller\UserController']= new admin\controller\UserController;
            self::$_obj[$className] = new $className;
        }
        return self::$_obj[$className];
    }

    /**
     * 自动加载静态成员方法
     * @param  $className   string  表示被使用到的类名
     */
     //                                     model\NewsModel
     //                                    admin\controller\NewsController
    public static function autoL($className){ 

        $oriClassName = basename($className);//    NewsController    NewsModel

        if( substr($oriClassName, -10)=='Controller' ){//处理所有的控制器类
            
            //                  NewsController   .class.php
            $fileName = $oriClassName . '.class.php';
            //          mvc/app/     (home或admin)      /controller/
            $path = APP_PATH . $GLOBALS['plat'] . '/controller/';
            //   mvc/app/admin/controller/  NewsController.class.php
            $wholeFileName = $path . $fileName;
            include $wholeFileName;//引入控制器类文件
        }elseif( substr($oriClassName, -5)=='Model' ){//处理所有的模型类
            
            //                   NewsModel        .class.php
            $fileName = $oriClassName . '.class.php';
            //            mvc/app/model/
            $path = APP_MODEL_PATH;
            //           mvc/app/model/   NewsModel.class.php
            $wholeFileName = $path . $fileName;
            include $wholeFileName;//引入模型类文件
        }elseif( substr($oriClassName, -4)=='Tool' ){

            //                  UpFileTool          .class.php
            $fileName = $oriClassName . '.class.php';
            //            mvc/plugins
            $path =  PLUGINS_PATH; 
            $wholeFileName = $path . $fileName;
            include $wholeFileName;//引入工具类文件
        }
    }

    //启动方法
    public static function run(){ 
        #构建灵活的  动作  参数
        //$action = isset($_GET['a']) ? $_GET['a'] : 'showList';
        //$action = isset($_GET['a']) ? $_GET['a'] : $config['web']['a'];
        $GLOBALS['action'] = $action = isset($_GET['a']) ? $_GET['a'] : C('web.a');

        #构建灵活的  模块  参数
        //$module = isset($_GET['m']) ? ucfirst($_GET['m']) : 'News';
        //$module = isset($_GET['m']) ? ucfirst($_GET['m']) : $config['web']['m'];
        $GLOBALS['module'] = $module = isset($_GET['m']) ? ucfirst($_GET['m']) : C('web.m');

        #构建灵活的  平台  参数
        //$plat = isset($_GET['p']) ? $_GET['p'] : 'admin';
        //$plat = isset($_GET['p']) ? $_GET['p'] : $config['web']['p'];
        $GLOBALS['plat'] = $plat = isset($_GET['p']) ? $_GET['p'] : C('web.p');

        #测试访问
        //$controller = new NewsController;
        //$controller = new \admin\controller\NewsController;
        //$className = '\\admin\\controller\\'.$module.'Controller';
        $className = '\\'.$plat.'\\controller\\'.$module.'Controller';//   \admin\controller\NewsController
        //$controller = new $className;
        $controller = self::single($className);

        //$controller->showList();//列表页
        //$controller->showAd();//添加页
        $controller->$action();
    }

}