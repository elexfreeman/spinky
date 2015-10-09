<?php
$card=$this->GetCard();
//print_r($card);
?>

<div class="total">Мой заказ: <?php echo $this->GetTotalPrice(); ?>&nbsp;₽</div>
<a class="w-hidden-main w-hidden-medium w-hidden-small vkorzinumobile" href="#">Перейти в корзину</a>

<?php
foreach($card as $product)
{
    ?>
    <div class="w-hidden-tiny w-clearfix rightitem">
        <div class="price"><?php echo $product->TV['Price']; ?>&nbsp;₽</div>
        <h4 class="rightbludo"><?php echo $product->title; ?> × <?php echo $product->CardCount; ?> =&nbsp;<?php echo $product->CardCount*$product->TV['Price']; ?>&nbsp;₽</h4>
        <div class="delete">×</div>
    </div>
    <?php
}
?>

<div class="w-hidden-tiny w-clearfix rightitem">
    <div class="price">110 ₽</div>
    <h4 class="rightbludo">СУП рамен С КУРИЦЕЙ</h4>
    <div class="delete">×</div>
</div><a class="w-hidden-tiny order" href="#">Оплатить при доставке</a>
<a class="w-hidden-tiny payonline" href="#">Или оплатить онлайн сейчас</a>