<?php

namespace plugins;
/**
 * 制作者：wx
 * 制作时间: 2018/5/2
 *  实现功能：制作验证码
 */
class CaptchaTool{

    private $_w;//画布的宽度
    private $_h;//画布的高度

    private $_fontFile;//写字的字体文件绝对路径

    private $_img;//保存画布资源的属性

    public function __construct(){ 
        
        #初始化画布宽高参数
        $this->_w = C('captcha.w');
        $this->_h = C('captcha.h');

        #初始化字体文件绝对路径参数
        $this->_fontFile = C('captcha.fontFile');

        #调用创建画布的方法
        $this->mkImg();

        #调用填充背景色的方法
        $this->imgFill();

        #调用写字的方法
        $this->writeStr();

        #调用画干扰点的方法
        $this->setPoint(600);

        #调用画干扰线的方法
        $this->setLine(20);

        #调用画干扰弧线的方法
        $this->setArc();
    }

    /**
     * 设置干扰弧线的方法
     * @param  $num  int   表示画弧线的条数，默认值为10
     */
    private function setArc($num=10){ 

        for($i=0; $i<$num; $i++ ){ 
            $cx = mt_rand($this->_w/3, $this->_w*2/3);//圆心点的x坐标
            $cy = mt_rand($this->_h/3, $this->_h*2/3);//圆心点的y坐标

            $w = mt_rand(0, $this->_w);//椭圆的宽度
            $h = mt_rand(0, $this->_h);//椭圆的高度

            $s = mt_rand(0, 120);//起始点与圆心的连线  和  x轴 的夹角
            $e = mt_rand(200, 360);//终点与圆心的连线  和  x轴 的夹角

            $col = $this->getColor();//分配画弧线的颜色

            imagearc($this->_img, $cx, $cy, $w, $h, $s, $e, $col);
        }
    }

    /**
     * 设置干扰线的方法
     * @param  $num  int   表示画线的个数，默认值为20
     */
    private function setLine($num=20){ 
        
        for($i=0; $i<$num; $i++ ){ 
            $bx = mt_rand(0, $this->_w/2);//起始点的x坐标
            $by = mt_rand(0, $this->_h);//起始点的y坐标

            $ex = mt_rand($this->_w/2, $this->_w);//终点的x坐标
            $ey = mt_rand(0, $this->_h);//终点的y坐标

            $col = $this->getColor();//分配一个画点的随机色

            imageline($this->_img, $bx, $by, $ex, $ey, $col);
        }
    }

    /**
     * 设置干扰点的方法
     * @param  $num  int   表示画点的个数，默认值为100
     */
    private function setPoint($num=100){ 
        
        for($i=0; $i<$num; $i++ ){ 
            $bx = mt_rand(0, $this->_w);//起始点的x坐标
            $by = mt_rand(0, $this->_h);//起始点的y坐标

            $ex = mt_rand($bx-2, $bx+2);//终点的x坐标
            $ey = mt_rand($by-2, $by+2);//终点的y坐标

            $col = $this->getColor();//分配一个画点的随机色

            imageline($this->_img, $bx, $by, $ex, $ey, $col);
        }
    }

    /**
     *  写验证码文字的方法
     * @param  $num   int   表示构建字符的个数，比如$num=4，则验证码构建的字符数应该为4个
     */
    private function writeStr($num=4){ 
        
        //创建指定字符个数的随机字
        $allStr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));//构建字符采集库
        $str = '';
        for($i=0; $i<$num; $i++ ){ 
            $key = mt_rand(0, count($allStr)-1);
            $str .= $allStr[$key];
        }

        //存储验证码到session中
        @session_start();
        $_SESSION['captcha_code'] = $str;

        //分配一个写字的随机色
        $col = $this->getColor();

        //将字符写到画布上
        $bx = $this->_w*C('captcha.str_b_x');//写字左下角起始点的x坐标
        $by = $this->_h*C('captcha.str_b_y');//写字左下角起始点的y坐标
        $fontSize = $this->_w * C('captcha.str_size');//字体大小与画布宽度的比例为3:15
        /*
            300/40 = $this->_w/?
            ? = $this->_w / (300/40)
            ? = $this->_w*2/15;
        */
        imagettftext($this->_img, $fontSize, 0, $bx, $by, $col, $this->_fontFile, $str);
    }

    /**
     * 填充背景色方法
     */
    private function imgFill(){ 
        #分配指定的颜色
        $col = $this->getColor();
        #填充背景色
        imagefill($this->_img, 0, 0, $col);
    }

    /**
     *  得到分配的颜色方法
     * @param  $r  int   表示光的三原色的红色色值，取值范围是0～255
     * @param  $g  int   表示光的三原色的绿色色值，取值范围是0～255
     * @param  $b  int   表示光的三原色的蓝色色值，取值范围是0～255
     */
    private function getColor($r='', $g='', $b=''){ 
        //如果指定了颜色，则直接使用指定的颜色；如果没指定颜色（为空字符串时），则给一个随机色
        $r = ($r==='') ? mt_rand(0, 255) : $r;
        $g = ($g==='') ? mt_rand(0, 255) : $g;
        $b = ($b==='') ? mt_rand(0, 255) : $b;

        $color = imagecolorallocate($this->_img, $r, $g, $b);
        return $color;
    }

    /**
     *  创建画布的方法
     */
    private function mkImg(){ 
        //创建真彩色画布资源                           画布的宽      画布的高    （单位像素）
        $this->_img = imagecreatetruecolor($this->_w, $this->_h);
    }

    /**
      * 输出图像的方法
     * @param  $type  int   表示输出图像的方式，0表示直接将图像输出到浏览器；1表示将图像保存成jpeg格式的图片
     */
    public function output($type=0, $path='F:/home/class/day25/code/'){ 

        if( $type==0 ){
            header('Content-type:image/jpeg');
            imagejpeg($this->_img);
        }else{
             
            $fileName = $path . uniqid('captcha_') . date('YmdHis') . mt_rand(0, 1000) . '.jpg';//构建不重复的图片名字和路径
            imagejpeg($this->_img, $fileName);
            echo '已保存成图片文件，请到'.$path.'目录下去查看';
        }
    }
    #析构方法，销毁画布资源
    public function __destruct(){ 
        imagedestroy($this->_img);
    }
}
