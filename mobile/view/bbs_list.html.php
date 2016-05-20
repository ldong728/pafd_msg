<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/bbs.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/bbs_list.css?v=<?php echo rand(1000, 9999) ?>"/>
    <style type="text/css">


    </style>
</head>

<body>
<div class="container" style="-webkit-tap-highlight-color:transparent;
">
    <div id="tlist" class="post_list">
        <ul class="threads_list">
            <?php foreach ($topicList as $row): ?>
            <li class="tl_shadow">
                <a href="controller.php?bbs_content=1&t_id=<?php echo $row['id'] ?>">
                    <div class="ti_title">
                        <?php if($row['priority']=='11'):?>
                            <span class="ti_title_icon ti_icon_zhiding">置顶</span>
                                <?php endif ?>
                        <span><?php htmlout($row['title']) ?></span>
                    </div>
                    <p class="ti_abs"><?php htmlout($row['content']) ?></p>
                    <div class="medias_wrap clearfix">
                        <?php foreach ($row['img'] as $iRow): ?>
                            <div class="medias_item ">
                                <img class="medias_img_r" src="<?php echo '../' . $iRow ?>" style="opacity: 1;">
                            </div>
                        <?php endforeach ?>
                    </div>
                </a>

                <div class="ti_infos clearfix">
                    <div class="ti_author_time">
                            <span class="ti_author ti_vip"
                                  style="background-image:url('<?php echo $row['headimgurl'] ?>')">
                                <?php echo $row['nickname'] ?>
                            </span>
                            <span class="ti_time">
                                <?php echo date('Y-m-d H:i:s', $row['issue_time']) ?>
                            </span>
                    </div>
                    <div class="ti_zan_reply reply_btn" style="cursor: pointer" data-tid="<?php echo $row['id'] ?>">
                        <div class="ti_func_btn btn_reply">
                                <span class="btn_icon">
                                    <?php echo $row['reply_count'] ?>
                                </span>
                        </div>
                    </div>
                </div>

            </li>
            <?php endforeach ?>
        </ul>
    </div>
    <a class="light_post_entrance" id="issue_content"></a>
</div>

</body>
<script>
    $('#issue_content').click(function () {
        window.location.href = 'controller.php?create_topic=11';
    });
    $('.reply_btn').click(function () {
        var t_id = $(this).data('tid');
        window.location.href = 'controller.php?create_topic=1&type=reply&t_id=' + t_id;
    });
</script>