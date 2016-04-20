<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/mobile-index-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
</head>

<body>
<div class="wrap">
    <?php include_once 'templates/jssdkIncluder.php'?>
    <script>
        var url='<?php echo $url ?>';
        var tltitle='<?php echo $config['timeLineTitle']?>';
        var amtitle='<?php echo $config['appMessageTitle']?>';
        var desc='<?php echo $config['appMessageDesc']?>';
        wx.ready(function() {
            wx.onMenuShareTimeline({
                title: tltitle, // 分享标题
                link: url, // 分享链接
                imgUrl: '<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'.DOMAIN.'/img/logo.jpg'?>', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: amtitle, // 分享标题
                desc: desc, // 分享描述
                link: url, // 分享链接
                imgUrl: '<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'.DOMAIN.'/img/logo.jpg'?>', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.hideMenuItems({
                menuList: [
                    "menuItem:copyUrl",
                    "menuItem:originPage",
                    "menuItem:openWithQQBrowser",
                    "menuItem:openWithSafari",
                    "menuItem:share:weiboApp",
                    "menuItem:share:qq"
                ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
            });
        });

    </script>
    <div class="search-container">
        <div type="button" class="icon-button"></div>
        <input type="text" class="search-box"/>
        <div class="button-container">
            <a class="search-button">搜索商品</a>
        </div>
    </div>
    <div style="width: 100%;height: 40px;z-index: 0"></div>

    <div class="swiper-container" id="ad-swiper">
        <div class="swiper-wrapper" style="width: 4368px; height: 60vw">
            <?php foreach ($adList['banner'] as $row): ?>
                <div class="swiper-slide">
                    <!--                    <a href="-->
                    <?php //echo isset($row['url']) ? $row['url'] : 'controller.php?goodsdetail=1&g_id=' . $row['g_id'] ?><!--">-->
                    <img class="swiper-img swiper-lazy" data-src="../<?php echo $row['img_url'] ?>"/>
                    <!--                    </a>-->
                </div>
            <?php endforeach ?>
        </div>
        <div class="swiper-pagination" id="ad-pagination"></div>
    </div>
    <?php foreach ($promotion as $promotionRow):?>

    <div class="hot-sale-container">
        <a href="controller.php?getList=1&c_id=<?php echo $promotionRow[0]['sc_id']?>"><div class="category-name">
<!--            --><?php //echo $promotionRow[0]['sc_name'].' '.$promotionRow[0]['e_name']?>
            <?php echo $promotionRow[0]['e_name']?>
        </div></a>
        <div  class="h-slash"></div>
        <?php foreach ($promotionRow as $row): ?>

            <div class="hot-sale-box">
                <div class="hot-sale-blank"></div>
                <div class="hot-sale-content">
<!--                    <div class="hot-sale-blank"></div>-->
                    <div class="hot-sale-name">
                        <span class="cate-name"><?php echo $row['p_name'].' '?></span><br/>
                        <span class="cate-pid"> <?php echo $row['produce_id'] ?> </span>
                    </div>
                    <div class="hot-sale-intro">
                        <?php echo $row['intro'] ?>
                    </div>
                    <div class="hot-sale-price">
                        RMB <?php echo number_format($row['price'],2,'.','') ?>
                    </div>
                    <a href="controller.php?goodsdetail=1&g_id=<?php echo $row['id'] ?>" class="hot-sale-buy">
                    选购
                    </a>
                </div>
                <a href="controller.php?goodsdetail=1&g_id=<?php echo $row['id'] ?>">
                <div class="hot-sale-image">
                    <img src="../<?php echo $row['url'] ?>"/>
                </div>
                    </a>
            </div>

<!--            <div class="horizonborder"></div>-->
        <?php endforeach ?>
    </div>
    <?php endforeach?>

    <div class="remark-container">
        <?php foreach($indexRmark as $remark):?>
        <div class="remark-box">
            <div class="imgbox"><img class="remark-img" src="../<?php echo $remark['img']?>"/></div>
            <div class="remark-content">
                <div class="remark-title">
                    <?php echo $remark['title']?>
                </div>
                <div class="remark">
                    <?php echo $remark['remark']?>
                </div>
            </div>

        </div>
        <?php endforeach ?>

    </div>
    <div class="foot-blank">
        <?php if($_SESSION['sdp']['level']<1):?>
        <div class="sdp-button">
            立即开通
        </div>
        <p>亲爱的<b><?php echo $_SESSION['userInf']['nickname']?></b>,开通微客，即可轻松分享赚取佣金</p>
        <p style="color: #0587f6">分享健康料理，体验智能厨电</p>
        <?php endif?>
        <?php if($_SESSION['sdp']['level']>0):?>
            <p>亲爱的<?php echo $_SESSION['sdp']['name']?><b><?php echo $_SESSION['userInf']['nickname']?></b>,欢迎回来</p>
            <p style="color: #0587f6">分享健康料理，体验智能厨电</p>
        <?php endif?>
    </div>

    <div class="toast"></div>


</div>
<?php include_once 'templates/foot.php' ?>
<script>
    var swiper = new Swiper('#ad-swiper', {
        pagination: '#ad-pagination',
        paginationClickable: true,
        autoplay: 5000,
        lazyLoading: true,
        loop: true
    });
</script>
<script>
    $('.search-button').click(function(){
        var key=$('.search-box').val()
        window.location.href='controller.php?search='+key;
    });
    $('.sdp-button').click(function(){
        window.location.href='controller.php?sdp=1&sdp_signup=1';
    });
</script>

</body>

