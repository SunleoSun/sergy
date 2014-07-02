<?php
$param = $this->parseFilterParams();
$id = "";
if (empty($target)) {
    $target = "menu";
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
$detail_page = "";
if (isset($_GET["detail_page"])) {
    $detail_page = $_GET["detail_page"];
}

$page = $_GET["page"];
if (!isset($_GET["page"])) {
    $page = 1;
}

$category = $this->getAction()->id;
$numPages = ceil(count($items) / $this->numItemsInPage);
if ($numPages < 5) {
    for ($x = 1; $x < $numPages + 1; $x++) {
        drawButton($x, $page, $category, $id, $param, $target, $detail_page);
    }
} else {
    echo "<a href=\"?r=site/$category&page=1&category={$_GET['category']}&id=$id$param&detail_page=$detail_page#$target\" class=\"page\">&laquo;</a>";
    for ($x = $page - 2; $x <= $page + 2; $x++) {
        if ($x >= 1 && $x <= $numPages) {
            drawButton($x, $page, $category, $id, $param, $target, $detail_page);
        }
    }
    echo "<a href=\"?r=site/$category&page=$numPages&category={$_GET['category']}&id=$id$param&detail_page=$detail_page#$target\" class=\"page\">&raquo;</a>";
}

function drawButton($x, $page, $category, $id, $param, $target, $detail_page)
{
    $item_id = $_GET["id"];
    if (!empty($detail_page)) {
        if ($x == $detail_page) {
            echo "<div title=\"Текущая страница\" class=\"cur-page\">$x</div>";
        } else {
            echo "<a href=\"?r=site/$category&category={$_GET['category']}&page=$page&id=$id$param&detail_page=$x#$target\" class=\"page\">$x</a>";
        }
    }else{
        if ($x == $page) {
            echo "<div title=\"Текущая страница\" class=\"cur-page\">$x</div>";
        } else {
            echo "<a href=\"?r=site/$category&category={$_GET['category']}&page=$x&id=$id$param#$target\" class=\"page\">$x</a>";
        }
    }
}
?>