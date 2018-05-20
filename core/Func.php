<?php


/**
 * 读取全局变量的函数
 * @param   $str    string    表示全局变量的变量名部分
 * @return mixed
 */
function G($str){

    return $GLOBALS[$str];
}

/**
 * 读取配置项参数的函数
 * @param   $str    string    配置项下标以"."分隔的字符串；例: $str='db.type'
 * @return string
 */
function C($str){ 
    $arr = explode('.', $str);

    $target = G('config');

    foreach( $arr as $v ){ 
        $target = $target[$v];
    }
    return $target;
}

/**
 * @param $className
 * @return mixed
 */
function M($className){

    $oriClassName = basename($className);//    NewsController    NewsModel

    if( substr($oriClassName, -5)=='Model' ){//处理所有的模型类

        $oriClassName = '\\model\\' . $oriClassName;
    }elseif( substr($oriClassName, -4)=='Tool' ){

        $oriClassName = '\\plugins\\' . $oriClassName;
    }

    return \core\App::single($oriClassName);
}

function htmlEncode($str){
    return htmlspecialchars(trim($str));
}

function htmlDecode($str){
    return htmlspecialchars_decode($str);
}

/**
 * 分页函数
 * @param  $nowPage  int  当前页
 * @param  $totalPage  int  总页数
 * @param  $url  string  跳转的连接，例：http://www.home.com/class/day2/code/page.php?xxx=xxx&xxx=xxx&page
 * @return string
 */
function pageHtml($nowPage, $totalPage, $url){

    $totalPage = $totalPage == 0 ? 1 : $totalPage;

    #构建左半边部分
    //左半边需要的参数
    $preOnePage = $nowPage - 1;//当前页的上一页
    $preTwoPage = $nowPage - 2;//当前页的上上页

    if ($nowPage == 1) {//当前页为左边界
        $leftHtml = "";
    } elseif ($preOnePage == 1) {//当前页的上一页为左边界
        $leftHtml = "<a href='$url=$preOnePage'>上一页</a>";
        $leftHtml .= "<a href='$url=$preOnePage'>$preOnePage</a>";
    } elseif ($preTwoPage == 1) {//当前页的上上页为左边界
        $leftHtml = "<a href='$url=$preOnePage'>上一页</a>";
        $leftHtml .= "<a href='$url=$preTwoPage'>$preTwoPage</a>";
        $leftHtml .= "<a href='$url=$preOnePage'>$preOnePage</a>";
    } else {//其他情况
        $leftHtml = "<a href='$url=$preOnePage'>上一页</a>";
        $leftHtml .= "... ";
        $leftHtml .= "<a href='$url=$preTwoPage'>$preTwoPage</a>";
        $leftHtml .= "<a href='$url=$preOnePage'>$preOnePage</a>";
    }

    #构建当前页部分
    $nowHtml = "<span class='current'>$nowPage</span>";

    #构建右半边的部分
    //右半边需要的参数
    $nextOnePage = $nowPage + 1;//当前页的下一页
    $nextTwoPage = $nowPage + 2;//当前页的下下页

    if ($nowPage == $totalPage) {//当前页为右边界
        $rightHtml = "";
    } elseif ($nextOnePage == $totalPage) {//当前页的下一页为右边界
        $rightHtml = "<a href='$url=$nextOnePage'>$nextOnePage</a>";
        $rightHtml .= "<a href='$url=$nextOnePage'>下一页</a>";
    } elseif ($nextTwoPage == $totalPage) {//当前页的下下页为右边界
        $rightHtml = "<a href='$url=$nextOnePage'>$nextOnePage</a>";
        $rightHtml .= "<a href='$url=$nextTwoPage'>$nextTwoPage</a>";
        $rightHtml .= "<a href='$url=$nextOnePage'>下一页</a>";
    } else {//其他情况
        $rightHtml = "<a href='$url=$nextOnePage'>$nextOnePage</a>";
        $rightHtml .= "<a href='$url=$nextTwoPage'>$nextTwoPage</a>";
        $rightHtml .= "... ";
        $rightHtml .= "<a href='$url=$nextOnePage'>下一页</a>";
    }

    //拼接分页HTML
    $pageHtml = $leftHtml . $nowHtml . $rightHtml;

    return $pageHtml;
}