<head>
    <?php include 'templates/header.php' ?>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <script src="../js/lazyload.js"></script>
</head>

<body>
    <div class="wrap">
        <?php foreach($review as $row):?>
        <div class="review_block"id="block<?php echo $row['d_id']?>">
            <div class="goods-inf">
                <img src="../<?php echo $row['url']?>"/>
                <div class="name">
                    <span><?php echo $row['produce_id']?>:</span><span><?php echo $row['category']?></span>
                </div>
            </div>
            <div class="score"id="score<?php echo $row['d_id']?>">
                <p>评分：</p>
                <?php for($i=1;$i<6;$i++):?>
                <div class="score-block light"id="<?php echo $i.$row['d_id']?>"></div>
                <?php endfor?>
                <p class="avl">非常满意</p>
                <input type="hidden"id="sval<?php echo $row['d_id']?>"value="5"/>

            </div>
            <div class="review_content">
                <p class="title">评价：</p>
                <textarea class="content"id="cont<?php echo $row['d_id']?>"></textarea>
            </div>
            <div class="imgBlock"id="imgb<?php echo $row['d_id']?>">
                <p>图片：</p>
<!--                <img class="review-demo"src="../g_img/ad_img/6.jpg"/>-->
                <div class="imginput"id="up<?php echo $row['d_id']?>"></div>
            </div>
            <input type="hidden"id="gid<?php echo $row['d_id']?>"value="<?php echo $row['g_id']?>"/>
            <a class="submit-review" id="subm<?php echo $row['d_id']?>">提交</a>

        </div>

        <?php endforeach?>
        <div class="toast"></div>
        <?php include_once 'templates/foot.php'?>
    </div>



</body>
<script>
//    var g_id='<?php //echo $row['g_id']?>//';
    var orderId='<?php echo $_GET['order_id']?>'
    var images=new Array();
</script>
<?php include 'templates/jssdkIncluder.php'?>
<script>
        wx.ready(function(){
            $('.imginput').click(function(){
                images=new Array();
                var d_id=$(this).attr('id').slice(2);
                var g_id=$('#gid'+d_id).val();
                wx.chooseImage({
                    count: 4, // 默认9
                    sizeType: [ 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        $.each(localIds,function(k,v){
                            var content='<img class="review-demo" src="'+v+'"/>'
                            $('#up'+d_id).before(content);
                            wx.uploadImage({
                                localId: v.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
                                isShowProgressTips: 1, // 默认为1，显示进度提示
                                success: function (res) {
                                    var serverId = res.serverId;
                                    images.push(serverId);
                                }
                            });
                        });

                    }
                });
            })
        })
</script>

<script>
    $('.score-block').click(function(){
        var score=$(this).attr('id').slice(0,1);
        var id=$(this).attr('id').slice(1)
        $(this).addClass('light');
        $(this).prevAll('.score-block').addClass('light');
        $(this).nextAll('.score-block').removeClass('light');
        $(this).nextAll('.avl').empty();
        $(this).nextAll('.avl').append(getAvl(score));
        $('#sval'+id).val(score)
    })
    $('.submit-review').click(function(){
        var id=$(this).attr('id').slice(4);
        var g_id=$('#gid'+id).val();
        var content=$('#cont'+id).val();
        var score=$('#sval'+id).val();
        $.post('ajax.php',{submitReview:1,order_id:orderId,d_id:id,review:content,g_id:g_id,score:score,image:images},function(data){
            showToast('评价成功')
            $('#block'+id).remove();
            if(data=='done'){
                window.location.href='controller.php?customerInf=1';
            }
        });

    })

    function getAvl(score){
        var a=['很不满意','不满意','一般','满意','非常满意']
        return a[score-1];
    }
</script>
