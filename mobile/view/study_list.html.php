<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/study.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/list.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>

<body>
    <div class="content">
        <h1>理论学习</h1>
        <div class="type-containter">
            <?php foreach($type as $row):?>

            <?php endforeach ?>
        </div>
        <?php foreach($qList as $row):?>
            <div class="qu-block">
                <p><span class="q-content"><?php echo $row['content'] ?></span></p>
                <ul id="ExamOpt"style="-webkit-tap-highlight-color: transparent;">
                    <?php $index='A'?>
                    <?php foreach($row['options'] as $orow):?>
                        <li  class="option <?php echo $orow['correct']>0 ? 'kk':'kh'?>" ><?php echo $index.'.'.$orow['content'];?></li>
                        <?php $index++ ?>
                    <?php  endforeach ?>
                </ul>
            </div>
        <?php endforeach ?>
        <div class="floot">
            <?php if($page>0):?>
                <a class="prev foot_prev" href="controller.php?<?php echo $getStr.'&page='.($page-1)?>">
                <img class="a-img" height="20px" src="stylesheet/images/i-11.png"><b>上一页</b>
            </a>
            <?php endif ?>
            <?php if($count==$num):?>
            <a class="forward" href="controller.php?<?php echo $getStr.'&page='.($page+1)?>"><b>下一页</b>
                <img class="a-img" height="20px" src="stylesheet/images/i-12.png">
            </a>
            <?php endif ?>
        </div>
    </div>

</body>

