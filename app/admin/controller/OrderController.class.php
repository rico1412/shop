<?php
/**
 * Created by PhpStorm.
 * User: rico
 * Date: 2018/5/21
 * Time: 20:28
 */

namespace admin\controller;

use core\Controller;

class OrderController extends Controller {
    public function showList(){

        $model = M('OrderModel');

        # 分页相关
        $nowPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $numPerPage = 5;
        $sql = "select count(*) AS num from sp_order where 1";
        $num = $model->getRow($sql)['num'];
        $totalPage = (int)ceil($num / $numPerPage);
        $url = C('URL.main') . "/index.php?p=admin&m=order&a=showList&page";
        $pageHtml = pageHtml($nowPage, $totalPage, $url);

        $x = ($nowPage - 1) * $numPerPage;
        $sql = "select * from sp_order where 1 limit {$x}, {$numPerPage}";
        $orders = $model->getRows($sql);

        $this->assign('nowPage', $nowPage);
        $this->assign('pageHtml', $pageHtml);
        $this->assign('orders', $orders);
        $this->display('order/list.html');
    }

    public function showDetails(){

        $order_id = $_GET['order_id'];
        $page = $_GET['page'];

        $model = M('OrderDetailModel');

        $sql = "select d.id, d.count, p.name, p.price, p.img from sp_order_detail AS d join sp_goods_info AS p on d.p_id=p.id where d.order_id={$order_id}";

        $details = $model->getRows($sql);

        $this->assign('page', $page);
        $this->assign('details', $details);
        $this->display('order/details_list.html');
    }

    public function upd_h(){

        $id = $_GET['id'];
        $nowPage = $_GET['page'];

        $sql = "update sp_order set status=1 where id={$id}";

        $model = M('OrderModel');
        $re = $model->setData($sql);

        if ($re) {
            $str = "订单已处理";
        } else {
            $str = "订单处理失败，请联系管理员！";
        }

        $url = C('URL.main') . "/index.php?p=admin&m=order&a=showList&page={$nowPage}";
        $this->showTips($re, $str, $url);
    }
}