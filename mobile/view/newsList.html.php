<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/newslist.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/mobile-index-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
    <style type="text/css">


    </style>
</head>

<body>
<div class="wrap">
    <div class="swiper-container" id="main-swiper">
        <div class="swiper-wrapper" style="width: 4368px; height: 60vw">
            <div class="swiper-slide">
                <img class="swiper-img swiper-lazy" data-src="../img/title_14616380623060.jpg"/>
            </div>
            <div class="swiper-slide">
                <img class="swiper-img swiper-lazy" data-src="../img/title_14616378242788.jpg"/>
            </div>
            <div class="swiper-slide">
                <img class="swiper-img swiper-lazy" data-src="../img/title_14617235775359.jpg"/>
            </div>
        </div>
        <div class="swiper-pagination" id="main-pagination"></div>
    </div>
    <script>
        var swiper = new Swiper('#main-swiper', {
            pagination: '#main-pagination',
            paginationClickable: true,
            autoplay: 5000,
            lazyLoading: true,
            loop: true
        });
    </script>
    <div class="tab">
        <div class="tab_hd">
            <div class="tab_hd_inner">
                <?php foreach($cate as $row):?>
                    <div type="index" id="<?php echo $row['id']?>" class="item <?php echo $cateid==$row['id']?'active':''?>"style="cursor: pointer"><?php echo $row['name']?></div>
                <?php endforeach ?>
            </div>
        </div>
        <script>
            $('.item').click(function(){
                var id=$(this).attr('id');
                window.location.href='controller.php?mainSite=1&cate='+id;
            })
        </script>
        <div class="tab_bd">
            <div class="article_list">
                <?php foreach ($newsList as $row):?>
                    <a class="list_item"href="<?php echo 'local'==$row['source']?'controller.php?getNews='.$row['id']:$row['url'] ?>">
                        <div class="cover">
                            <img class="img"src="../<?php echo $row['title_img']?>"/>
                        </div>
                        <div class="cont">
                            <h2 class="title"><?php echo $row['title']?></h2>
                            <p class="desc"><?php echo $row['digest']?></p>

                        </div>

                    </a>
                <?php endforeach ?>



            </div>

        </div>


    </div>

</div>

</body>
