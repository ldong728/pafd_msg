<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/bbs-content.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000, 9999) ?>"/>
    <style type="text/css">

        .zan_reply {
            position: fixed;
            left: 0;
            bottom: 0;
            right: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: 44px;
            padding: 5px 15px;
            box-sizing: border-box;
            background: #f0f2f5 -webkit-linear-gradient(top,#fafcff,#f0f2f5);
            background: #f0f2f5 linear-gradient(to bottom,#fafcff,#f0f2f5);
            border-top: 1px solid #c8cacc;
            z-index: 200;
        }
        .bottom-bar-button {
            display: block;
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            font-size: 12px;
            line-height: 32px;
            text-align: center;
            color: #7a7c80;
            background: #f0f2f5 -webkit-gradient(linear,0 0,0 100%,from(#f5f7fa),to(#f0f2f5));
            border-radius: 4px;
        }
        .bottom-bar-button:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 200%;
            height: 200%;
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scale(0.5);
            transform: scale(0.5);
            border: 1px solid #e1e3e5;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn_zan_icon {
            display: inline-block;
            width: 20px;
            height: 28px;
            vertical-align: top;
            background-image: url(http://tb2.bdstatic.com/tb/mobile/sglobal/img/new_sglobal_icon_89f6b7d.png);
            background-repeat: no-repeat;
            -webkit-background-size: 70px auto;
            background-size: 70px auto;
            background-position: 0 -661px;
        }
        .btn_reply_text {
            display: inline-block;
            background-position: -6px -369px;
            padding-left: 22px;




    </style>
</head>

<body>
<div class="glob" id="glob">
    <div id="main" class="main">
        <div class="po_list">
            <ul class="list" id="plist" style="background-color: #f5f7fa;">
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
        <div class="zan_reply">
            <div class="bottom-bar-button like"style="cursor: pointer;margin-right: 10px;">
                <span class="btn_zan_icon"></span>
                <span class="btn_zan_text">赞</span>
            </div>
            <a class="bottom-bar-button btn_reply j_btn_reply">
                <div class="btn_reply_text pb_icon">回复</div>
            </a>
        </div>
    </div>
</div>
<div class="toast"></div>
<script>
    var t_id=<?php echo $_GET['t_id']?>;
    $('.like').click(function(){
        $.post('ajax.php',{topic_like:1,t_id:t_id},function(data){
            if(data=='ok'){
                showToast('+1');
            }else if(data=='duplicate'){
                showToast('已赞');
            }


        });

    });

</script>

</body>
</body>