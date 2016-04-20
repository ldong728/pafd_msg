<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000, 9999) ?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
    <div class="category-name">
        <?php echo $p_id ?>佣金设置
    </div>
    <div class="h-slash">


    </div>
    <?php foreach ($gs as $k=>$row): ?>
        <div class="gslist-block"id="block<?php echo $k?>">
            <div class="gs-rank">
                等级<?php echo $k+1 ?>
            </div>
            <div class="gs-input-box">
                佣金：<input class="number gs-value"id="gs<?php echo $k?>" value="<?php echo $row['value']?>"/>
            </div>
        </div>

    <?php endforeach ?>
    <div class="gslist-block">
        <input type="hidden"class="g_id"value="<?php echo $g_id?>"/>
        <button class="button">更改设置</button>
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