<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/20
 * Time: 11:44
 */
include_once '../includePackage.php';
session_start();


if (!isset($_SESSION['cate'])) {
    $cate = pdoQuery('category_overview_view', null, null, '');
   $_SESSION['cate']['cateCount']=0;
    foreach ($cate as $caRow) {
        $_SESSION['cate']['cateCount']++;
       $_SESSION['cate']['cateName'][]=$caRow;
    }
}
    $query=pdoQuery('user_promotion_view',null,null,null);
foreach ($query as $row) {
    $row['price']=getSdpPrice($row['id']);
    $promotion[$row['sc_id']][]=$row;
}

//if (isset($_GET['test'])) {
//    $sdpU='{"customerId":"ot_dyw9jm0nQippKjf4pgoYn2Aj4","userInf":{"subscribe":1,"openid":"ot_dyw9jm0nQippKjf4pgoYn2Aj4","nickname":"dong","sex":0,"language":"zh_CN","city":"","province":"","country":"","headimgurl":"","subscribe_time":1460888139,"remark":"","groupid":0},"sdp":{"sdp_id":"7b0607f701cf10fbf88be55556b47da0","level":"1","name":"\u5fae\u5ba2","root":"b6b08e36a2a734d3a82c8c17f705f7af","scale":0,"price":{"1":"1000.00","2":"2300.00"}},"rand":7313}';
//    $sdpM='{"customerId":"ot_dyw2lrlHrfBShYLvBCygMqM9s","userInf":{"subscribe":1,"openid":"ot_dyw2lrlHrfBShYLvBCygMqM9s","nickname":"Don Li","sex":1,"language":"zh_CN","city":"\u5b81\u6ce2","province":"\u6d59\u6c5f","country":"\u4e2d\u56fd","headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/PL5y7QQHZgLSPlaic2fmokkVFhmD0RgL2TO8QtvILweoS3GIQygWsYZ1WtMeOfWkkgWuia462xbwsJjp08TWm2EA\/0","subscribe_time":1456749482,"remark":"","groupid":0},"rand":3414,"cate":{"cateCount":7,"cateName":[{"id":"1","0":"1","sub_name":"\u53a8\u5e08\u673a","1":"\u53a8\u5e08\u673a","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"},{"id":"2","0":"2","sub_name":"\u98df\u7269\u5904\u7406\u5668","1":"\u98df\u7269\u5904\u7406\u5668","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"},{"id":"3","0":"3","sub_name":"\u7092\u83dc\u673a","1":"\u7092\u83dc\u673a","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"},{"id":"4","0":"4","sub_name":"\u7a7a\u6c14\u70b8\u9505","1":"\u7a7a\u6c14\u70b8\u9505","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"},{"id":"5","0":"5","sub_name":"\u7834\u58c1\u673a","1":"\u7834\u58c1\u673a","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"},{"id":"7","0":"7","sub_name":"\u51b0\u6fc0\u6dcb\u6599\u7406\u673a","1":"\u51b0\u6fc0\u6dcb\u6599\u7406\u673a","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"},{"id":"8","0":"8","sub_name":"\u7ede\u8089\u673a","1":"\u7ede\u8089\u673a","father_name":"\u5065\u5eb7\u6599\u7406","2":"\u5065\u5eb7\u6599\u7406"}]},"sdp":{"sdp_id":"b6b08e36a2a734d3a82c8c17f705f7af","level":"3","name":"\u91d1\u724c\u7ecf\u9500\u5546","manage":{"switch":"off","discount":"0.8","min_sell":"0.95","max_sell":"1.2"},"wholesale":{"1":"750.00"},"root":"b6b08e36a2a734d3a82c8c17f705f7af","price":{"1":"1000.00","2":"2300.00"}}}';
//    $_SESSION=json_decode($sdpM,true);
//}
$state=isset($_SESSION['sdp']['sdp_id'])? $_SESSION['sdp']['sdp_id'] : 'root';
$url='https://open.weixin.qq.com/connect/oauth2/authorize?'
    .'appid='.APP_ID
    .'&redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].DOMAIN.'/mobile/controller.php?oauth=1')
    .'&response_type=code&scope=snsapi_base'
    .'&state='.$state.'#wechat_redirect';
//mylog($url);
$config = getConfig('config/config.json');
$adQuery = pdoQuery('ad_tbl', null, null, '');
foreach ($adQuery as $adRow) {
    $adList[$adRow['category']][] = $adRow;
}
$indexRmark=pdoQuery('index_remark_tbl',null,null,null);
$menuid=$_SESSION['sdp']['level']>1?2:$_SESSION['sdp']['level'];
//mylog('level:'.$menuid);
$menuQuery=pdoQuery('sdp_menu_tbl',null,null,' where level like "%'.$menuid.'%" limit 5');
foreach ($menuQuery as $row) {
    $menu[]=$row;
}


include 'view/index.html.php';
exit;