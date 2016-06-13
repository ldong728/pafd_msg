<?php
$fc = $GLOBALS['fc'];
$sc = $GLOBALS['sc'];
?>
<section>
    <h2><strong>类别管理</strong></h2>
    <section>
        <div class="page_title"><h2>主分类</h2></div>
        <div>
            <table class="table">
                <tr>
                    <th>分类名</th>
                    <th>子分类</th>
                    <th>操作</th>
                </tr>
                <?php foreach($fc as $row):?>
                    <tr>
                        <td id="fName<?php echo $row['id']?>"><?php echo $row['name']?></td>
                        <td><?php echo $row['sub_num']?></td>
                        <td>
                            <a class="inner_btn altFc" id="alt<?php echo $row['id']?>">修改</a>
                            <a class="inner_btn adds" id="fad<?php echo $row['id']?>">添加子分类</a>
                            <?php if($row['sub_num']==0):?><a class="inner_btn del" id="del<?php echo $row['id']?>">删除</a><?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="3"><a class="link_btn addf" style="color: #ffffff">新增主分类</a></td>
                </tr>
            </table>

        </div>
    </section>
    <section>
        <div class="page_title"><h2>子分类</h2></div>
        <div style="overflow: hidden;zoom: 1">
            <?php foreach($sc as $k=>$row):?>
                <table class="table fl " style="margin: 15px 20px; width: 40%">
                    <tr>
                        <th colspan="2"><?php echo $row['name']?></th>
                    </tr>
                    <?php foreach($row['sc'] as $sRow):?>
                        <tr>
                            <td id="sName<?php echo $sRow['id']?>"><?php echo $sRow['name']?></td>
                            <td><a class="inner_btn alts" id="alts<?php echo $sRow['id']?>">修改</a>
                                <a class="inner_btn del" id="del<?php echo $sRow['id']?>">删除</a>
                        </tr>
                    <?php endforeach ?>
                    <tr><td colspan="2"><a class="link_btn adds" id="add<?php echo $k ?>" style="color: #ffffff">新增子分类</a></td></tr>
                </table>
            <?php endforeach ?>
        </div>
    </section>
</section>
<section class="pop_bg cate_edit">
    <div class="pop_cont">
        <h3 class="cate_type">主类编辑</h3>
        <div class="pop_cont_input">
            <ul>
                <li>
                    <span>名称</span>
                    <input type="text" class="textbox name" placeholder="请输入类名"/>
                </li>
            </ul>
        </div>
        <div class="btm_btn">
            <input type="hidden" id="c_id"/>
            <input type="hidden" id="type"/>
            <input type="button" value="确认" class="input_btn trueBtn"/>
            <input type="button" value="关闭" class="input_btn falseBtn"/>
        </div>
    </div>
</section>

<div class="space"></div>

<script>
    $('.altFc').click(function(){
        var c_id=$(this).attr('id').slice(3)
        var oName=$('#fName'+c_id).text();
        $('#c_id').val(c_id);
        $('#type').val('altf');
        $('.sc_input').hide();
        $('.name').val(oName);
        $('.cate_edit').show();
    });
    $('.addf').click(function(){
        $('.cate_type').text('添加主类');
        $('#type').val('addf');
        $('.name').val('');
        $('.sc_input').hide();
        $('.cate_edit').show();
    });
    $('.adds').click(function(){
        $('.cate_type').text('添加子类');
        var f_id=$(this).attr('id').slice(3);
        $('#c_id').val(f_id);
        $('#type').val('adds');
        $('.sc_input').show();
        $('.cate_edit').show();
    });
    $('.alts').click(function(){
        var c_id=$(this).attr('id').slice(4);
        var name=$('#sName'+c_id).text();
            $('.cate_type').text('编辑子类');
            $('#c_id').val(c_id);
            $('#type').val('alts');
            $('.name').val(name);
            $('.sc_input').show();
            $('.cate_edit').show();
    });
    $('.del').click(function(){
       var id=$(this).attr('id').slice(3);
        if(confirm('确定要删除此分类？')){
            loading();
            $.post('ajax_request.php',{delJmCate:1,id:id},function(data){
                stopLoading();
                id(1==data){
                    location.reload(true);
                }else{
                    alert('无法删除');
                }
            });
        }

    });

    $('.falseBtn').click(function(){
        $('.cate_edit').hide();
    })
    $('.trueBtn').click(function(){
        cateAlter(function(data){
            $('.cate_edit').hide()
            location.reload(true);
        });

    });

    function cateAlter(recall){
        loading();
        var type=$('#type').val();
        var c_id=$('#c_id').val();
        var name= $('.name').val();
        var e_name=$('.e_name').val();
        if(name!=''){
            $.post('ajax_request.php',{configJmCate:1,type:type,id:c_id,name:name,e_name:e_name},function(data){
                recall(data);
                stopLoading();


            })
        }

    }

</script>
