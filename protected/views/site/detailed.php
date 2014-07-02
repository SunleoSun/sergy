<?php 
$params = $this->parseFilterParams();
$category = $_GET['category'];
$page = $_GET['page'];
$categoryID = 0;
switch ($category) {
    case "Etno":
        $categoryID = 1;
        break;
    case "Classic":
        $categoryID = 2;
        break;
    case "Stones":
        $categoryID = 3;
        break;
    case "Modern":
        $categoryID = 4;
        break;
    case "Braces":
        $categoryID = 5;
        break;
}
$this->renderPartial("menu",  array("category" => $categoryID));?>

<div class="detailed-body" id="body">
    <div class="page-buttons back-button">
        <a href="/?r=site/<?php echo $category.$params."&page=$page";?>#menu" class="page">Назад</a>
    </div>
    <div class="item_detailed_img" style="background-image: <?php echo "url(/images/Items/" . $item->id . ".jpg" ?>)" title="<?php echo $item->name ?>"></div>
    <div class="item_detailed_name"><?php echo $item->name ?></div>
    <div class="item_detailed_price"><?php echo $item->price . " грн." ?></div>
    <div class="table">
        <div class="item_detailed_string item_detailed_category">
            <h2>Категория:</h2>
            <div class="detailed_text"><?php echo $item->category; ?></div>
        </div>
        <?php
        if (isset($item->length)):
            ?>
            <div class="item_detailed_string">
                <h2>Длина (см):</h2>
                <div class="detailed_text"><?php echo $item->length; ?></div>
            </div>
            <?php
        endif;
        if (isset($item->width)):
            ?>
            <div class="item_detailed_string">
                <h2>Ширина (см):</h2>
                <div class="detailed_text"><?php echo $item->width; ?></div>
            </div>
            <?php
        endif;
        if (isset($item->diameter)):
            ?>
            <div class="item_detailed_string">
                <h2>Диаметр бусин (см):</h2>
                <div class="detailed_text"><?php echo $item->diameter; ?></div>
            </div>
            <?php
        endif;
        ?>
        <div class="item_detailed_string">
            <h2>Материалы:</h2>
            <div class="detailed_text">
                <?php
                for ($x = 0; $x < count($item->materials); $x++) {
                    echo $item->materials[$x]["Name"] . "<br>";
                }
                ?>
            </div>
        </div>
        <div class="item_detailed_string">
            <h2>Цвета:</h2>
            <div class="detailed_text">
                <?php
                for ($x = 0; $x < count($item->colors); $x++) {
                    echo $item->colors[$x]["Name"] . "<br>";
                }
                ?>
            </div>
        </div>
        <?php
        if (isset($item->description) && $item->description != ""):
            ?>
            <div class="item_detailed_string">
                <h2>Детальное описание:</h2>
                <div class="detailed_text"><?php echo $item->description; ?></div>
            </div>
            <?php
        endif;
        ?>
    </div>
    <div class="page-buttons back-button">
        <a href="/?r=site/<?php echo $category.$params."&page=$page";?>#menu" class="page">Назад</a>
    </div>
    
    <h2 id="same-items-header" class="same-items-header">Украшения аналогичного цвета:</h2>
    
    <div class="items-detailed">
    <?php $this->renderPartial("items",  array(
            "items" => $items,
            "category" => $_GET["category"]
        ));?>
        <div class="page-buttons">
            <?php 
            $this->renderPartial("pageButtons",  array(
                    "items" => $items,
                    "category" => "detailed",
                    "target" => "same-items-header"
            ));?>    
        </div>
    </div>
    
    
</div>