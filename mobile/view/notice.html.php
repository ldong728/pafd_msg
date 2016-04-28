<head>
    <?php include 'templates/header.php' ?>
    <style type="text/css">
        img {
            max-width: 100%;
        }
        .review {
            width: 100%;
            position: relative;
            margin-top: 10px;
            padding-top: 30px;

            border-top:1px #ddd solid;
            font-size: 15px;;
        }
        .review-block {
            overflow: hidden;
            zoom:1;
            position: relative;
            width: 90%;
            margin: 0 auto;
            padding: 5px 0;
            min-height: 80px;
        }
         .sub-block{
            overflow: hidden;
            zoom:1;
            position: relative;
            width: 80%;
            margin: 0 auto 0 10%;
            padding: 0;
            min-height: 50px;
        }
         .sub-img-block{
             float: left;
             width: 30px;
             height: 30px;
             border-radius: 2px;
         }
        .review-block .img-block {
            float: left;
            width: 40px;
            height: 40px;
            border-radius: 2px;
        }
        .review-block .content-block {
            display: inline-block;
            float:left;
            min-height: 60px;
            padding-left: 8px;

        }
        .content-block .nickname {
            color:gray;
            font-size: 0.9em;;
        }
        .content-block .content {
            font-size: 1em;
        }
        .content-block .time {
            color:gray;
            font-size: 0.8em;
        }
        .reviewbutton {
            position: absolute;
            display: block;
            right: 5%;
            top:0;
            color: gray;
            width: 80px;
            height: 30px;
            border: none;
            font-size: 1em;
            line-height: 30px;
        }
        .hidden-container {
            position: fixed;
            width: 100%;
            height: 100%;
            display: none;
            top:0;
            left:0;
            /*background-color: rgba(0 0 0 0.8);*/
        }
        .hidden-content {
            box-sizing: border-box;
            position: fixed;
            top:35%;
            left: 10%;
            width: 80%;
            background-color: #ffffff;
            border-radius: 5px;
            padding: 15px;
        }
        .hidden-content textarea{
            border: 1px solid #ddd;
            border-radius: 3px;
            width: 100%;
            height: 150px;
            font-size: 15px;
            padding: 5px;
            margin-bottom: 20px;
            resize: none;
        }
        .hidden-content button {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 3px;
            background-color: #45C018;
            color:#ffffff;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 4px;
        }
        .hidden-content button.red {
            margin-top: 10px;
            background-color: #E3413E;
        }
        .reply{
            display: inline-block;
            float:right;
            background-color: #ddd;
            padding: 0 5px;
            margin-left: 5px;
            border-radius: 2px;

        }



    </style>
</head>


<body>
<div class="wrap">
    <div class="content">
        <?php echo $noticeInf['inf']?>
    </div>
    <div class="review">
        <a class="reviewbutton">写留言</a>

        <?php foreach($review as $row):?>
            <div class="review-block">
                <div class="img-block"><img src="<?php echo $row['main']['img']?>"/></div>
                <div class="content-block">
                    <div class="nickname"><span class="nick"><?php echo $row['main']['nickname']?></span><a class="reply"id="<?php echo $row['main']['id']?>">回复</a></div>
                    <div class="content"><?php echo $row['main']['content'] ?></div>
                    <div class="time"><?php echo $row['main']['review_time'] ?></div>
                </div>
                <?php foreach($row['subReview'] as $r):?>
                    <div class="sub-block">
                        <div class="sub-img-block"><img src="<?php echo $r['img']?>"/></div>
                        <div class="content-block">
                            <div class="nickname"><?php echo $r['nickname']?></div>
                            <div class="content"><?php echo $r['content']?></div>
                            <div class="time"><?php echo $r['review_time'] ?></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div class="hidden-container">
    <div class="hidden-content">
        <textarea class="review-input"placeholder="点击此处输入"></textarea>
        <button class="submit-review ">提交留言</button>
        <button class="red">关闭</button>
        <input type="hidden"class="f_id"value="-1"/>
    </div>
</div>


</body>
<script>
    var openid='<?php echo $open_id?>';
    var noticeid=<?php echo $noticeInf['id']?>;
    $('.reviewbutton').click(function(){
        $('.review-input').attr('placeholder','点击此处输入');
        $('.f_id').val(-1);
        $('.hidden-container').fadeIn('fast');
    });
    $('.red').click(function(){
       $('.hidden-container').fadeOut('fast');
    });
    $('.submit-review').click(function(){
        var f_id=$('.f_id').val();
        var content=$('.review-input').val();
        $.post('ajax.php',{inputReview:1,openid:openid,noticeid:noticeid,content:content,f_id:f_id},function(data){
            if('ok'==data){
                $('.hidden-container').fadeOut('fast',function(){
                   location.reload(true);
                });
            }else{
                alert('请于'+data+'秒后再试');
            }
        });

    });
    $('.reply').click(function(){
        var reviewid=$(this).attr('id');
        var f_nick=$(this).siblings('.nick').text();
        $('.review-input').attr('placeholder','回复'+f_nick);
        $('.f_id').val(reviewid);
        $('.hidden-container').fadeIn('fast');
    })
</script>
