<head>
<?php include 'templates/header.php' ?>
<link rel="stylesheet" href="stylesheet/bbs.css?v=<?php echo rand(1000, 9999) ?>"/>
<style type="text/css">


.editor_content {
    -webkit-tap-highlight-color: transparent;
    outline: 0
}



.smile_btn_group a {
    display: block;
    text-align: center;
    height: 35px;
    line-height: 35px;
    font-family: arial;
    font-size: 16px;
    border-left: 1px solid #bbc2ce;
    border-top: 1px solid #bbc2ce;
    border-right: 0;
    border-bottom: 0;
    text-decoration: none;
    background: #ebeff5;
    color: #3e5872;
    position: relative
}



.smile_btn_group a:last-child {
    width: 54px
}



.smile_list li {
    display: inline-block;
    white-space: normal;
    margin: 0;
    width: 100%;
    line-height: 0
}

.smile_list div {
    width: 101%
}

.smile_list a {
    width: 14.28%;
    height: 42px;
    display: block;
    float: left;
    white-space: nowrap;
    -webkit-box-sizing: border-box;
    font-size: 14px;
    font-family: Microsoft YaHei;
    color: #333;
    text-align: center;
    line-height: 58px
}



.smile_list span {
    display: inline-block;
    width: 30px
}

.j_font a {
    width: 25%;
    height: 37px;
    line-height: 37px
}


.smile_slide_aim a {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 5px;
    margin: 5px 5px 5px 0;
    border: 1px solid #b8c0cc
}



.upload-block {
    display: block;
    position: relative
}

.rel {
    position: relative
}

.upload-block.download {
    width: 30px;
    height: 30px
}



.preview-content img {
    max-width: 90%;
    max-height: 400px;
    margin: 10px 0
}


.edit_panel {
    width: 100%;
    height: 320px;
    position: fixed;
    /*top: 0;*/
    left: 0;
    /*background-color: #35373a;*/
    opacity: 1;
    overflow: hidden;
    font-family: Microsoft YaHei, SimHei;
    /*display: none;*/
    z-index: 99999
}


.edit_panel img {
    display: inline-block;
    max-width: 100%;
    max-height: 100%
}


.edit_panel .buttons span {
    display: inline-block;
    height: 45px;
    line-height: 45px;
    vertical-align: top;
    overflow: hidden
}


.edit_panel .yesno a {
    display: block;
    height: 43px;
    width: 50%;
    -webkit-box-flex: 1;
    opacity: 1;
    background-color: #262626;
    color: #b2b2b2;
    font-size: 18px;
    line-height: 43px;
    letter-spacing: 2px
}


.multi_preview {
    max-height: 130px;
    padding-left: 15px;
    padding-bottom: 15px;
    overflow: hidden
}

.multi_preview .item {
    display: inline-block;
    position: relative;
    margin: 15px 15px 0 0;
    text-align: center;
    line-height: 60px;
    vertical-align: middle;
    width: 80px;
    height: 120px;
    color: #d0d2d4;
    font-family: arial;
    font-size: 40px
}

.multi_preview .item.add {
    background-image: url(http://tb2.bdstatic.com/tb/mobile/spostor/img/upload_multi_item_4734f98.png);
    background-repeat: no-repeat;
    background-position: 0 1px;
    background-size: 100%;
    -webkit-tap-highlight-color: transparent
}

.multi_preview .item.add:active {
    background-position: 0 -119px
}



.item_close .btn_close:before, .item_close .btn_close:after {
    background-color: #d5d6d8
}


.item_close .btn_close:before {
    height: 16px;
    width: 2px;
    margin: -8px 0 0 -1px
}

.item_close .btn_close:after {
    height: 2px;
    width: 16px;
    margin: -1px 0 0 -8px
}

.multi_preview .item img {
    width: 100%;
    height: 100%;
    box-shadow: 0 1px 3px 1px rgba(0, 0, 0, .2)
}


.editor_title {
}


.prefix_container input {
    border: 0;
    vertical-align: top;
    margin-top: 0;
    padding-left: 0
}




.prefix_panel .item {
    display: inline-block;
    border: 1px solid #e8e9eb;
    height: 32px;
    line-height: 32px;
    text-align: center;
    font-family: arial;
    color: #3361a7;
    border-radius: 3px;
    background: #e6e7e9 -webkit-gradient(linear, 0 0, 0 100%, from(#f2f4f6), to(#e6e7e9));
    margin: 3px 8px;
    padding: 0 15px
}



.ui_floatlayer {
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 99998
}

.editor_input {
    white-space: pre-wrap;
    word-wrap: break-word;
    -webkit-appearance: none;
    width: 100%;
    -webkit-box-sizing: border-box;
    display: block;
    font-size: 13px;
    color: #262626;
    border: 1px solid #dee0e0;
    padding: 10px 8px;
    line-height: 16px;
    background: #fbfbfb;
    font-weight: 600
}

.editor_input:disabled {
    background-color: #e5e5e5
}


.editor_title {
    margin: 0 0 -1px
}

.editor_content_panel {
    position: relative
}

.editor_content {
    padding-bottom: 24px
}



.editor_btn_list {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex
}


.editor_title_panel {
    width: 100%;
    background: #fff
}

.editor_content_panel {
    height: 98px;
    border-top: 1px solid #dee0e0;
    background: #fff
}

.editor_panel .editor_input {
    border-width: 0;
    background: #fff;
    font-size: 16px
}

.editor_panel .editor_title {
    padding: 12px 6px;
    outline: 0
}

.editor_panel .editor_content {
    max-height: 80px;
    min-height: 80px;
    overflow: auto
}

.editor_bottom_panel {
    margin-top: 0
}

.editor_btn_list {
    height: 50px;
    box-shadow: 0 1px 0 rgba(0, 0, 0, .3);
    background-color: #fff
}

.media_bar {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    display: block;
    -webkit-tap-highlight-color: transparent;
    line-height: 45px;
    background-color: #fff
}

.media_bar > div {
    position: relative;
    display: inline-block
}

.media_bar_btn_text {
    display: none
}

.media_bar a {
    display: inline-block;
    position: relative;
    height: 35px;
    width: 35px;
    margin-left: 15px;
    vertical-align: middle;
    background-size: 70px auto;
    background-image: url(http://tb2.bdstatic.com/tb/mobile/spostor/img/media_bar_btns_f9a163e.png);
    background-repeat: no-repeat
}



.media_bar .upload-block.enable {
    background-position: 0 -105px
}

/*.pic_btn_panel.gray .upload-block {*/
    /*-webkit-filter: grayscale(100%);*/
    /*filter: grayscale(100%);*/
    /*-webkit-transform: translateZ(0);*/
    /*transform: translateZ(0)*/
/*}*/



.ui_floatlayer {
    left: 0 !important
}
</style>
<script src="../js/ajaxfileupload.js"></script>
</head>

<body>
<div class="ui_floatlayer">
    <div class="blue_kit">
        <div class="blue_kit_left"></div>

        <div clas="blue_kit_right">
            <?php if($type=='issue'):?><a class="blue_kit_btn">发帖</a><?php endif?>
            <?php if($type=='reply'):?><a class="blue_kit_btn">回复 <?php echo $title ?></a><?php endif?>
        </div>
    </div>
    <div class="edit_panel">
        <?php if('issue'==$type):?>
        <div class="editor_title_panel">
            <input type="text" class="editor_input editor_title" id="title" placeholder="请输入标题（必填）"/>
        </div>
        <?php endif ?>
        <div class="editor_content_panel">
            <textarea style="height: 98px; margin: 0px -8px 0px 0px;"
                      class=" editor_input editor_content" id="content" placeholder="请输入内容"><?php echo isset($_GET['reply_name'])? '回复 '.$_GET['reply_name'].'：':''?></textarea>
        </div>
        <div class="editor_bottom_panel">
            <div class="editor_btn_list" style="display: none">
                <div class="media_bar">
                    <div class="pic_btn_panel" style="display: inline-block;"><a
                            class="upload-block enable" ><span
                                class="media_bar_btn_text">照片</span></a></div>
                </div>
            </div>
            <?php if($type=='issue'||$f_id==-1):?><div class="multi_preview"style="display:block">

                <div class="item add" id="uploadImg"style="cursor: pointer"></div>

            </div>
            <?php endif ?>
            <button class="issue_topic">提交</button>
            <?php include 'templates/jssdkIncluder.php'?>
            <script>
                var images=new Array();
                wx.ready(function(){
                    $('#uploadImg').click(function(){
                        images=new Array();
                        wx.chooseImage({
                            count: 4, // 默认9
                            sizeType: [ 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                            success: function (res) {
                                $('.imgItem').remove();
                                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                                $.each(localIds,function(k,v){
                                    wx.uploadImage({
                                        localId: v.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
                                        isShowProgressTips: 1, // 默认为1，显示进度提示
                                        success: function (res) {
                                            var serverId = res.serverId;
                                            images.push(serverId);
                                            var content='<div class="item imgItem"><img src="'+v+'"></div>';
                                            $('#uploadImg').before(content);
                                        }
                                    });

                                });

                            }
                        });
                    })
                })

            </script>


        </div>

    </div>
</div>
<script>
    var type='<?php echo $type ?>';
    var f_id=<?php echo $f_id ?>;
    var t_id=<?php echo $t_id ?>;
</script>
<script>
    $('.issue_topic').click(function(){
        var title=$('#title').val();
        var content=$('#content').val();
        if('issue'==type){
            $.post('ajax.php',{issue_topic:1,title:title,content:content,image:images},function(data){
                if('ok'==data){
                    alert('发表成功');

                }else{
                    alert(data);
                }
                history.go(-1);
            });
        }
        if('reply'==type){
            if(f_id=="-1"){
                $.post('ajax.php',{issue_reply:1,content:content,image:images,t_id:t_id,f_id:f_id},function(data){
                    if('ok'==data){
                        alert('发表成功');

                    }else{
                        alert(data);
                    }
                    history.go(-1);
                });
            }else{
                $.post('ajax.php',{issue_reply:1,content:content,t_id:t_id,f_id:f_id},function(data){
                    if('ok'==data){
                        alert('发表成功');

                    }else{
                        alert(data);
                    }
                    history.go(-1);
                });
            }
        }

    });
    $('.imgItem').click(function(){
        $('#uploadImg').click();

    })
</script>


</body>