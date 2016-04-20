<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000,9999)?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
<div class="main-info">
    <div class="imgbox">
        <img src="../img/account.png">
    </div>
    <div class="title">
        我的账户
    </div>
    <div class="total_balence">
        ￥<?php echo $account['total_balence']?>
    </div>
    <a class="feeback-button">
        提现
    </a>
    <div class="account-record">
        <a href="controller.php?sdp=1&accRecord=1">账户明细</a>
    </div>

</div>





</div>

<script>

</script>
</body>