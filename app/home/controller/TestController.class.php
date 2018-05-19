<?php

namespace home\controller;//创建一个  全局空间  下的  home空间  下的  controller空间
use \core\Controller;

class TestController extends Controller{
    //展示前台首页相关
    public function showTest(){ 

        $model = \core\App::single('\\model\\TestModel');
        echo '测试模型对象：'; 
        var_dump( $model ); 
        echo '<hr/>';
        echo '验证码测试展示：<img src="'.C('URL.main').'/index.php?p=home&m=test&a=captchaTest" /><hr/>'; 
        echo '恭喜您，框架部署成功！'; 
    }
    public function captchaTest(){
        $o = \core\App::single('\\plugins\\CaptchaTool');
        $o->output();
    }
}