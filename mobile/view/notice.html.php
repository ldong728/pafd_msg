<head>
    <?php include 'templates/header.php' ?>
    <style type="text/css">
        img {
            max-width: 100%;
        }
        .review {
            width: 100%;
            position: relative;
            margin-top: 20px;
            border-top:1px #ddd solid;
            font-size: 15px;;
        }
        .review-block {
            overflow: hidden;
            zoom:1;
            position: relative;
            width: 90%;
            margin: 0 auto;
            padding: 5px 0;
            min-height: 80px;
        }
        .review-block .sub-block{
            overflow: hidden;
            zoom:1;
            position: relative;
            width: 90%;
            margin: 0 auto 0 8%;
            padding: 5px 0;
            min-height: 60px;
        }
        .review-block .img-block {
            float: left;
            width: 50px;
            height: 50px;
            border-radius: 2px;
        }
        .review-block .content-block {
            display: inline-block;
            float:left;
            min-height: 60px;
            padding-left: 8px;

        }
        .content-block .nickname {
            color:gray;
            font-size: 0.9em;;
        }
        .content-block .content {
            font-size: 1em;
        }
        .content-block .time {
            color:gray;
            font-size: 0.8em;;
        }


    </style>
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
