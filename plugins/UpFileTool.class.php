<?php

namespace plugins;//  创建了一个   全局空间  下的  plugins空间

/**
 * 实现文件上传的工具类
 * 1.检查系统错误
 * 2.检查逻辑错误
 * 3. 构建绝对不重复的新的文件名
 * 4. 转移文件到指定的目录下
 */
class UpFileTool{

    private $limitType;//限定的格式类型
    private $limitSize;//限定文件的大小
    private $path;//文件上传转移的目录路径

    public function __construct(){ 
        
        $this->limitType = C('upF.limitType');
        $this->limitSize = C('upF.limitSize');
        $this->path = C('upF.path');
    }
    /**
     * @param  array   $file   上传文件所包含的文件数据信息
            包含5个元素的信息：
                    $file['name']    string    表示上传文件的源文件名，例：$file['name']='a.jpg';
                    $file['type']   string    表示上传文件所属的格式类型，例：$file['type']='image/jpeg';
                    $file['tmp_name']  string   表示上传文件存储在临时目录中的全路径，例：$file['tmp_name']='C:\Windows\Temp\phpB636.tmp'
                    $file['error']   int   表示上传文件时出现的错误码值，错误码值所代表的含义如下：
                                    0   表示没有错误
                                    1   表示文件的大小超过了服务器的限定
                                    2    表示文件的大小超过了浏览器的限定
                                    3   表示文件没有上传完毕
                                    4    表示没有选择上传的文件
                                    6和7    表示服务器出现错误，导致上传失败
                    $file['size']    int     表示上传文件的文件大小，例：$file['size']=100(KB)*1024, 单位为字节
     * @return BOOL
     */
    public function upfile($file){ 
        
        //调用检查系统错误的方法
        $this->checkErr($file['error']);

        //调用检查逻辑错误的方法
        $this->checkLogic($file['type'], $file['size']);

        //构建绝对不重复的文件名
        $fileName = uniqid('img_') . date('YmdHis') . mt_rand(0, 10000) . strchr($file['name'], '.');

        //转移文件到指定的目录
        $whoFileName = $this->path . '/' . $fileName;
        if( move_uploaded_file($file['tmp_name'], $whoFileName) ){//文件上传成功
//            echo '上传文件成功';
            return $fileName;
        }else{//上传失败
            //echo '上传失败，请联系管理员';
            return false;
        }

    }

    //检查逻辑错误的方法     image/jpeg
    private function checkLogic($type, $size){ 
        
        //检查格式类型是否符合要求
        if( !in_array($type, $this->limitType) ){
            exit('文件格式不符合限定的要求');
        }

        //检查文件的大小是否符合要求
        if( $size>$this->limitSize ){
            $msg = '文件的大小超过了'.$this->limitSize.'字节';
            exit($msg);
        }

    }

    //检查系统错误
    private function checkErr($err){ 
        
        switch ( $err ){
            case 1:
                exit('表示文件的大小超过了服务器的限定'); 
            case 2:
                exit('表示文件的大小超过了浏览器的限定');
            case 3:
                exit('表示文件没有上传完毕');
            case 4:
                exit('表示没有选择上传的文件');
            case 6:
                case 7:
                exit('表示服务器出现错误，导致上传失败');
        }
    }
}