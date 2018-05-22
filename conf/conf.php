<?php
#构建配置数组
$config = array(

    //数据库配置
    'db' => [
        'type' =>  'mysql',//数据库类型
        'host' =>  '192.168.64.38',//数据库IP地址
        'port' =>  3306,//端口号
        'char' =>  'utf8',//字符集
        'dbname' =>  'shop',//默认选择的数据库
        'acc' =>  'root',//账号
        'pwd' =>  '123'//密码
    ],

    //默认访问的页面
    'web' => [
        'p' => 'admin',//默认的平台参数
        'm' => 'Index',//默认的模块参数
        'a' => 'index'//默认的动作参数
    ],

    //文件上传配置
    'upF' => [
        'limitType' => ['image/jpeg', 'image/png'],//限定的文件类型
        'limitSize' => 300*1024,//限定的文件大小200K
        'path' => $root_path . 'public/admin/img'//上传文件存放的目录路径
    ],
    //网站域名配置项
    'URL' => [
        'main' => 'http://shop.com'//站点的主域名
    ],
    //验证码配置
    'captcha' => [
        'w' => 200,//验证码画布的宽度
        'h' => 120,//验证码画布的高度
        'fontFile'=> $root_path . 'public/msyh.ttc',//验证码字体文件路径
        'str_b_x' => 1/11,//字符起点x坐标占宽度的比例
        'str_b_y' => 13/20,//字符起点y坐标占高度的比例
        'str_size' => 4/15//字体大小占画布宽度的比例
    ]
);