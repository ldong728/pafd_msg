<?php
$type = $GLOBALS['type'];
$nearList = $GLOBALS['nearList'];
$inf=$GLOBALS['inf'];
//$edit=isset($_GET['q_id']);

?>
<style>
    .item_name {
        width: 120px;
    }


</style>

<section>
    <h2><strong>修改题目</strong></h2>
    <ul class="ulColumn2">
        <li>
            <span class="item_name">
                内容：
            </span>
            <textarea class="textarea" id="content" placeholder="请输入题目内容"
                      style="width: 500px; height: 100px"><?php echo $inf['content']?></textarea>
        </li>
        <?php if($inf['type']==1):?>
        <?php for ($i = 0; $i < 2; $i++): ?>
            <li class="dyn op1">
                 <span class="item_name">
            </span><input type="text" class="textbox textbox_295 si1" id="gd<?php echo $inf['options'][$i]['id'] ?>"
                          value="<?php echo $inf['options'][$i]['content'] ?>"/><label class="single_selection"><input type="radio"
                                                                                                            name="correct1"
                                                                                                            class="correct1"
                                                                                                            value="<?php echo $inf['options'][$i]['id'] ?>" <?php echo $inf['options'][$i]['correct']>0 ? 'checked=true':''?>>正确答案</label>
            </li>
        <?php endfor ?>
        <?php endif ?>
        <?php if($inf['type']==2):?>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <li class="dyn op2" style="display: block">
             <span class="item_name">
            </span><input type="text" class="textbox textbox_295 si2" id="si<?php echo $inf['options'][$i]['id'] ?>"
                          placeholder="请输入选项内容 " value="<?php echo $inf['options'][$i]['content'] ?>"/><label class="single_selection"><input type="radio" name="correct2"
                                                                                         class="correct2"
                                                                                         value="<?php echo $inf['options'][$i]['id'] ?>"  <?php echo $inf['options'][$i]['correct']>0 ? 'checked=true':''?>>正确答案</label>
            </li>
        <?php endfor ?>
        <?php endif?>
        <?php if($inf['type']==3):?>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <li class="dyn op3">
                 <span class="item_name">
            </span><input type="text" class="textbox textbox_295 mu" id="mu<?php echo $inf['options'][$i]['id'] ?>"
                          placeholder="请输入选项内容 " value="<?php echo $inf['options'][$i]['content'] ?>"/><label class="single_selection"><input type="checkbox" name="correct"
                                                                                         class="mu_correct"
                                                                                         id="ch<?php echo $inf['options'][$i]['id'] ?>"  <?php echo $inf['options'][$i]['correct']>0 ? 'checked=true':''?>>正确答案</label>
            </li>
        <?php endfor ?>
        <?php endif ?>
        <li><span class="item_name"></span><input type="submit" class="link_btn create_question" value="提交修改"></li>
    </ul>
</section>
<section>
    <div class="page_title"><h2>最近添加</h2></div>
    <table class="table">
        <tr>
            <th>内容</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        <?php foreach($nearList as $row):?>
            <tr>
                <td><a href="index.php?std=1&editQuestion=1&q_id=<?php echo $row['id']?>"><?php echo $row['content']?></a></td>
                <td><?php echo $row['create_time']?></td>
                <td><a class="inner_btn delete" id="<?php echo $row['id']?>">删除</a></td>
            </tr>
        <?php endforeach ?>
    </table>
</section>
<div class="space"></div>

<script>
    var q_id=<?php echo $_GET['q_id'] ?>;
    var type=<?php echo $inf['type'] ?>;
    $('.create_question').click(function () {
        var content = $('#content').val();
        var option = new Array();
        if (3 == type) {
            $('.mu').each(function (k, v) {
                var tempId = v.id.slice(2);
                var op_content = v.value;
                var correct = $('#ch' + tempId).prop('checked') ? 1 : 0;
                option.push({
                    id:tempId,
                    content: op_content,
                    correct: correct
                });
            });
        } else {
            var correct_id=$('input[name="correct'+type+'"]:checked').val();
            $('.si' + type).each(function(k,v){
                var tempId= v.id.slice(2);
                var op_content= v.value;
                var correct = correct_id==tempId? 1 :0;
                option.push({
                    id:tempId,
                    content: op_content,
                    correct: correct
                });
            });

        }
        $.post('ajax_request.php', {std:1,editQuestion: 1,q_id:q_id,content: content, option: option}, function (data) {
            if(data=='ok'){
                alert('修改成功');
                location.reload(true);
            }else{
                alert(data);
            }

        });

    });
    $('.delete').click(function(){
        var q_id=$(this).attr('id');
        if(confirm('确定要删除本题？')){
            $.post('ajax_request.php',{std:1,deleteQuestion:1,q_id:q_id},function(data){
                location.reload(true);
            })
        }

    })


</script>