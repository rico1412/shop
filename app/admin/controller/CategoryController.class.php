<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 15:02
 */
namespace admin\controller;

use core\Controller;

class CategoryController extends Controller {
    public function showList(){

    	//调用模型查询数据
    	$catModel=M('CatModel');// $catModel=\core\App::single('\\model\\CatModel');


        // $nowPage=isset($_GET['page'])?$_GET['page']:1;//当前页未选定默认为1
        // $numPerPage=7;//每页最大显示数据条数
        //计算总页数
        // $sql="select count(*) as num from sp_category where 1";
        // $data=$catModel->getRow($sql);
        // $totalPage=intval(ceil($data['num']/$numPerPage));//总页数
        // $x=($nowPage-1)*$numPerPage;//偏移量
        // $url=C('URL.main').'/index.php?p=admin&m=index&a=showList&page';
        // $pageHtml=pageHtml($nowPage,$totalPage,$url);
        // $sql="select c.id,c.name,c.parent_id,g.category_id from sp_category as c join sp_goods_info as g on c.parent_id=g.category_id order by g.category_id limit {$x},{$numPerPage}";
        // $rows=$catModel->getRows($sql);
        /*echo "<pre />";
        var_dump($rows);die;*/
        // $firstRowNum=($nowPage-1)*$numPerPage+1;//当前页第一条数据的序号

    	$tree=$catModel->getCats();
    	//分配数据
    	$this->assign('categorys',$tree);
    	// $this->assign('pageHtml',$pageHtml);
       	// $this->assign('rows',$tree);
    	// $this->assign('firstRowNum',$firstRowNum);
        $this->display('category/list.html');
    }


    //编辑功能
    public function edit(){
    	$id=$_GET['id'];
    	$catModel=M('CatModel'); 
    	$sql="select * from sp_category where id={$id}";
    	// var_dump($sql);die;
    	$row=$catModel->getRow($sql);
    	// var_dump($data);die;
    	$this->assign('row',$row);
    	$this->display('category/cateedit.html');
    }

    public function uedit(){
    	$id=$_GET['id'];
    	$name=htmlEncode($_POST['name']);
    	// $var_dump($name);die;
    	$catModel=M('CatModel'); 
    	$sql="update sp_category set name='{$name}' where id={$id}";
    	// var_dump($sql);die;
    	$result=$catModel->setData($sql);
    	// var_dump($result);die;
    	if($result){
    		echo "修改成功";
    	}else{
    		echo "修改失败";
    	}
    	$url=C('URL.main').'/index.php?p=admin&m=category&a=showList';
    	header('Refresh:2;url='.$url); 
    }


    //删除功能
    public function drop(){
    	//获取要的分类的id
    	$id=$_GET['id'];
    	// var_dump($id);die
    	$catModel=M('CatModel');
    	$sql="delete from sp_category where id={$id}";//删除分类的sql语句
    	// var_dump($sql);die;
    	$re=$catModel->setData($sql);//执行sql语句
    	if($re){//如果执行成功
    		echo "删除成功";
    	}else{//否则
    		echo "删除失败";
    	}
    	$url=C('URL.main').'/index.php?p=admin&m=category&a=showList';
    	header('Refresh:2;url='.$url);   	
    }


    public function showAd(){
    	$id=$_GET['id'];
    	$name=$_GET['name'];
    	$this->assign('id', $id);
    	$this->assign('parent_name', $name);
    	$this->display('category/add.html');
    }

    public function ushowAd(){
    	$id=$_POST['id'];
    	$name=htmlEncode($_POST['name']);
    	$catModel=M('CatModel');
    	$sql="insert into sp_category values (null,'{$name}',{$id})";
    	$re=$catModel->setData($sql);
    	if($re){
    		$str = "添加子分类成功!";
    	}else{
    		$str = "添加子分类失败!";
    	}
    	$url=C('URL.main').'/index.php?p=admin&m=category&a=showList';
    	$this->showTips($re, $str, $url);
    	exit;
    }

}