<head>
    <?php include 'templates/header.php' ?>
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
    </div>

</body>

