<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/test.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/alert.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>
<body>
<div class="content">
    <h1>每月一考</h1>

    <div id="ExamArea">
        <p><span class="index">1</span>.<span class="q-content"><?php echo $inf['content'] ?><span style="color: red"><?php echo $inf['type']==3?'（多选）':''?></span></span></p>
        <ul id="ExamOpt" style="-webkit-tap-highlight-color: transparent;">
            <?php $index = 'A' ?>
            <?php foreach ($inf['options'] as $row): ?>
                <li id="oid<?php echo $row['id'] ?>"
                    class="option <?php echo $inf['type'] == 3 ? 'khm' : 'kh' ?> <?php echo $row['correct'] > 0 ? 'crt' : '' ?>"
                    data-v="<?php echo $index ?>"
                    style="cursor: pointer"><?php echo $index . '.' . $row['content']; ?></li>
                <?php $index++ ?>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<div class="floot">
    <a class="j-prev prev foot_low">
        <img class="a-img" src="stylesheet/images/i-11.png"><b>上一题</b>
    </a>
    <a class="prev foot_low forward"><b>下一题</b>
        <img class="a-img" height="20px" src="stylesheet/images/i-12.png">
    </a>
    <a class="prev foot_low pre-submit">
        <img class="a-img" height="20px" src="stylesheet/images/i-07.png"><b>交 卷</b>
    </a>
</div>
<div id="dvMsgBox" style="width: 200px; display: block; top: 280px; left: 89px;display: none">
    <div class="top">
        <div class="rightAlert">
            <div class="title" id="dvMsgTitle"></div>
        </div>
    </div>
    <div class="body">
        <div class="rightAlert">
            <div class="ct" id="dvMsgCT">
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="bottom" id="dvMsgBottom" style="height: 38px;">
        <div class="right">
            <div class="btn" id="dvMsgBtns">
                <div class="height"></div>
                <input type="button" class="btn sub-confirm" value="确   认"></div>
        </div>
    </div>
</div>
<div class="loading"></div>

</body>
<script>
    var current =<?php echo $inf['id'];?>;
    var type =<?php echo $inf['type']?>;
    var str = '<?php echo $total?>';
    var list = eval('(' + str + ')');
    var reply = {};
    var itrt = 0;
    var enable = true;
    $(document).on('click', '.option', function () {
        var c = true;
        var o_id = $(this).attr('id').slice(3);
        if (!reply[itrt])reply[itrt] = {};
        if (enable) {
            if (type < 3) {
                $('.option').removeClass('kk');
                $(this).addClass('kk');
                reply[itrt].choice = o_id;
                $('.option').each(function (k, v) {
                    var ba = ($(v).hasClass('crt'));
                    var bb = ($(v).hasClass('kk'));
                    if (ba ^ bb) {
                        c = false;
                    }

                })
            } else {
                $(this).toggleClass('kh');
                $(this).toggleClass('kkm');
                if ($(this).hasClass('kkm')) {
                    reply[itrt][o_id] = true;
                }
                else {
                    reply[itrt][o_id] = false;
                }
                $('.option').each(function (k, v) {
                    var ba = ($(v).hasClass('crt'));
                    var bb = ($(v).hasClass('kkm'));
                    if (ba ^ bb) {
                        c = false;
                    }
                })
            }
            reply[itrt].crt = c;
        }

    });
    $('.forward').click(function () {
        if (itrt < list.length - 1) {
            loading();
            itrt++;
            getTestQuestion(list[itrt], true, function (id, t) {
                type = t;
                current = id
                restorSituation(reply[itrt]);
                stopLoading();

            });
        } else {

        }


    });
    $('.j-prev').click(function () {
        if (itrt > 0) {
            loading();
            itrt--;
            getTestQuestion(list[itrt], false, function (id, t) {
                type = t;
                current = id;
                restorSituation(reply[itrt]);
                stopLoading();
            })
        } else {

        }

    })
    $('.pre-submit').click(function () {
        var count = 0;
        var totalScore = 0;
        $.each(reply, function (k, v) {
            count++;
            if(v.crt)totalScore+=2;
        })
        var content='您一共做了'+count+'题，得了'+totalScore+'分，点击确定重新考试。';
        $.post('ajax.php',{std:1,uploadScore:1,q_count:count,score:totalScore},function(data){
            if(data=='time_out'){
                alert('超时，请关闭页面重新从公众号进入');
            }else{
                $('#dvMsgCT').text(content);
                $('#dvMsgBox').fadeIn();
            }
        });

    })
    $('.sub-confirm').click(function(){
        window.location.href='controller.php?study=1&test=1';
    })
</script>
<script>
    function getTestQuestion(id, forward, recall) {
        enable = true;
        var num = parseInt($('.index').text());
        var type = 2;
        var sId = -1;
        if (forward)num++;
        else num--;
        if (num < 1) {
            return;
        }
        $.post('ajax.php', {std: 1, getQuestion: 1, id: id}, function (data) {
            var optype = 'kh';
            var cindex = 65;
            var inf = eval('(' + data + ')');
            var typeMark='';
            $('#ExamOpt').empty();
            $('.dxqd').css('display', 'none');
            $('.index').text(num);

            type = inf.type;
            sId = inf.id;

            $('.q-content').text(inf.content);
            if(type==3){
                typeMark='<span style="color: red">（多选题）</span>';
                $('.q-content').append(typeMark);
            }

            if (type == 3) {
                optype = 'khm';
            }
            $.each(inf.options, function (k, v) {
                var crt = v.correct > 0 ? 'crt' : '';
                var content = '<li id="oid' + v.id + '" class="option ' + optype + ' ' + crt + '" data-v="' + String.fromCharCode(cindex) + '" style="cursor: pointer">' + String.fromCharCode(cindex) + '.' + v.content + '</li>';
                cindex++;
                $('#ExamOpt').append(content);
            });
            $('#result').css('display', 'none');
            recall(sId, type);
        });
    }
    function restorSituation(sReply) {
        if (sReply) {
            if (type == 3) {
                $.each(sReply, function (k, v) {
                    if (v)$('#oid' + k).addClass('kkm');
                })
            } else {
                if ('choice' in sReply)$('#oid' + sReply.choice).addClass('kk');
            }
        }

    }
</script>
