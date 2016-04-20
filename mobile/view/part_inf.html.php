<head>
    <?php include 'templates/header.php' ?>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <link rel="stylesheet" href="stylesheet/goodinf-swiper.min.css"/>
    <link rel="stylesheet" href="stylesheet/myswiper.css"/>
    <script src="../js/swiper.min.js"></script>
    <!--    <link rel="stylesheet" href="stylesheet/goods_inf.css"/>-->
    <script src="../js/lazyload.js"></script>

</head>
<body>
<div class="wrap">
    <div class="inf-header">
        <div class="button-block"><a href="index.php"><div class="inf-block inf-home">首页</div></a></div>
        <div class="button-block"><a class="title-kf"><div class="inf-block inf-kf">客服</div></a></div>
        <div class="button-block"><a href="controller.php?getCart=1$rand=<?php echo rand(1000, 9999) ?>"><div class="inf-block inf-cart">购物车</div></a></div>
        <div class="button-block"><a href="#"id="fav"><div class="inf-block inf-fav">收藏</div></a></div>
    </div>
    <div class="sdp-inf-header">

    </div>
    <div class="pDetail">
        <a href="controller.php?getList=1&c_id=<?php echo $cate['id']?>"><div class="cate-name">
                <?php echo $cate['name'].' '.$cate['e_name']?> 配件
            </div>
        </a>
        <div class="h-slash">

        </div>
        <div class="baseInfo">
            <div class="pd_info">
                <div class="swiper-container" id="cover_swiper">
                    <div class="swiper-wrapper" style="width: 4368px; height: auto">
                        <?php foreach ($imgQuery as $row): ?>
                            <div class="swiper-slide">
                                <img class="swiper-img swiper-lazy" data-src="../<?php echo $row['url'] ?>"/>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="swiper-pagination" id="ad-pagination"></div>
                </div>
                <div class="swiper-pagination" id="ad-pagination"></div>
                <script>
                    var swiper = new Swiper('#cover_swiper', {
                        pagination: '#ad-pagination',
                        paginationClickable: true,
                        autoplay: 5000,
                        lazyLoading: true,
                        loop: true
                    });
                </script>
                <div class="pName">
                    <span class="pro_name"><?php echo $inf['name'] ?></span>
                </div>
                <div class="p-remark">
                    <div class="p-remark-content">
                        库存99件
                    </div>
                    <div class="p-remark-content">
                        销量<?php echo $review['num'] ?>件
                    </div>

                    <div class="price">
                        RMB <?php echo $price = $inf['sale'] ?>
                    </div>
                </div>
            </div>
            <div class="part module-box">
                <div class="title con-hid con-dis">
                    <div class="line-number"> 1</div>
                    <div class="title-name">适用机型:</div>
                </div>
                <div class="scroll-box">
                    <div class="part-box">
                        <?php foreach ($hostlist as $r): ?>
                        <a href="controller.php?goodsdetail=1&g_id=<?php echo $r['g_id'] ?>" >
                            <div class="partInf">
                                <img class="part-img" src="../<?php echo $r['url'] ?>"/>
                                <input type="hidden" value="<?php echo $r['sale'] ?>"/>

                                <div class="part-name">
                                    <?php echo $r['produce_id'] ?>
                                </div>
                            </div>
                            </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="param module-box">
                <div class="title con-hid" id="param-title">
                    <div class="line-number">2</div>
                    <div class="title-name">参数</div>
                </div>
                <div class="param-container" style="display: none">
                    <dl>
                        <dt>名称：</dt>
                        <dd><?php echo $inf['name'] ?></dd>
                    </dl>
                    <dl>
                        <dt>品牌：</dt>
                        <dd>ashton/阿诗顿</dd>
                    </dl>
                </div>
            </div>

            <div class="detail module-box">

                                <div class="title" id="count-title">
                                        <div class="line-number">3</div>
                                    <div class="title-name">选择数量</div>
                                    <div class="countBox">
                                        <a class="minus number-button" id="minus">-</a>
                                        <input readonly="1" class="count" id="number" value="<?php echo $number ?>" maxlength="3"
                                               type="tel"/>
                                        <a class="plus number-button" id="plus">+</a>
                                    </div>
                                </div>

            </div>

        </div>
    </div>


    <!--    --><?php //include_once 'templates/foot.php' ?>
    <div class="foot">
        <div class="price-box">
            <div class="total-price">合计_<?php echo number_format($price * $number,2,'.','') ?></div>
        </div>
        <div class="button-box">
            <a class="buttons add-cart">
                加入购物车
            </a>
            <a class="buttons buy-now">
                立即购买
            </a>
        </div>

    </div>
    <div class="toast"></div>

</div>

<script>
    var g_id =<?php echo $inf['g_id']?>;
    var d_id = <?php echo $inf['d_id']?>;
    var realPrice =<?php echo $inf['sale']?>;//保存在js中的价格
    var number = parseInt($('#number').val());
    var parts = new Array();
</script>
<script>
    $('.detail-select').click(function () {
        var id = $(this).attr('id');
        $('default-content').css('display', 'none');
        $('#' + id + '-content').css('display', 'block');
    });
</script>
<?php include_once 'templates/jssdkIncluder.php' ?>
<script>
    var url='<?php echo $url ?>';
    wx.ready(function() {
        wx.onMenuShareTimeline({
            title: '<?php echo $inf['name'] ?> ', // 分享标题
            link: url, // 分享链接
            imgUrl: '<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'.DOMAIN.'/'.$inf['url']?>', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareAppMessage({
            title: '<?php echo $inf['name'] ?> ', // 分享标题
            desc: '<?php echo $paramvalue ?>', // 分享描述
            link: url, // 分享链接
            imgUrl: '<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'.DOMAIN.'/'.$inf['url']?>', // 分享图标
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
<script>
    var scale=<?php echo isset($_SESSION['sdp']['scale'])?$_SESSION['sdp']['scale']:0?>;
    if(scale>0){
        var price=scale;
        price=price.toFixed(2);
        $('.sdp-inf-header').css('display','block');
        $('.sdp-inf-header').text('分享赚取佣金 ￥'+price);
    }
    $(document).on('click','.sdp-inf-header',function(){
        $(this).fadeOut();
    });


</script>
</body>

