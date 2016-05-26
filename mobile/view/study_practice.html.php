<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/test.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>
<body>
<div class="content">
    <h1>练习</h1>
    <div id="ExamArea">
        <p><span class="index">1</span>.<span class="q-content"><?php echo $inf['content'] ?></span></p>
        <ul id="ExamOpt"style="-webkit-tap-highlight-color: transparent;">
            <?php $index='A'?>
            <?php foreach($inf['options'] as $row):?>
                <li id="oid<?php echo $row['id']?>" class="option <?php echo $inf['type']==3 ? 'khm':'kh'?> <?php echo $row['correct']>0 ? 'crt':''?>" data-v="<?php echo $index?>" style="cursor: pointer"><?php echo $index.'.'.$row['content'];?></li>
                <?php $index++ ?>
            <?php  endforeach ?>
        </ul>
    </div>
    <div> <input class="dxqd" type="button" value="确定，我选好了！"  style="display: <?php echo $inf['type']==3?'block':'none'?>; cursor: pointer"> </div>
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
    var current=<?php echo $inf['id'];?>;
    var type=<?php echo $inf['type']?>;
    var enable=true;
    var list=new Array();
    list.push(current);
    $(document).on('click','.option',function(){
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
                $('#result').css('display','block');
                enable=false;
            }else{
                $(this).toggleClass('kh');
                $(this).toggleClass('kkm');
            }
        }
    });
    $('.dxqd').click(function(){
        $('.option').each(function(k,v){

        });
    });
    $('.forward').click(function(){
        list.push(current);
        getNewQuestion(-1,true,function(id,t){
            type=t;
            current=id
        });

    });
    $('.prev').click(function(){
        var id=list.pop();
        getNewQuestion(id,false,function(id,t){
            type=t;
            current=id;

        })

    })
</script>
<script>
    function getNewQuestion(id,forward,recall){
        enable=true;
        var num=parseInt($('.index').text());
        var type=2;
        var sId=-1;
        if(forward)num++;
        else num--;
        if(num<1){
            return;
        }
        $.post('ajax.php',{std:1,getQuestion:1,id:id},function(data){
            var optype= 'kh';
            var cindex=65;
            var inf=eval('('+data+')');
            $('#ExamOpt').empty();
            $('.dxqd').css('display','none');
            $('.index').text(num);
            $('.q-content').text(inf.content);
            type=inf.type;
            sId=inf.id;
            if(type==3) {
                $('.dxqd').css('display', 'block');
                optype = 'khm';
            }

            $.each(inf.options,function(k,v){

                var crt = v.correct>0? 'crt':'';
                var content='<li id="oid'+ v.id+'" class="option '+optype+' '+crt+'" data-v="'+String.fromCharCode(cindex)+'" style="cursor: pointer">'+String.fromCharCode(cindex)+'.'+ v.content+'</li>';
                cindex++;
                $('#ExamOpt').append(content);
            });
            $('#result').css('display','none');
            recall(sId,type);
        });

    }
</script>
