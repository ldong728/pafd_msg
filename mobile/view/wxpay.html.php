<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/order.css"/>
</head>
<body>
<div class="wrap">
    </header>
    <div class="orderComfirm">
        <div>
            <h1 class="stu">支付中</h1>
        </div>
        <div>
<!--            <h5>订单号：--><?php //echo $orderId?><!--</h5>-->
        </div>
        <a class="orderSettle" id="wxpay"href="index.php"style="display: none">返回</a>
    </div>
    <?php include_once 'templates/foot.php'?>
</div>
</body>
<?php include_once 'templates/jssdkIncluder.php'?>
<script>
    wx.ready(function(){
        wx.hideOptionMenu();
        wx.chooseWXPay({
            timestamp: <?php echo $preSign['timeStamp']?>,//这里是timestamp 键中的字母s要小写，妈的
            nonceStr: '<?php echo $preSign['nonceStr']?>',
            package: '<?php echo $preSign['package']?>',
            signType: '<?php echo $preSign['signType']?>',
            paySign: '<?php echo $preSign['paySign']?>',
            success: function (res) {
                if('get_brand_wcpay_request:ok'==res.err_msg){
//                    alert('pay succes')
                    $('.stu').empty();
                    $('.stu').append('支付成功');
                    $('.orderSettle').show();
                }else{
//                    alert('false:'+res.err_msg);
                }
                window.location.href='controller.php?customerInf=1';
                // 支付成功后的回调函数
            }
        });


    })

</script>
</body>