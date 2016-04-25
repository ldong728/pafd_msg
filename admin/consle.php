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
    if(isset($_GET['createNews'])){
        $title=$_POST['title'];
        $digest=$_POST['digest'];
//        $
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

