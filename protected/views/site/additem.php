<?php
echo CHtml::beginForm();
?>

    <div class="description-data-left">

        <?php
        echo CHtml::hiddenField('AddItemForm','AddItemForm');
        $categories = DBManager::getCategories();
        echo CHtml::label('Категория:','category');
        echo CHtml::dropDownList('category', $categories[0], $categories, array('class' => 'descr'));
        echo CHtml::label('Имя:','name');
        echo CHtml::textField('name','', array('class' => 'descr', 'id' => 'name'));
        echo CHtml::label('Ширина:','width');
        echo CHtml::numberField('width', '', array('class' => 'descr', 'id' => 'width'));
        echo CHtml::label('Длина:','length');
        echo CHtml::numberField('length', '', array('class' => 'descr', 'id' => 'length'));
        echo CHtml::label('Диаметр бусин:','diameter');
        echo CHtml::numberField('diameter', '', array('class' => 'descr', 'id' => 'diameter'));
        echo CHtml::label('Цена (грн):','price');
        echo CHtml::numberField('price', 1, array('class' => 'descr', 'id' => 'price'));
        echo CHtml::label('Описание:','description');
        echo CHtml::textArea('description', '', array('class' => 'descr', 'id' => 'description'));
        echo CHtml::button('Добавить предмет в БД', array('id'=>'addItem', 'class'=>'add-item-button'));
        ?>
    </div>

    <div class="img-border">
        <div class="upload-img"></div>
    </div>


    <div class="description-data-right">
        <div class="color">
            <?php
            $colors = DBManager::getColors();
            echo CHtml::label('Цвет:','color');
            echo CHtml::dropDownList('color', $colors[0], $colors, array('class' => 'descr'));
            echo CHtml::button('Добавить цвет', array('id'=>'addColor', 'class'=>'add-item-button'));
            echo CHtml::button('Удалить цвет', array('id'=>'deleteColor', 'class'=>'add-item-button'));
            ?>
        </div>
        <div class="material">
            <?php
            $materials = DBManager::getMaterials();
            echo CHtml::label('Материал:','material');
            echo CHtml::dropDownList('material', $materials[0], $materials, array('class' => 'descr'));
            echo CHtml::button('Добавить материал', array('id'=>'addMaterial', 'class'=>'add-item-button'));
            echo CHtml::button('Удалить материал', array('id'=>'deleteMaterial', 'class'=>'add-item-button'));
            ?>
        </div>
    </div>
<?php
echo CHtml::endForm();
?>

