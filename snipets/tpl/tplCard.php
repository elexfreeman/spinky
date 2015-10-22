<?php
$card=$this->GetCard();

if((count($card))+0>0)
{
    ?>

    <div class="total">Мой заказ: <?php echo $this->GetCardTotalPrice(); ?>&nbsp;₽</div>
    <a class="w-hidden-main w-hidden-medium w-hidden-small vkorzinumobile" href="#">Перейти в корзину</a>

    <div class="card_products card_form_do_hide">
        <?php
        foreach($card as $product)
        {
            ?>
            <div class="w-hidden-tiny w-clearfix rightitem">
                <div class="price"><?php echo $product->TV['Price']; ?>&nbsp;₽</div>
                <h4 class="rightbludo"><a class="rightitem-a" href="#product_<?php echo $product->id; ?>"><?php echo $product->title; ?></a> × <?php echo $product->CardCount; ?> =&nbsp;<?php echo $product->CardCount*$product->TV['Price']; ?>&nbsp;₽</h4>
                <div class="delete click" onclick="DeleteFromCard(<?php echo $product->id; ?>)">×</div>
            </div>
            <?php
        }
        ?>
    </div>



    <span class="w-hidden-tiny order click card_form_do_hide" onclick="PayWhenDelivery()">Оплатить при доставке</span>
    <a class="w-hidden-tiny payonline card_form_do_hide" href="#">Или оплатить онлайн сейчас</a>

    <div class="card_form " style="display: none;">
        <div class="card_form_close click" onclick="card_form_close();">X</div>
        <p>Напишите, пожалуйста, как вас зовут:<br>
        <span class="wpcf7-form-control-wrap name">
            <input type="text" name="user_name" value="" size="40" class="wpcf7-form-contro" aria-required="true" aria-invalid="false">
        </span>
        </p>

        <p>Ваш телефон:<br>
        <span class="wpcf7-form-control-wrap name">
            <input type="text" name="user_phone" value="" size="40" class="wpcf7-form-contro" aria-required="true" aria-invalid="false">
        </span>
        </p>

        <p>Ваша электронная почта:<br>
        <span class="wpcf7-form-control-wrap name">
            <input type="text" name="user_email" value="" size="40" class="wpcf7-form-contro" aria-required="true" aria-invalid="false">
        </span>
        </p>

        <p>Куда доставить?<br>
        <span class="wpcf7-form-control-wrap name">
            <input type="text" name="user_delivery_address" value="" size="40" class="wpcf7-form-contro" aria-required="true" aria-invalid="false">
        </span>
        </p>
        <span class="w-hidden-tiny order click" onclick="PayWhenDeliveryDone()">Отправить</span>
    </div>
<?php
}
//print_r($card);
?>
