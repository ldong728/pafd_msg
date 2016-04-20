<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/customer_inf.css"/>
</head>
<body>
<div class="wrap">
    <div class="memberHome">
        <div class="user_info">
            <p class="username">
                欢迎你，
                <span><?php echo $_SESSION['userInf']['nickname']?><?php echo $_SESSION['sdp']['name']?></span>
            </p>
            <!--            <div class="memberRank mr1"></div>-->
        </div>

        <div class="mymanage">
            <a class="myManage3"href="controller.php?sdp=1&gainshare=1">佣金分配
                <i class="iright"></i></a>
        </div>
        <div class="mymanage">
            <a class="myManage1"href="controller.php?sdp=1&sdpSell=1">售价设置
                <i class="iright"></i></a>
        </div>
        <div class="mymanage">
            <a class="myManage1"href="controller.php?sdp=1&userSdp=1">我的微商
                <i class="iright"></i></a>
        </div>
        <div class="mymanage">
            <a class="myManage1"href="controller.php?sdp=1&sdpQr=1">二维码
                <i class="iright"></i></a>
        </div>


    </div>

</div>
<?php include_once 'templates/foot.php'?>
<script>


</script>
</body>