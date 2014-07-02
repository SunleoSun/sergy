<form enctype="multipart/form-data" method="post" action="">
    <?php
    echo CHtml::label('Файл изображения::','file');
    echo CHtml::fileField('file');
    echo CHtml::submitButton("Загрузить фото");
    ?>
</form>