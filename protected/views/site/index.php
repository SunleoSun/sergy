<?php $this->renderPartial("menu", array("category" => $categoryID)); ?>

<div class="main-body" id="body">
    <div class="filter-panel">
        <?php
        $getPagams = array();
        parse_str($url_params, $getPagams);
        $this->renderPartial("filterPanel");
        ?>
    </div>
    <div class="items">
        <?php
        $this->renderPartial("items", array(
            "items" => $items,
            "category" => $this->getAction()->id));
        ?>
    </div>
    <div class="page-buttons page-buttons-main">
        <?php $this->renderPartial("pageButtons",  array(
            "items" => $items,
            "category" => $categoryID
        ));?>  
    </div>
</div>