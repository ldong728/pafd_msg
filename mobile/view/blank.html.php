<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/bbs.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/bbs_list.css?v=<?php echo rand(1000, 9999) ?>"/>
    <style type="text/css">


    </style>
</head>

<body>
<div class="container">
    <div id="tlist" class="post_list">
        <ul class="threads_list">
            <?php foreach($topicList as $row):?>
                <li class="tl_shadow">
                    <a href="">
                        <div class="ti_title"><span><?php htmlout($row['title'])?></span></div>
                        <p class="ti_abs"><?php htmlout($row['content'])?></p>

                        <div class="medias_wrap clearfix">
                            <?php foreach($row['img'] as $iRow):?>
                                <div class="medias_item ">
                                    <img class="medias_img_r" src="<?php echo '../'.$iRow?>" style="opacity: 1;">
                                </div>
                            <?php endforeach ?>
                            <div class="medias_modal">共<?php echo count($row['img'])?>张</div>
                        </div>
                        <div class="ti_infos clearfix">
                            <div class="ti_author_time">
<!--                            <span class="ti_author"style="background-image:url('--><?php //echo $row['headimgurl']?>/*')">*/
                                <img src="<?php echo $row['headimgurl']?>"></div>
                                <?php echo $row['nickname']?>
<!--                            </span>-->
                            <span class="ti_time">
                                <?php echo $row['issue_time']?>
                            </span>
                            </div>
                            <div class="ti_zan_reply">
                                <div class="ti_func_btn btn_reply">
                                <span class="btn_icon">
                                    <?php echo $row['reply_count'] ?>
                                </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <a class="light_post_entrance" id="issue_content"></a>
    <script>
        $('#issue_content').click(function(){
            window.location.href='controller.php?create_topic=11';
        });
    </script>
</body>
