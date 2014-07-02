<?php 
$page = $_GET['page'];
if (empty($page)) {
    $page = 1;
}
?>
<a href="/?r=site/detailed&detail_page=1&id=<?php echo $item->id.$this->parseFilterParams()."&category=$category&page=$page"?>#menu">
    <div class="item_img" style="background-image: <?php echo "url(/images/ItemsSmall/".$item->id.".jpg"?>)" title="<?php echo $item->name?>"></div>
    <div class="item_name"><?php echo $item->name ?></div>
    <div class="item_price"><?php echo $item->price. " грн." ?></div>
</a>
