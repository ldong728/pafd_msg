<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000, 9999) ?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
    <div class="category-name">
        下级微商
    </div>
    <div class="h-slash">
    </div>

        <?php foreach ($subList as $row): ?>
        <div class="list-content" style="height: 65px">
            <div class="list-block">
                <img class="list-img" src="<?php echo $row['url'] ?>"/>
                <div class="title-box">
                    <div class="list-main-title">
                        <?php echo $row['nickname']?>
                    </div>
                    <div class="list-sub-title">
                        <span>佣金账户：</span>￥<?php echo $row['total_balence']?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>

    <div class="gslist-block">
        <a href="controller.php?sdp=1&<?php echo $listmode?>=1&page=<?php echo (int)($page-1)?>" class="page-button">上一页</a>
        <a href="controller.php?sdp=1&<?php echo $listmode?>=1&page=<?php echo (int)($page+1)?>" class="page-button">下一页</a>
    </div>
    <div class="toast"></div>

</div>

<script>
    $('.button').click(function () {
        var values = new Array();
        $('.gs-value').each(function () {
            var rank = $(this).attr('id').slice(2);
            var value = $(this).val();
            values.push({rank: rank, value: value});
        })
        $.post('ajax.php', {sdp: 1, altGainshare: 1, data: values}, function (data) {
            if (data = 'ok') {
                showToast('更改成功');
            }
        })
    });

</script>
</body>