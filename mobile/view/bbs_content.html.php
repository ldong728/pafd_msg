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
                                            <?php echo $topicInf['nickname']?>
                                        </span><br>
                                        <span class="list_item_floor_num">
                                            楼主
                                        </span>
                                        <span class="list_item_time">
                                           <?php echo date('Y-m-d H:i:s',$topicInf['issue_time']) ?>
                                        </span>
                                    </div>
                                    <div class="list_item_more_operation">
                                        <a class="list_item_more_operation_btn  pb_icon" href="controller.php?create_topic=1&type=reply&t_id=<?php echo $topicInf['id']?>"></a>
                                    </div>
                                    <div class="content"style="padding-left: 0">
                                        <?php echo $topicInf['content']?>
                                        <?php foreach($topicInf['img'] as $irow):?>
                                        <span class="wrap pbimgwapper"><img src="<?php echo '../'.$irow?>"style="max-width: 100%;height: auto"/></span>
                                        <?php endforeach ?>
                                    </div>
                                </div>

                        </div>
                    </div>
                </li>
                <?php foreach($replyList as $row):?>
                    <li class="list_item post_list_item default_feedback">
                        <div class="list_item_wrapper">
                            <div class="list_main">
                                <div class="post_title_embed">
                                    <?php echo $row['title']?>
                                </div>
                                <div class="list_item_top clearfix">
                                    <div class="list_item_top_avatar">
                                        <span><img src="<?php echo $row['headimgurl']?>" width="36" height="36"/></span>
                                    </div>
                                    <div class="list_item_top_name">
                                        <span class="user_name red_name">
                                            <?php echo $row['nickname']?>
                                        </span><br>
                                        <span class="list_item_floor_num">
                                            <?php echo $row['floor']?>楼
                                        </span>
                                        <span class="list_item_time">
                                           <?php echo date('Y-m-d H:i:s',$row['issue_time']) ?>
                                        </span>
                                    </div>
                                    <div class="list_item_more_operation">
                                        <a class="list_item_more_operation_btn  pb_icon" href="controller.php?create_topic=1&type=reply&t_id=<?php echo $topicInf['id']?>&f_id=<?php echo $row['id']?>"></a>
                                    </div>
                                    <div class="content">
                                        <?php echo $row['content']?>
                                        <?php foreach($row['img'] as $irow):?>
                                            <span class="wrap pbimgwapper"><img src="<?php echo '../'.$irow?>"style="max-width: 100%;height: auto"/></span>
                                        <?php endforeach ?>
                                    </div>
                                    <div class="fr_list j_floor_panel">
                                        <ul class="flist">
                                            <?php foreach($row['subReply'] as $subRow):?>
                                                <div class="fmain">
                                                    <div class="floor_footer_item">
                                                        <a class="user_name " href="controller.php?create_topic=1&type=reply&t_id=<?php echo $topicInf['id']?>&f_id=<?php echo $row['id']?>&reply_name=<?php echo $subRow['nickname']?>"><?php htmlout($subRow['nickname'].'：')?></a>
                                                        <span class="floor_content"><?php htmlout($subRow['content'])?></span>
                                                        <span class="list_item_time"><?php echo date('m-d H:i:s',$subRow['issue_time'])?></span>
                                                    </div>
                                                </div>

                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>

</body>
</body>