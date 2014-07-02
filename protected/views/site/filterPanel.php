<span class="label-main"> Цвет:</span>
<?php
$getPagams = $this->getFilterParams();
$colors = DBManager::getColors();
$colors[-1] = "Не выбрано";
$color = isset($getPagams['Color']) ? $getPagams['Color'] : -1;
echo CHtml::dropDownList('color', $color, $colors, array('class' => 'drop-down', "id" => "color"));
?>
<span class="label-main">Материал:</span>
<?php
$materials = DBManager::getMaterials();
$materials[-1] = "Не выбрано";
$material = isset($getPagams['Material']) ? $getPagams['Material'] : -1;
echo CHtml::dropDownList('material', $material, $materials, array('class' => 'drop-down', "id" => "material"));
?>
<span class="label-main">Длина изделия (см):</span>
<div class="group">
    <span class="label-low">От:</span>
    <?php
    echo CHtml::numberField('from-height', $getPagams["FromHeight"], array('class' => 'numeric', "id" => "from-height"));
    ?>
    <span class="label-low">До:</span>
    <?php
    echo CHtml::numberField('to-height', $getPagams["ToHeight"], array('class' => 'numeric', "id" => "to-height"));
    ?>
</div>
<span class="label-main">Ширина изделия (см):</span>
<div class="group">
    <span class="label-low">От:</span>
    <?php
    echo CHtml::numberField('from-width', $getPagams["FromWidth"], array('class' => 'numeric', "id" => "from-width"));
    ?>
    <span class="label-low">До:</span>
    <?php
    echo CHtml::numberField('to-width', $getPagams["ToWidth"], array('class' => 'numeric', "id" => "to-width"));
    ?>
</div>
<span class="label-main">Цена (грн):</span>
<div class="group">
    <span class="label-low">От:</span>
    <?php
    echo CHtml::numberField('from-price', $getPagams['FromPrice'], array('class' => 'numeric', "id" => "from-price"));
    ?>
    <span class="label-low">До:</span>
    <?php
    echo CHtml::numberField('to-price', $getPagams['ToPrice'], array('class' => 'numeric', "id" => "to-price"));
    ?>
</div>
<?php
echo CHtml::button('Применить фильтр', array("class" => "button", "id" => "filter"));
?>