<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?php echo $title ?></title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css?v=<?php echo rand(1000, 9999) ?>">
    <link href="../uedit/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet/style2.css?v=<?php echo rand(1000, 9999) ?>">
    <script src="js/html5.js"></script>

</head>

<header>
    <ul class="rt_nav">
        <li><a href="#" target="_blank" class="website_icon">站点首页</a></li>
        <li><a href="index.php?logout=1" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<body>
<div class="toast"></div>
<aside class="lt_aside_nav content mCustomScrollbar">
    <h2><a href="index.php">起始页</a></h2>
    <ul>
        <li>
            <dl class="main-menu">
                <dt>首页管理</dt>
                <?php if (isset($_SESSION['pms']['index'])): ?>
                    <dd><a href="index.php?index=1">首页编辑</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['index'])): ?>
                    <dd><a href="index.php?promotions=1">首页商品</a></dd><?php endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>用户管理</dt>
                <!--当前链接则添加class:active-->
                <?php if (isset($_SESSION['pms']['user'])): ?>
                    <dd><a href="index.php?userList=1">用户列表</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['user'])): ?>
                    <dd><a href="index.php?goods-config=1">分组管理</a></dd><?php endif ?>
<!--                --><?php //if (isset($_SESSION['pms']['user'])): ?>
<!--                    <dd><a href="index.php?category-config=1">类别管理</a></dd>--><?php //endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>通知管理</dt>
                <?php if (isset($_SESSION['pms']['notice'])): ?>
                    <dd><a href="index.php?orders=-1">发送通知</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['notice'])): ?>
                    <dd><a href="index.php?orders=0">状态查询</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['notice'])): ?>
                    <dd><a href="index.php?orders=1">历史通知</a></dd><?php endif ?>
            </dl>
        </li>
        <?php if (isset($_SESSION['pms']['news'])): ?>
            <li>
                <dl class="main-menu">
                    <dt>图文信息管理</dt>
                    <dd><a href="index.php?newslist=1">图文信息列表</a></dd>
<!--                    <dd><a href="index.php?sdp=1&rootsdp=2">分销商管理</a></dd>-->
<!--                    <dd><a href="index.php?sdp=1&usersdp=1">微商管理</a></dd>-->
<!--                    <dd><a href="index.php?sdp=1&sdpInf=1">数据分析</a></dd>-->
                </dl>
            </li>
        <?php endif ?>


        <li>
            <dl class="main-menu">
                <dt>评价管理</dt>
                <?php if (isset($_SESSION['pms']['review'])): ?>
                    <dd><a href="index.php?review=1">查看评价</a></dd><?php endif ?>
            </dl>
        </li>

        <li>
            <dl class="main-menu">
                <dt>管理员</dt>
                <?php if (isset($_SESSION['pms']['operator'])): ?>
                    <dd><a href="index.php?wechatConfig=1">微信公众号</a></dd>
                    <dd><a href="index.php?operator=1">管理员信息</a></dd><?php endif ?>
            </dl>
        </li>

        <li>
            <p class="btm_infor">© 谷多网络 版权所有</p>
        </li>
    </ul>
</aside>
<script>
    $('dt').click(function(){
//        $('dd').hide()
       $(this).nextAll('dd').slideToggle('fast');
    });
</script>
<section class="rt_wrap content mCustomScrollbar">
    <div cla="rt_content">


        <!--        --><?php //echo isset($_SESSION['pms']['card'])? '<li><a href="index.php?card=1">优惠券</a></li>':''?>

