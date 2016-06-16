<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/pafd.css?v=<?php echo rand(1000, 9999) ?>"/>
    <link rel="stylesheet" href="stylesheet/jmrh.css?v=<?php echo rand(1000, 9999) ?>"/>
</head>

<body>
<div class="wrap">
    <div class="banner">
        <img src="../img/indexbanner.jpg"/>
    </div>
    <div class="nav">
        <ul>
            <li>
                <a href="controller.php?jmrh=1&static=1">首页</a>
            </li>
            <?php foreach($cateList as $row):?>
                <li <?php echo (mb_strlen($row['name']))/3>5 ?'class="muti-line"':'' ?>>
                    <a <?php echo $row['sub_num']==0 ? 'href="controller.php?jmrh_sub='.$row['id'].'"':'' ?>><?php echo $row['name']?></a>
                    <?php if($row['sub']):?>
                        <select class="hidden-select j-cate-select">
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
            <div class="module-block">
                <div class="module-title">
                    <?php echo $cateName ?>
                </div>
                <div class="module-more">
                </div>
                <div class="clear"></div>
<!--                <div class="pic">-->
<!--                    --><?php //foreach ($row['front'] as $fRow): ?>
<!--                        <li><a href="controller.php?jm_content=--><?php //echo $fRow['id'] ?><!--"><img-->
<!--                                    src="../--><?php //echo $fRow['title_img'] ?><!--"/></a></li>-->
<!--                    --><?php //endforeach ?>
<!--                </div>-->
                <div class="link" style="width: 100%; padding-left: 20px">
                    <?php foreach ($newsList as $pRow): ?>
                        <li><a
                                href="controller.php?jm_content=<?php echo $pRow['id'] ?>"><?php echo $pRow['title'] ?></a>
                        </li>
                    <?php endforeach ?>
                </div>
            </div>
    </div>
</div>
</body>
<script>
    $('.j-cate-select').change(function(){
        var id=$(this).val();
        window.location.href='controller.php?jmrh_sub='+id;
    })
</script>