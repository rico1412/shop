<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 16:27
 */

namespace home\controller;

class ProductsController extends HomeController{
    public function showList(){
        
        $c_id = isset($_GET['c_id']) ? $_GET['c_id'] : 0;
        $p_model = M('ProductsModel');
        $condition = '';

        if ($c_id != 0){
            $condition .= " and category_id={$c_id}";
        }

        # 分页相关
        $nowPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $numPerPage = 1;
        $sql = "select count(*) num from sp_goods_info where 1{$condition}";
        $num = $p_model->getRow($sql)['num'];
        $totalPage = (int)ceil($num / $numPerPage);
        $url = C('URL.main') . "/index.php?p=home&m=products&a=showList&c_id={$c_id}&page";
        $pageHtml = pageHtml($nowPage, $totalPage, $url);

        //调用模型查询数据
        $sql = "select * from sp_goods_info where 1{$condition}";
        $datas = $p_model->getRows($sql);
        var_dump($sql);

        # 展示分类数据
        $c_model = M('CatModel');
        $c_data = $c_model->getCats();

        $c_name = '全部商品';
        if ($c_id != 0){
            $sql = "select name from sp_category where id={$c_id}";
            $c_name = $c_model->getRow($sql)['name'];
        }

        $this->assign('pageHtml', $pageHtml);
        $this->assign('c_id', $c_id);
        $this->assign('c_name', $c_name);
        $this->assign('c_data', $c_data);
        $this->assign('datas', $datas);//把查询出的数据分配给模板
        $this->display('shopList.html');//渲染模板
    }

    public function showIntro(){
        //接受get传递过来的参数
        $id = $_GET['id'];

        //调用模型查询数据
        $ProductsModel = M('ProductsModel');
        $sql = "select * from sp_goods_info where id='{$id}'";
        $jihe = $ProductsModel->getRow($sql);

        $sql = "select id,name,intro,price,img from sp_goods_info where 1";
        $jihes = $ProductsModel->getRows($sql);

        $sql = "select id,name from sp_category where 1";
        $top = $ProductsModel->getRows($sql);
        // var_dump($jihe);die;
        $this->assign('top', $top); //把查询出的数据分配给模板
        $this->assign('jihe', $jihe);//把查询出的数据分配给模板
        $this->assign('jihes', $jihes);//把查询出的数据分配给模板
        $this->display('single-product.html');//渲染模板
    }

}