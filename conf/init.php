<?php

//引入常量配置文件
include './conf/define.php';

include CONF_PATH . 'path.php';

//引入主配置文件
include CONF_PATH . 'conf.php';

//引入框架内置函数文件
include CORE_PATH . 'Func.php';

//引入核心框架类文件
include CORE_PATH . 'App.class.php';
spl_autoload_register('\core\App::autoL');//注册自动加载静态方法

//引入文件上传工具类
//include PLUGINS_PATH . 'UpFileTool.class.php';
//include PLUGINS_PATH . 'CaptchaTool.class.php';

//引入smarty3.0核心类文件
include PLUGINS_PATH . 'smarty/Smarty.class.php';

//引入Controller.class.php公共控制器类文件（父类控制器）
include CORE_PATH . 'Controller.class.php';

//引入Model.class.php公共模型文件（父类模型）
include CORE_PATH . 'Model.class.php';

//引入NewsModel模型类文件
//include APP_MODEL_PATH . 'NewsModel.class.php';

//引入NewsController控制器类文件
//include './app/admin/controller/NewsController.class.php';
//include APP_ADMIN_CONTROLLER_PATH . 'NewsController.class.php';
//include APP_PATH . 'home/controller/IndexController.class.php';