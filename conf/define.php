<?php

#定义目录常量
//                          mvc/conf/
//define('ROOT', dirname(__FILE__).'/');//网站的根目录常量
//                            mvc/
define('ROOT', dirname(dirname(__FILE__)).'/');//网站的根目录常量

define('APP_PATH', ROOT.'app/');// 相当于 mvc/app/
define('CORE_PATH', ROOT.'core/');// 相当于 mvc/core/
define('PLUGINS_PATH', ROOT.'plugins/');// 相当于 mvc/plugins/
define('CONF_PATH', ROOT.'conf/');// 相当于 mvc/conf/
define('PUBLIC_PATH', ROOT.'public/');// 相当于 mvc/public/

define('APP_ADMIN_PATH', APP_PATH . 'admin/');//  相当于 mvc/app/admin/
define('APP_MODEL_PATH', APP_PATH . 'model/');//  相当于 mvc/app/model/
define('APP_HOME_PATH', APP_PATH . 'home/');//  相当于 mvc/app/home/

define('APP_ADMIN_CONTROLLER_PATH', APP_ADMIN_PATH . 'controller/');//  相当于 mvc/app/admin/controller/
define('APP_ADMIN_VIEW_PATH', APP_ADMIN_PATH . 'view/');//  相当于 mvc/app/admin/view/

define('APP_HOME_CONTROLLER_PATH', APP_HOME_PATH . 'controller/');//  相当于 mvc/app/home/controller/
define('APP_HOME_VIEW_PATH', APP_HOME_PATH . 'view/');//  相当于 mvc/app/home/view/
