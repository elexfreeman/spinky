<?php
$card=$this->GetCard();
//print_r($card);
?>

<div class="total">Мой заказ: <?php echo $this->GetCardTotalPrice(); ?>&nbsp;₽</div>
<a class="w-hidden-main w-hidden-medium w-hidden-small vkorzinumobile" href="#">Перейти в корзину</a>

<div class="card_products">
<?php
foreach($card as $product)
{
    ?>
    <div class="w-hidden-tiny w-clearfix rightitem">
        <div class="price"><?php echo $product->TV['Price']; ?>&nbsp;₽</div>
        <h4 class="rightbludo"><a href="#product_<?php echo $product->id; ?>"><?php echo $product->title; ?></a> × <?php echo $product->CardCount; ?> =&nbsp;<?php echo $product->CardCount*$product->TV['Price']; ?>&nbsp;₽</h4>
        <div class="delete click" onclick="DeleteFromCard(<?php echo $product->id; ?>)">×</div>
    </div>
    <?php
}
?>
</div>


<a class="w-hidden-tiny order" href="#">Оплатить при доставке</a>


<a class="w-hidden-tiny payonline" href="#">Или оплатить онлайн сейчас</a>