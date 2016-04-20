<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/order.css"/>
</head>
<body>
<div class="wrap">
    <!--    <div class="orderComfirm">-->
    <!---->
    <!--        <a class="orderSettle" id="readyToPay"href="#">付款</a>-->
    <!--    </div>-->
</div>

<script src="../js/ap.js"></script>
<script>
    var orderId='<?php echo $orderId ?>';
    _AP.pay('../aliwappay/controller.php?createOrder=1&orderId='+orderId);
</script>