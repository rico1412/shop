<?php

namespace core;//创建一个  全局空间  下的  core空间

class Model{
    //连接数据库参数属性
    protected $_type;
    protected $_host;
    protected $_port;
    protected $_char;
    protected $_dbname;
    protected $_acc;
    protected $_pwd;
    //操作数据库的参数属性
    protected $_pdo;
    protected $_pdostatement;
    public function __construct($type='', $host='', $port='', $char='', $dbname='', $acc='', $pwd=''){ 
        #初始化属性参数
        //$this->_type = ($type==='') ? $GLOBALS['config']['db']['type'] : $type;
        //$this->_host = ($host==='') ? $GLOBALS['config']['db']['host'] : $host;
        //$this->_port = ($port==='') ? $GLOBALS['config']['db']['port'] : $port;
        //$this->_char = ($char==='') ? $GLOBALS['config']['db']['char'] : $char;
        //$this->_dbname = ($dbname==='') ? $GLOBALS['config']['db']['dbname'] : $dbname;
        //$this->_acc = ($acc==='') ? $GLOBALS['config']['db']['acc'] : $acc;
        //$this->_pwd = ($pwd==='') ? $GLOBALS['config']['db']['pwd'] : $pwd;

        $this->_type = ($type==='') ? C('db.type') : $type;
        $this->_host = ($host==='') ? C('db.host') : $host;
        $this->_port = ($port==='') ? C('db.port') : $port;
        $this->_char = ($char==='') ? C('db.char') : $char;
        $this->_dbname = ($dbname==='') ? C('db.dbname') : $dbname;
        $this->_acc = ($acc==='') ? C('db.acc') : $acc;
        $this->_pwd = ($pwd==='') ? C('db.pwd')    : $pwd;
        //实例化PDO类的对象
        //$dsn = "mysql:host=localhost;port=3306;charset=utf8;dbname=db1";
        $dsn = "{$this->_type}:host={$this->_host};port={$this->_port};charset={$this->_char};dbname={$this->_dbname}";
        $this->_pdo = new \PDO($dsn, $this->_acc, $this->_pwd);

        #设置属性（将错误处理模式调整为异常处理模式）
        $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 实现设置操作（增，删，改操作）
     * @param $sql  string   表示（增，删，改）操作的sql语句
     * @return Bool
     */
    public function setData($sql){ 
        
        try{
            $this->_pdo->exec($sql);
        }catch(\PDOException $err){
            $str = "==================发生错误的时间：" . date('Y-m-d H:i:s') . "\r\n";
            $str .= "错误信息：" . $err->getMessage() . "\r\n";
            $str .= "错误码值：" . $err->getCode() . "\r\n";
            $str .= "错误的行号：" . $err->getLine() . "\r\n";
            $str .= "出错的文件路径：" . $err->getFile() . "\r\n";
            file_put_contents('./b.log', $str, FILE_APPEND);
            return false;
        }
        return true;
    }

    /**
     *  获取一条数据的操作
     * @param  $sql   string   表示（查询一条数据的）操作的sql语句
     * @return array
     */
    public function getRow($sql){ 
        
        try{
            $this->_pdostatement = $this->_pdo->query($sql);//执行sql语句
        }catch(\PDOException $err){
            $str = "==================发生错误的时间：" . date('Y-m-d H:i:s') . "\r\n";
            $str .= "错误信息：" . $err->getMessage() . "\r\n";
            $str .= "错误码值：" . $err->getCode() . "\r\n";
            $str .= "错误的行号：" . $err->getLine() . "\r\n";
            $str .= "出错的文件路径：" . $err->getFile() . "\r\n";
            file_put_contents('./b.log', $str, FILE_APPEND);
            return false;
        }

        return $this->_pdostatement->fetch(\PDO::FETCH_ASSOC);//返回解析得到的一条数据
    }

    /**
     *  获取多条数据的操作
     * @param  $sql   string   表示（查询多条数据的）操作的sql语句
     * @return array
     */
    public function getRows($sql){ 
        
        try{
            $this->_pdostatement = $this->_pdo->query($sql);//执行sql语句
        }catch(\PDOException $err){
            $str = "==================发生错误的时间：" . date('Y-m-d H:i:s') . "\r\n";
            $str .= "错误信息：" . $err->getMessage() . "\r\n";
            $str .= "错误码值：" . $err->getCode() . "\r\n";
            $str .= "错误的行号：" . $err->getLine() . "\r\n";
            $str .= "出错的文件路径：" . $err->getFile() . "\r\n";
            file_put_contents('./b.log', $str, FILE_APPEND);
            return false;
        }

        return $this->_pdostatement->fetchAll();//返回解析得到的多条数据
    }
}