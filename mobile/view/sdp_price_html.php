<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000, 9999) ?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
    <?php foreach ($list as $row): ?>
        <div class="list-content">
            <div class="list-block">
                <img class="list-img" src="../<?php echo $row['url']?>"/>
                <div class="title-box">
                    <div class="list-main-title">
                        <?php echo $row['made_in']?>
                    </div>
                    <div class="list-sub-title">
                        <?php echo $row['produce_id']?>
                    </div>
                </div>
                <a class="inner-button gsbutton" href="controller.php?sdp=1&gainshare=1&g_id=<?php echo $row['g_id']?>&p_id=<?php echo $row['produce_id']?>">
                    佣金设置
                </a>
            </div>
            <div class="price-box">
                <div class="discount-box">
                    <p>进货</p><p>￥<?php echo number_format($row['wholesale'],2,'.','')?></p>
                </div>
                <div class="setting-box">
                    <div class="min">
                        最低￥<span id="min<?php echo $row['g_id']?>"><?php echo number_format($row['min_sell'],2,'.','')?></span>
                    </div>
                    <input type="tel" class="priceinput"id="<?php echo $row['g_id']?>"value="<?php echo isset($row['price'])?number_format($row['price'],2,'.',''):number_format($row['sale'],2,'.','')?>"/>
                    <div class="max">
                       最高￥<span id="max<?php echo $row['g_id']?>"><?php echo number_format($row['max_sell'],2,'.','')?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <div class="toast"></div>

</div>

<script>
    $('.priceinput').change(function(){
       var g_id=$(this).attr('id');
        var price=parseFloat($(this).val());
        var min=parseFloat($('#min'+g_id).text());
        var max=parseFloat($('#max'+g_id).text());
        if(price>max||price<min){
            alert('超出限定价格！')
        }else{
            $.post('ajax.php',{sdp:1,alterSdpPrice:1,g_id:g_id,price:price},function(data){
               if(data=='ok'){
                   showToast('价格修改成功');
               } else{
                   alert('超出限定价格！');
               }
            });
        }


    });

</script>
</body>