<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title><?php echo $title ?></title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css?v=<?php echo rand(1000, 9999) ?>">
    <link rel="stylesheet" type="text/css" href="stylesheet/style2.css?v=<?php echo rand(1000, 9999) ?>">
    <script src="js/html5.js"></script>

</head>

<header>
    <h1><img src="logo/logo.png"/></h1>
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
<!--                --><?php //if (isset($_SESSION['pms']['index'])): ?>
<!--                <dd style="display: --><?php //echo isset($_GET['index']) ? 'block' : 'none' ?><!--"><a href="index.php?index=1">首页编辑</a>-->
<!--                    </dd>--><?php //endif ?>
                <?php if (isset($_SESSION['pms']['index'])): ?>
                <dd style="display: <?php echo isset($_GET['index']) ? 'block' : 'none' ?>"><a href="index.php?categorylist=1">内容分类</a>
                    </dd><?php endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>分组管理</dt>
                <?php if (isset($_SESSION['pms']['group'])): ?>
                <dd style="display: <?php echo isset($_GET['groupManager']) ? 'block' : 'none' ?>"><a
                            href="index.php?groupManager=1&groupList=1">分组列表</a></dd><?php endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>用户管理</dt>
                <?php if (isset($_SESSION['pms']['user'])): ?>
                <dd style="display: <?php echo isset($_GET['user']) ? 'block' : 'none' ?>"><a
                            href="index.php?user=1&userList=1">用户列表</a></dd><?php endif ?>
            </dl>
        </li>
        <li>
            <dl class="main-menu">
                <dt>通知管理</dt>
                <?php if (isset($_SESSION['pms']['notice'])): ?>
                <dd style="display: <?php echo isset($_GET['notice']) ? 'block' : 'none' ?>"><a
                            href="index.php?notice=1&sendNotice=-1">发送通知</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['notice'])): ?>
                <dd style="display: <?php echo isset($_GET['notice']) ? 'block' : 'none' ?>"><a
                            href="index.php?notice=1&noticeList=0">状态查询</a></dd><?php endif ?>
                <?php if (isset($_SESSION['pms']['notice'])): ?>
                <dd style="display: <?php echo isset($_GET['notice']) ? 'block' : 'none' ?>"><a
                            href="index.php?notice=1&orders=1">历史通知</a></dd><?php endif ?>
            </dl>
        </li>
        <?php if (isset($_SESSION['pms']['news'])): ?>
            <li>
                <dl class="main-menu">
                    <dt>图文信息管理</dt>
                    <dd style="display: <?php echo isset($_GET['news']) ? 'block' : 'none' ?>"><a
                            href="index.php?news=1&newslist=1">图文信息列表</a></dd>
                    <dd style="display: <?php echo isset($_GET['news']) ? 'block' : 'none' ?>"><a
                            href="index.php?news=1&createNews=2">新建图文信息</a></dd>
                    <!--                    <dd><a href="index.php?sdp=1&usersdp=1">微商管理</a></dd>-->
                    <!--                    <dd><a href="index.php?sdp=1&sdpInf=1">数据分析</a></dd>-->
                </dl>
            </li>
        <?php endif ?>


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
    $('dt').click(function () {
        $(this).nextAll('dd').slideToggle('fast');
    });
</script>
<section class="rt_wrap content mCustomScrollbar">
    <div cla="rt_content">


