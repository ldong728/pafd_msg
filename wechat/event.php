<?php

function VIEW($msg)
{
//    mylog('it work');

}


function CLICK($msg)
{
//    mylog('click');
    $openid = $msg['from'];
    switch ($msg['EventKey']) {
        case 'moldule2': {//通知查看按钮
            $inf = getUserInf($openid);
            $groupid = $inf['groupid'];
            $notice=pdoQuery('notice_tbl',null,array('groupid'=>$groupid,'situation'=>'1'),' order by create_time desc limit 1');
            if($notice=$notice->fetch()) {
                $title = $notice['title'];
                $intro = $notice['intro'];
                $img = $notice['title_img'];
                $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?getNotice=1&openid=' . $openid . '&groupid=' . $groupid;
                $newsArray = array('news_item' => [array('title' => $title, 'digest' => $intro, 'cover_url' => 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/' . $img, 'url' => $url)]);
                $json = json_encode($newsArray);
                $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
//                mylog($content);
                echo $content;
            }else{
                $GLOBALS['weixin']-> replytext('当前无通知');
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
    $url = 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/mobile/controller.php?signIn=1&code=' . $openid;
    $newsArray = array('news_item' => [array('title' => '欢迎关注三北武装', 'digest' => '点击此图文信息识别身份', 'cover_url' => 'http://' . $_SERVER['HTTP_HOST'] . DOMAIN . '/img/0.jpg', 'url' => $url)]);
    $json = json_encode($newsArray);
    $content = $GLOBALS['weixin']->prepareNewsMsg($msg['from'], $msg['me'], $json);
//    mylog($content);
    echo $content;


    return;
}