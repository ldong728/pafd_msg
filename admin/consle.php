<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/29
 * Time: 10:50
 */
include_once '../includePackage.php';
session_start();


if (isset($_SESSION['login'])) {
    if (isset($_POST['insert']) && isset($_POST['g_name'])) {
        $situation = isset($_POST['is_part']) ? 9 : 1;
        $g_id = pdoInsert('g_inf_tbl', array('produce_id' => $_POST['produce_id'], 'name' => $_POST['g_name'], 'sc_id' => $_POST['sc_id'], 'situation' => $situation));
//        mylog('newgoods:'.$g_id);
        if ($g_id != null) {
            if (isset($_POST['sale'])) {
                $d_id = pdoInsert('g_detail_tbl', array('g_id' => $g_id, 'category' => '默认', 'sale' => $_POST['sale'], 'wholesale' => $_POST['wholesale']));
            }
            $sc_id = $_POST['sc_id'];
//        printView('admin/view/goods_edit.html.php');
            $part_input = isset($_POST['is_part']) ? '&is_part=1' : '';
            header('location:index.php?goods-config=1&g_id=' . $g_id . '&sc_id=' . $sc_id . $part_input);
            exit;
        }
        exit;
    }
    if (isset($_POST['category'])) {

        pdoInsert('category_tbl', array('name' => $_POST['category'], 'remark' => $_POST['remark']));
        init();
        header('location:index.php?category-config=1');
        exit;
    }
    if (isset($_POST['sub_category']) && $_POST['father_cg_id'] != '0') {
        pdoInsert('sub_category_tbl', array('name' => $_POST['sub_category'], 'father_id' => $_POST['father_cg_id'], 'e_name' => $_POST['e_name']));
        init();
        header('location:index.php?category-config=1');
        exit;

    }
    if (isset($_POST['alter'])) {
        pdoUpdate('g_inf_tbl', array('name' => $_POST['name'],'made_in'=>$_POST['s_name'], 'intro' => addslashes($_POST['intro']), 'inf' => addslashes($_POST['g_inf']), 'produce_id' => $_POST['produce_id']), array('id' => $_POST['g_id']));
        $g_id = $_POST['g_id'];
        pdoInsert('after_inf_tbl',array('g_id'=>$g_id,'after_inf'=>addslashes($_POST['after_inf'])),'update');
        $is_part = isset($_POST['is_part']) ? '&is_part=1' : '';
        header('location:index.php?goods-config=1&g_id=' . $g_id . $is_part);
        exit;
    }
    if (isset($_POST['filtOrder'])) {
        if(isset($_POST['express'])&&isset($_POST['expressNumber'])&&$_POST['expressNumber']!='') {
            pdoUpdate('order_tbl', array('stu' => $_POST['stu'], 'express_id' => $_POST['express'], 'express_order' => $_POST['expressNumber']),
                array('id' => $_POST['filtOrder']));
            pdoInsert('order_record_tbl',array('order_id'=>$_POST['filtOrder'],'event'=>$_POST['stu'],'operator_id'=>$_SESSION['operator_id']));
            if ($_POST['stu'] == '2') {
                include_once '../wechat/serveManager.php';
                $query = pdoQuery('user_express_query_view', null, array('id' => $_POST['filtOrder']), ' limit 1');
                $inf = $query->fetch();
                $templateArray = array(
                    'first' => array('value' => '您在阿诗顿官方商城的网购订单已发货：'),
                    'keyword1' => array('value' => $inf['express_name'], 'color' => '#0000ff'),
                    'keyword2' => array('value' => $inf['express_order'], 'color' => '#0000ff'),
                    'remark' => array('value' => '请留意物流电话通知')
                );

                $request = sendTemplateMsg($inf['c_id'], $template_key_express, 'http://m.kuaidi100.com/index_all.html?type=' . $inf['express_id'] . '&postid=' . $inf['express_order'], $templateArray);
            }
        }else{
            pdoUpdate('order_tbl',array('total_fee'=>$_POST['total_fee']),array('id'=>$_POST['filtOrder']));
        }
        header('location: index.php?orders=1');
        exit;
    }
    if (isset($_GET['start_promotions'])) {
        $id = pdoInsert('promotions_tbl', array('g_id' => $_GET['g_id'], 'd_id' => $_GET['d_id']));
        $dquery=pdoQuery('g_detail_view',null,array('d_id'=>$_GET['d_id']),' limit 1');
        $g_inf=$dquery->fetch();
        pdoUpdate('promotions_tbl', array('img' => 'g_img/pro-img-up' . $id . '.jpg','price'=>$g_inf['sale'],'p_name'=>$g_inf['name']), array('id' => $id));
        header('location: index.php?promotions=1');
        exit;

    }
    if (isset($_GET['delete_promotions'])) {
        $query = pdoQuery('promotions_tbl', null, array('d_id' => $_GET['d_id']), ' limit 1');
        $row = $query->fetch();
        unlink('../' . $row['img']);
        pdoDelete('promotions_tbl', array('d_id' => $_GET['d_id']));
        header('location: index.php?promotions=1');
        exit;
    }
    if (isset($_GET['del_detail_id'])) {
        $query = pdoQuery('user_order_view', array('count(*) as num'), array('d_id' => $_GET['del_detail_id']), ' ');
        $value = $query->fetch();
        if ($value['num'] > 0) {
            echo 'cannot delete';
        } else {
            pdoDelete('g_detail_tbl', array('id' => $_GET['del_detail_id']));
            header('location:index.php?goods-config=1&g_id=' . $_GET['g_id']);
        }
        exit;
    }
    //公众号操作
    if (isset($_GET['wechat'])) {
        include_once '../wechat/serveManager.php';
        if (isset($_GET['createButton'])) {
//            echo 'ok';
            createButtonTemp();
            exit;
        }
        if (isset($_GET['getMenuInf'])) {
            echo getMenuInf();
            exit;
        }
        if (isset($_GET['test'])){
//            $data=curlTest();
            $data=sendKFMessage('o_Luwt9OgYENChNK0bBZ4b1tl5hc','你好');
            echo $data;
            exit;
        }

    }
    if (isset($_GET['imgUpdate'])) {
        mylog('update');
    }
    if (isset($_GET['goodsSituation'])) {
        pdoUpdate('g_inf_tbl', array('situation' => $_GET['goodsSituation']), array('id' => $_GET['g_id']));
        $g_id = $_GET['g_id'];
        header('location:index.php?goods-config=1&g_id=' . $g_id);
        exit;
    }
    if (isset($_GET['updateParm'])) {
        $value['g_id'] = $_GET['g_id'];
        foreach ($_POST as $k => $v) {
            $value[$k] = $v;
        }
        pdoInsert('parameter_tbl', $value, 'update');
        $g_id = $_GET['g_id'];
        header('location:index.php?goods-config=1&g_id=' . $g_id);
        exit;
    }
    if (isset($_POST['importCard'])) {
        $card_id = trim($_POST['card_id']);
        $value['card_id']=$card_id;
        include_once '../wechat/cardManager.php';
        $data = getCardDetail($card_id);
        $dataArray = json_decode($data, true);
        $cardType = $dataArray['card']['card_type'];
        $value['card_type'] = $cardType;
        switch ($cardType) {
            case 'CASH': {
                $value['least_cost'] = $dataArray['card']['cash']['least_cost'] / 100;
                $value['reduce_cost'] = $dataArray['card']['cash']['reduce_cost'] / 100;
                break;
            }
            case 'DISCOUNT': {
                $value['discount'] = (100 - $dataArray['card']['discount']['discount']) / 100;
                break;
            }
            default: {
                break;
            }
        }
        pdoInsert('card_tbl',$value,'update');

        echo $data;

        exit;
    }
    exit;
}
header('location:index.php');
exit;

