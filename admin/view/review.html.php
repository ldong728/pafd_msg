<?php
$limit=$GLOBALS['limit'];
$review=$GLOBALS['review'];
?>

<div class="module-block review-block">
    <div class="module-title">
        评价管理
    </div>

    <?php foreach($review as $row):?>
        <div class="review-box"id="box<?php echo $row['id']?>">
            <div class="reviews">
                <?php echo $row['review']?>
            </div>
            <div class="score">
                评分：<?php echo $row['score']?>
            </div>
            <div class="priority">
                优先级：<input type="tel"id="pri<?php echo $row['id']?>"value="<?php echo $row['priority']?>"/>
            </div>
            <button class="butt" id="public<?php echo $row['id']?>">公开</button>
            <button class="butt" id="delete<?php echo $row['id']?>">删除</button>

        </div>
    <?php endforeach?>
</div>
<script>
    $(document).on('click','.butt',function(){
//        alert('haha')
        var mode=$(this).attr('id').slice(0,6);
        var id=$(this).attr('id').slice(6);
        if(mode=='public'){
            var data={manageReview:1,id:id,public:1,priority:$('#pri'+id).val()}

        }else{
           var data={manageReview:1,id:id,public:0,priority:9}
        }
        $.post('ajax_request.php',data,function(data){
            showToast('Done');
//            alert(data);
            $('#box'+id).remove();
        })
    })

</script>