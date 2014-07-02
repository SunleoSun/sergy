<?php
$x = 0;
$param = $this->parseFilterParams();
$page = $_GET["page"];
if (!empty($_GET["detail_page"])) {
    $page = $_GET["detail_page"];
}
if (isset($page)) {
    $x = $this->numItemsInPage * ($page - 1);
} else {
    $page = 1;
}
for ($y = 1; $y < 5; $y ++) {
    echo '<div calss="items-row">';
        for (;  $x < $this->numItemsInPage * ($page - 1) + 3*$y 
                && $x < $this->numItemsInPage * $page  
                && $x < count($items); $x++):
        ?>
        <div class="item">
        <?php 
        $this->renderPartial("item", array(
            "item" => $items[$x],
            "category" => $category));
        ?>
        </div>
        <?php
        endfor;
    echo '</div>';
}

?>
