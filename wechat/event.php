<?php

function VIEW($msg)
{
//    mylog('it work');

}


function CLICK($msg)
{
//    mylog('click');
    $openid = $msg['from'];
    $inf = getUserInf($openid);
    switch ($msg['EventKey']) {
        case 'moldule2': {//通知查看按钮
            $groupid = $inf['groupid'];
            $notice = pdoQuery('notice_tbl', null, array('groupid' => $groupid, 'situation' => '1'), ' order by create_time desc limit 1');
            if ($notice = $notice->fetch()) {
                $title = $notice['title'];
                $intro = $notice['intro'];
                $img = $notice['title_img'];
                $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?getNotice=1&openid=' . $openid . '&groupid=' . $groupid;
                $newsArray = array('news_item' => [array('title' => $title, 'digest' => $intro, 'cover_url' => 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/' . $img, 'url' => $url)]);
                $json = json_encode($newsArray);
                $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
//                mylog($content);
                echo $content;
            } else {
                $GLOBALS['weixin']->replytext('当前无通知');
            }


            break;
        }
        case 'moldule3': {
            break;
        }
        case 'module1' : {
            $GLOBALS['weixin']->replytext('请点击');
            break;
        }
        case 'bbs': {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?bbs=1&openid=' . $openid;
            $newsArray = array('news_item' => [array('title' => '互动社区', 'digest' => '点击进入互动社区，查看最新通知，此消息包含您个人信息，请勿转发，以免个人信息泄露', 'url' => $url)]);
            $json = json_encode($newsArray);
            $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
            echo $content;
            break;
        }
        case 'study': {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?study=1&openid=' . $openid;
            $newsArray = array('news_item' => [array('title' => '学习平台', 'digest' => '点击进入学习平台，此消息包含您个人信息，请勿转发，以免个人信息泄露', 'url' => $url)]);
            $json = json_encode($newsArray);
            $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
            echo $content;
            break;

        }
            case 'blank':{
                $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?jmrh=1&openid=' . $openid;
                $newsArray = array('news_item' => [array('title' => '军民融合', 'digest' => '点击进入军民融合专栏，此消息包含您个人信息，请勿转发，以免个人信息泄露', 'url' => $url)]);
                $json = json_encode($newsArray);
                $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
                echo $content;
                break;
            }
    }
    if ($msg['EventKey'] == 'kf') {
//        mylog('kf');
        sendKFMessage($msg['FromUserName'], '已为您接入人工客服，请稍候');
        $GLOBALS['weixin']->toKFMsg();
    }
    return;
}


function subscribe($msg)
{
    $openid = $msg['FromUserName'];
    $userinf = getUnionId($msg['FromUserName']);
    if (isset($userinf)) {
        putUserInfToDb($userinf);
    }
    $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?study=1&openid=' . $openid;
    $newsArray = array('news_item' => [array('title' => '欢迎关注三北武装', 'digest' => '请勿转发此条消息，以免个人信息泄露', 'cover_url' => 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/img/0.jpg', 'url' => $url)]);
    $json = json_encode($newsArray);
    $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
//    mylog($content);
    echo $content;
    return;
}

function unsubscribe($msg)
{
    $openid = $msg['FromUserName'];
    pdoTransReady();
    try {
        pdoDelete('user_reg_tbl', array('openid' => $openid));
        pdoUpdate('user_tbl', array('subscribe' => 0, 'groupid' => '0'), array('openid' => $openid));
        pdoCommit();
    } catch (PDOException $e) {
        mylog($e->getMessage());
        pdoRollBack();
    }

}