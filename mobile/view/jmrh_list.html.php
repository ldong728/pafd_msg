<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/jmrh.css?v=<?php echo rand(1000, 9999) ?>"/>
<!--    <style type="text/css">-->
<!---->
<!---->
<!--    </style>-->
</head>

<body>
<div class="wrap">
    <div class="banner">
        <img src="../img/indexbanner.jpg"/>
    </div>
    <div class="nav">
        <ul>
            <li>
                <a>首页</a>
            </li>
            <?php foreach($cateList as $row):?>
           <li <?php echo (mb_strlen($row['name']))/3>5 ?'class="muti-line"':'' ?>>
               <a><?php echo $row['name']?></a>
               <?php if($row['sub']):?>
                    <select class="hidden-select">
                        <option value="-1">选择子分类</option>
                        <?php foreach($row['sub'] as $sRow):?>
                       <option value="<?php echo $sRow['id']?>"><?php echo $sRow['name']?></option>
                       <?php endforeach ?>
                    </select>
                    <?php endif ?>
           </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="module-container">
        <?php foreach($contentList as $row):?>
        <div class="module-block">
            <div class="module-title">
                <?php echo $row['name']?>
            </div>
            <div class="module-more">
                <?php if($row['sub_num']==0):?>
                <a>更多>></a>
                <?php endif ?>
            </div>
            <div class="clear"></div>
            <div class="pic">
                <?php foreach($row['front'] as $fRow):?>
                <li><img src="../<?php echo $fRow['title_img']?>"/></li>
                <?php endforeach ?>
            </div>
            <div class="link">
                <?php foreach($row['pre'] as $pRow):?>
                <li <?php echo $pRow['category']? 'class="li-block"':''?>><a href="controller.php?<?php echo $pRow['category']? 'jmrh_sub='.$pRow['id']:'jm_content='.$pRow['id']?>"><?php echo $pRow['title']?></a></li>
                <?php endforeach ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
</body>