<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/test.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>
<body>
<div class="content">
    <h1>练习</h1>
    <div id="ExamArea">
        <p><span class="index">1</span>.<span class="content"><?php echo $inf['content'] ?></span></p>
        <ul id="ExamOpt"style="-webkit-tap-highlight-color: transparent;">
            <?php $index='A'?>
            <?php foreach($inf['options'] as $row):?>
                <li id="oid<?php echo $row['id']?>" class="option <?php echo $inf['type']==3 ? 'khm':'kh'?> <?php echo $row['correct']>0 ? 'crt':''?>" data-v="<?php echo $index?>" style="cursor: pointer"><?php echo $index.'.'.$row['content'];?></li>
                <?php $index++ ?>
            <?php  endforeach ?>
        </ul>
    </div>
    <pre id="result" style="display: none">
        您的答案： <font color="#ff0000"><b id="yours">C</b></font>正确答案是： <font color="#229922"><b id="right">B</b></font>
			</pre>
</div>
<div class="floot">
    <a class="prev foot_prev">
        <img class="a-img" src="stylesheet/images/i-11.png"><b>上一题</b>
    </a>
    <a class="forward"><b>下一题</b>
        <img class="a-img" height="20px" src="stylesheet/images/i-12.png">
    </a>
</div>

</body>
<script>
    var type=<?php echo $inf['type']?>;
    var enable=true;
    $('.option').click(function(){
        if(enable){
            if(type<3){
                $(this).removeClass('kh');
                if($(this).hasClass('crt')){
                    $(this).addClass('kk');
                    var y=$(this).data('v');
                    var r=$(this).data('v');
                }else{
                    $(this).addClass('ke');
                    $('.crt').addClass('kk');
                    var y=$(this).data('v');
                    var r=$('.crt').data('v');
                }
                $('#yours').text(y);
                $('#right').text(r);
            }else{

            }
            $('#result').css('display','block');
            enable=false;
        }
    });
    $('.forward').click(function(){
        var num=parseInt($('.index').text());
        num++;
        alert(num);
        $.post('ajax.php',{std:1,getRandom:1},function(data){
            var inf=eval('('+data+')');
            type=inf.type;
            $('.index').text(num);
            $('.content').text(inf.content);
            $('#ExamOpt').empty();
            $.each(inf.options,function(k,v){
                var optype= type==3? 'khm':'kh';
                var crt = v.correct>0? 'crt':'';
//                var content='<li id="oid'+ v.id+'" class="option '+optype+' '+crt+'" data-v="></li>';

            });
        })
    });
</script>
