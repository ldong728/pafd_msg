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
    if (isset($_GET['createNews'])) {
        $title = addslashes(trim($_POST['title']));
        $digest = addslashes(trim($_POST['digest']));
        $title_img = $_POST['title_img'] ? 'img/0.jpg' : $_POST['title_img'];
        $content = addslashes($_POST['content']);
        if ($title != '' && $content != '') {
            pdoInsert('news_tbl', array('title' => $title, 'digest' => $digest, 'title_img' => $title_img, 'content' => $content, 'source' => 'local', 'create_time' => time()));
            header('location:index.php?newslist=1');
            exit;
        } else {
        }
    }
    if (isset($_GET['getNotice'])) {//在预览框架中显示
        $css = '<style type="text/css">'
  .'img {max-width:100%;}'
.'</style>';

        $noticeId = $_GET['getNotice'];
        if ($noticeId == -1) {
            echo '预览';
            exit;
        }
        $notice = pdoQuery('notice_tbl', array('inf'), array('id' => $noticeId), ' limit 1');
        $notice = $notice->fetch();
        echo $css;
        echo $notice['inf'];
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
        if (isset($_GET['test'])) {
//            $data=curlTest();
            $data = sendKFMessage('o_Luwt9OgYENChNK0bBZ4b1tl5hc', '你好');
            echo $data;
            exit;
        }

    }

    exit;
}
header('location:index.php');
exit;

