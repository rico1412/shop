<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 16:27
 */

namespace home\controller;

class ProductsController extends HomeController {
    public function showList(){
    	//调用模型查询数据
    	$ProductsModel=\core\APP::single('\\model\\ProductsModel');
    	$sql='select id,name,intro,price,ori_price,img from sp_goods_info where 1';
    	$datas=$ProductsModel->getRows($sql);

    	$this->assign('datas',$datas);//把查询出的数据分配给模板
        $this->display('shopList.html');//渲染模板
    }
    public function showintro(){
    	//接受get传递过来的参数
    	$id=$_GET['id'];

    	//调用模型查询数据
    	$ProductsModel=\core\APP::single('\\model\\ProductsModel');
    	$sql="select id,name,intro,price,descript,img from sp_goods_info where id='{$id}'";
    	$jihe=$ProductsModel->getRow($sql);

    	$sql="select id,name,intro,price,img from sp_goods_info where 1";
    	$jihes=$ProductsModel->getRows($sql);

        $sql="select id,name from sp_category where 1";
        $top=$ProductsModel->getRows($sql);
    	// var_dump($jihe);die;
        $this->assign('top',$top); //把查询出的数据分配给模板
    	$this->assign('jihe',$jihe);//把查询出的数据分配给模板
    	$this->assign('jihes',$jihes);//把查询出的数据分配给模板
    	$this->display('single-product.html');//渲染模板
    }

}