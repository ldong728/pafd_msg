<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/favorite.css"/>
    <script src="../js/lazyload.js"></script>
</head>
<body>
<div class="wrap">
    <header class="header">
        <a class="back" href="javascript:window.history.go(-1);"></a>
        <p class="hd_tit">我的收藏</p>
        <a class="daohang"href="#"></a>
        <nav class="head_nav">
            <a class="hn_index"href="index.php">首页</a>
            <a class="hn_sort"href="controller.php?getSort=1">分类查找</a>
            <a class="hn_cart"href="controller.php?getCart=1">购物车</a>
            <a class="hn_memb"href="controller.php?customerInf=1">个人中心</a>
        </nav>
        <script src="../js/head.js"></script>
    </header>

    <div class="myfavorite">
        <ul id="favory_history">
            <?php foreach($query as $row):?>
            <li id="li<?php echo $row['g_id']?>">
                <a href="#" class="icon_lt cancel_btn" id="<?php echo $row['g_id']?>"></a>
                <a href="controller.php?goodsdetail=1&g_id=<?php echo $row['g_id']?>" class="pd_detail">
                    <img style="width: 48px; height: 48px; display: block;" style_external="width:48px;height:48px;"
                         class="profile" src="../img/place100x100.jpg"data-original="../<?php echo $row['url']?>">
                    <p class="pd_name">
                        <?php echo $row['name']?>
                    </p>
                    <p class="pd_price">
                    </p>
                    <span class="icon_rt"></span>
                </a>
            </li>
            <?php endforeach?>
        </ul>
    </div>
    <div id="search_more" style="display:none">
        <a id="viewMore" class="mm_more" href="javascript:searchMore();">查看更多</a>
    </div>
    <div id="loading_more" style="display:none">
        <a id="loadingMore" class="mm_more" href="javascript:void(0);">数据读取中..</a>
    </div>

</div>
<script>
    $('img.profile').lazyload();
    $('.cancel_btn').click(function(){
        var g_id=$(this).attr('id');
        $.post('ajax.php',{deletFav:1,g_id:$(this).attr('id')},function(data){
            $('#li'+g_id).slideUp('slow',function(){
               $(this).remove();
            });
        });
    });

</script>

</body>