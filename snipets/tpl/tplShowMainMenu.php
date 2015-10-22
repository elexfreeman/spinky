<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 17-Oct-15
 * Time: 2:39 AM
 */
$menuItems=$this->GetMenuList();
foreach($menuItems as $menuItem)
{
    ?>
    <div class="centersep">
        <h4 class="centermenusubtitle" id="menuItem_<?php echo $menuItem->id; ?>"><?php echo $menuItem->title; ?></h4>
    </div>
    <?php
    $category=$this->GetCategoryProducts($menuItem->id);
    foreach($category as $product)
    {
        ?>
        <div class="centeritem" id="product_<?php echo $product->id; ?>"><img class="centeritemimg" src="/product-images/<?php echo $product->TV['img'];?>">
            <h5 class="centeritemtitle"><?php echo $product->title;?></h5>
            <div class="price centeritemprice"><?php echo $product->TV['Price'];?>&nbsp;₽</div>
            <div class="dobavit click" onclick="AddToCard(<?php echo $product->id;?>,1)">Добавить в заказ</div>
        </div>

        <?php
    }
}