<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/bbs-content.css?v=<?php echo rand(1000, 9999) ?>"/>
    <style type="text/css">




    </style>
</head>

<body>
<div class="glob" id="glob">
    <div id="main" class="main">
        <div class="po_list">
            <ul class="list" id="plist">
                <li class="list_item post_list_item default_feedback">
                    <div class="list_item_wrapper">
                        <div class="list_main">
                            <div class="post_title_embed">
                                <?php echo $topicInf['title']?>
                            </div>
                                <div class="list_item_top clearfix">
                                    <div class="list_item_top_avatar">
                                        <span><img src="<?php echo $topicInf['headimgurl']?>" width="36" height="36"/></span>
                                    </div>
                                    <div class="list_item_top_name">
                                        <span class="user_name red_name">
                                            <?php echo $row['nickname']?>
                                        </span><br>
                                        <span class="list_item_floor_num">
                                            楼主
                                        </span>
                                        <span class="list_item_time">
                                           <?php echo date('Y-m-d H:i:s', $row['issue_time']) ?>
                                        </span>
                                    </div>
                                    <div class="list_item_more_operation">
                                        <a class="list_item_more_operation_btn  pb_icon"></a>
                                    </div>
                                    <div class="content">
                                        <?php echo $row['content']?>
                                        <?php foreach($row['img'] as $irow):?>
                                        <span class="wrap pbimgwapper"><img src="<?php echo '../'.$irow?>"</span>
                                        <?php endforeach ?>
                                    </div>
                                </div>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

</body>
</body>