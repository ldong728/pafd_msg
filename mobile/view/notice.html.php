<head>
    <?php include 'templates/header.php' ?>
</head>

<body>
<div class="wrap">
    <div class="content">
        <?php echo $noticeInf['inf']?>
    </div>
    <div class="review">
        <?php foreach($review as $row):?>
            <?php echo $row['main']['content'] ?>
            <?php foreach($row['subReview'] as $r):?>
                <?php echo $r['content']?>
            <?php endforeach ?>
        <?php endforeach;?>
    </div>
</div>


</body>
