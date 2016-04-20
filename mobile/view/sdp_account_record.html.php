<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000, 9999) ?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
    <div class="category-name">
        账户明细
    </div>
    <div class="h-slash">
    </div>
    <?php foreach ($list as $row): ?>
        <div class="list-content"style="height: 62px">
            <div class="g-main-title">单号<?php echo $row['order_id']?></div>
            <div class="g-sub-title"><?php echo $row['creat_time']?></div>
            <div class="g-strong-title"style="color:<?php echo $row['type']=='in'?'#45C018':'#000000'?>"><?php echo $row['fee']?></div>
            <div class="g-strong-title"><?php echo $row['type']=='out'?'取现':'收入'?></div>

        </div>
    <?php endforeach ?>
        <div class="gslist-block">
            <a href="controller.php?sdp=1&accRecord=1&page=<?php echo (int)($page-1)?>" class="page-button">上一页</a>
            <a href="controller.php?sdp=1&accRecord=1&page=<?php echo (int)($page+1)?>" class="page-button">下一页</a>

        </div>
    <div class="toast"?></div>

</div>

<script>
    $('.button').click(function(){
        var values=new Array();
        $('.gs-value').each(function(){
            var rank=$(this).attr('id').slice(2);
            var value=$(this).val();
            values.push({rank:rank,value:value});
        })
        $.post('ajax.php',{sdp:1,altGainshare:1,data:values,g_id:$('.g_id').val()},function(data){
            if(data='ok'){
                showToast('更改成功');
            }
        })
    });

</script>
</body>