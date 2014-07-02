<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script language="JavaScript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/main.js" ></script>
</head>

<body>
<div class="main-div">
    <div class="top-img">
        <div class="slogan">
            <p>Милые девушки и женщины!</p>
            <p>Для Вас представлена коллекция <span>браслетов</span>,
                большое разнообразие <span>сережек</span>, <span>ожерелий</span>
                и других украшений авторского дизайна.</p>
            <p>Надеюсь, что мои изделия понравятся многим девушкам и женщинам.
                А, как известно, они у нас <span>самые красивые!</span>
            </p>
        </div>
    </div>
    
    <?php echo $content; ?>
</div>

</body>
</html>
