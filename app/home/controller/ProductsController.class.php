<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 16:27
 */

namespace home\controller;
use core\Controller;

class ProductsController extends Controller {
    public function showList(){
    	//调用模型查询数据
    	$ProductsModel=\core\APP::single('\\model\\ProductsModel');
    	$sql='select id,name,intro,price,ori_price,img from sp_goods_info where 1';
    	$datas=$ProductsModel->getRows($sql);
    		// var_dump($datas);die;
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
    	// var_dump($jihe);die;
    	$this->assign('jihe',$jihe);//把查询出的数据分配给模板
        $this->assign('jihes',$jihes);//把查询出的数据分配给模板
    	$this->assign('id',$id);//把查询出的数据分配给模板
    	$this->display('single-product.html');//渲染模板
    }
    public function showcartadd(){
        
        $id=$_GET['id'];
        $qtybutton=!empty($_POST['qtybutton']) ? $_POST['qtybutton'] : 1;
        $cartUnSer = isset($_COOKIE['Cart']) ? unserialize($_COOKIE['Cart']) : array();
        // var_dump($qtybutton);die;
        $cartUnSer[] = array(
            'id' =>$id,
            'qtybutton'=>$qtybutton
        );
        echo "<pre/>";
        // var_dump($cartUnSer);die;
        $cart = serialize($cartUnSer);
        setcookie('Cart', $cart);

        if($cartUnSer){
            // $this->assign('cartUnSer',$cartUnSer);
            echo "添加购物车成功";
        $url=C('URL.main')."/index.php?p=home&m=products&a=showintro&id={$id}";
        header('Refresh:2;url='.$url);
        exit;
        }else{
            echo "添加购物车失败";
        $url=C('URL.main')."/index.php?p=home&m=products&a=showintro&id={$id}";
        header('Refresh:2;url='.$url);
        exit;
        }
    }

    public function showcart(){
        $cookie = stripslashes ( $_COOKIE ['Cart'] ); //去除addslashes添加的反斜杠
        $cartUnSer = unserialize ( $cookie );//反序列化cookie 
        echo "<pre/>";
        $ProductsModel=\core\APP::single('\\model\\ProductsModel');
        $data=[];
        foreach ($cartUnSer as $val) {
            $num=$val['qtybutton'];
            $id=$val['id'];
            $sql="select img,name,price from sp_goods_info where id={$id}";
            $row=$ProductsModel->getRow($sql);
            $row['qtybutton']=$num;
            $data[]=$row;
            // echo "<pre/>";
            // print_r($row);die;
        }
        // var_dump($data);die;
        $this->assign('data',$data);
        $this->display('cart.html');
    }
}