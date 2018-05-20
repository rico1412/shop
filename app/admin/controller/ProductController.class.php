<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/19
 * Time: 17:05
 */

namespace admin\controller;

use core\Controller;

class ProductController extends Controller {
    public function showList(){

        $model = M('ProductModel');

        $nowPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $numPerPage = 5;

        $sql = "select count(*) AS num from sp_goods_info where 1";

        $num = $model->getRow($sql)['num'];

        $totalPage = (int)ceil($num / $numPerPage);

        $url = C('URL.main') . "/index.php?p=admin&m=product&a=showList&page";
        $pageHtml = pageHtml($nowPage, $totalPage, $url);

        $x = ($nowPage - 1) * $numPerPage;
        $sql = "select p.id, p.name, p.ori_price, p.price, p.status, p.add_time, c.name AS c_name from sp_goods_info AS p join sp_category AS c on p.category_id=c.id order by add_time desc limit {$x}, {$numPerPage}";

        $p_data = $model->getRows($sql);

        $this->assign('pageHtml', $pageHtml);
        $this->assign('p_data', $p_data);
        $this->display('product/list.html');
    }

    public function showAdd(){
        //$this->display('product/productAdd.html');
    }

    public function showEdit(){
        //$this->display('product/productEdit.html');
    }
}