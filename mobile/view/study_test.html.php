<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/test.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>
<body>
<div class="content">
    <h1>每月一考</h1>

    <div id="ExamArea">
        <p><span class="index">1</span>.<span class="q-content"><?php echo $inf['content'] ?></span></p>
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
    <a class="prev foot_low pre-submit" onclick="javascript:simula_exam.stop();">
        <img class="a-img" height="20px" src="stylesheet/images/i-07.png"><b>交 卷</b>
    </a>
</div>

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
        if (enable) {
            if (type < 3) {
                $('.option').removeClass('kk');
                $(this).addClass('kk');
                $('.option').each(function (k, v) {
                    var ba=($(v).hasClass('crt'));
                    var bb=($(v).hasClass('kk'));
                    if (ba^bb){
                        c = false;
                    }
                })
            } else {
                $(this).toggleClass('kh');
                $(this).toggleClass('kkm');
                $('.option').each(function (k, v) {
                    var ba=($(v).hasClass('crt'));
                    var bb=($(v).hasClass('kkm'));
                    if (ba^bb){
                        c = false;
                    }
                })
            }
            reply[itrt]['crt'] = c;
        }

    });
    $('.forward').click(function () {
        if (itrt < list.length - 1) {
            itrt++;
            getTestQuestion(list[itrt], true, function (id, t) {
                type = t;
                current = id
            });
        } else {

        }


    });
    $('.j-prev').click(function () {
        if (itrt > 0) {
            itrt--;
            getTestQuestion(list[itrt], false, function (id, t) {
                type = t;
                current = id;

            })
        } else {

        }

    })
    $('.pre-submit').click(function(){
        var count=0;
        var tottalScore=0;
        $.each(reply,function(k,v){
            alert(v.crt);
        })
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
            $('#ExamOpt').empty();
            $('.dxqd').css('display', 'none');
            $('.index').text(num);
            $('.q-content').text(inf.content);
            type = inf.type;
            sId = inf.id;
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
</script>
