<head>
    <?php include 'templates/header.php'?>
    <link rel="stylesheet" href="stylesheet/swiper.3.2.0.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <link rel="stylesheet" href="stylesheet/sort.css"/>
    <script src="../js/lazyload.js"></script>
    <script src="../js/swiper.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.cataItem').first().addClass('cur');
            $('.categoryList').first().css('display','block');

            $(document).on('click','.cataItem',function(){
                $('.cataItem').removeClass('cur');
                $(this).addClass('cur');
                $('.categoryList').css('display','none');
                $('#item'+$(this).attr('id')).css('display','block');


            })
        });

    </script>
</head>
<body>
<div class="wrap">
    <header class="header">
        <div class="headerContainer">
        <a class="back" href="javascript:window.history.go(-1);"></a>
        <form class="searchBox">
            <input class="main_input" type="text" id="key-word"placeholder="输入关键字">
            <input class="search_btn" id="search-button"type="button">
        </form>
            <a class="daohang"href="#"></a>
            <nav class="head_nav">
                <a class="hn_index"href="index.php">首页</a>
                <a class="hn_sort"href="controller.php?getSort=1">分类查找</a>
                <a class="hn_cart"href="controller.php?getCart=1">购物车</a>
                <a class="hn_memb"href="controller.php?customerInf=1">个人中心</a>
                <
            </nav>
            </div>
        <script src="../js/head.js"></script>

    </header>
    <div class="allsort" style="height: 752px">
        <ul class="cataList"id="father-category">
            <?php foreach($catList as $k=> $v):?>
            <li class="cataItem"id="<?php echo $k?>"><?php echo $v[0]['father_name']?></li>
            <?php endforeach?>
        </ul>
        <div class="cataDetail">
            <?php foreach($catList as $k=>$v):?>
            <div class="categoryList"id="item<?php echo $k?>"style="display: none">
                <?php foreach($v as $row):?>
                    <a class="categoryItem"href="controller.php?getList=1&sc_id=<?php echo $row['sc_id']?>">
                        <?php echo $row['sc_name']?>
                    </a>
                <?php endforeach?>
            </div>
            <?php endforeach ?>
        </div>

    </div>


</div>
</body>