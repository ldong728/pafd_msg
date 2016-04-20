<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/list.css"/>
    <script src="../js/lazyload.js"></script>
</head>
<body>
<div class="wrap">

    <div class="searchList">
    <div class="pd_list">
        <?php foreach($query as $row):?>
        <a class="box_pd"href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id']?>">
            <div class="pdImg">
                <img class="pd_picture lazy"style_external="max-width:100px; max-height:100px;"src="../img/place100x100.jpg"data-original="../<?php echo $row['url']?>">
            </div>
            <div class="pd_detail">
                <p class="pd_name"><?php echo $row['name']?></p>
                <p class="pd_price">￥<?php echo isset($row['price'])? number_format($row['price'],2,'.',''):number_format($row['sale'],2,'.','')?><span class="payOffline marked"><em>正品保证</em></span></p>
                <p class="pd_standard"><?php echo $row['category']?></p>
            </div>
        </a>
        <?php endforeach?>
    </div>
    </div>

</div>
<script>
    $('img.lazy').lazyload();

</script>
</body>