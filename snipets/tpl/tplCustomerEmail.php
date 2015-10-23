<?php

$card=$this->GetCard();

$msg='

<meta charset="utf-8">
Заказ №'.$order_id.'
<div style="width:660px; margin:0 auto; font-family: Tahoma,sans-serif; padding:20px; background:#fff;">
	<a style="text-align:center;
	display:inline-block; color: #9fa1a3; text-decoration:none;
	letter-spacing: 3px;" href="/"><img style="width:200px;"
	 src="http://'.$_SERVER['HTTP_HOST']. '/images/logo.svg"><br>
	<span>интернет-магазин</span>
	</a>
	<div style="float:right; margin-top:10px;">
		<a style="color:#ff0f00;" href="http://' .$_SERVER['HTTP_HOST'].' ">Каталог товаров</a>

	</div>

	<p style="clear:both; font-weight:bold; margin-top:20px;">{$order->name|escape},<br>
	Спасибо за оформление заказа №'.$order_id.' на ' .$_SERVER['HTTP_HOST'].'!</p>

	<p>Состав Вашего заказа:</p>

	<table style="width:100%;">
		<tr>
			<th style="text-align:left; padding:5px 0; width:60%;">Товар</th>
			<th style="width:100px; text-align:left;">Кол-во</th>
			<th style="width:100px;text-align:left;">Цена</th>
		</tr>
		 ';
$summa=0;
foreach ($card as $product)
{

    $summa+=$product->TV['Price']*$product->CardCount;
    $msg.='
    <tr>
        <td style="padding:5px 0;">'.$product->title.'</td>
        <td>'.$product->CardCount.'</td>
        <td>'.$product->TV['Price'].'</td>
    </tr>';

}


$msg.='
		<tr>
			<td style="padding:5px 0;" colspan="2"><strong>Стоимость заказа:</strong> </td>
			<td>'.$summa.'</td>
		</tr>
	</table>

    Контактное лицо: '.$obj->TV['z_user_email'].'<br>
    Мобильный телефон: '.$obj->TV['z_user_phone'].'</p>


	<p><strong>С уважением,<br>«' .$_SERVER['HTTP_HOST'].'»</strong></p>

	<hr>

	<p>© 1997-2015 «' .$_SERVER['HTTP_HOST']. '»</p>

	<table style="width:100%;">
		<tr>
			<td style="text-align:left; width:33%;"><a style="color:#ff0d00;"   href="' .$_SERVER['HTTP_HOST']. '/#about">О компании</a></td>
			<td style="text-align:center; width:33%;"><a style="color:#ff0d00;" href="' .$_SERVER['HTTP_HOST']. '/#posts_q">Связаться с нами</a></td>
			<td style="text-align:right; width:33%;"><a style="color:#ff0d00;"  href="' .$_SERVER['HTTP_HOST'].'/#address">Адреса магазинов</a></td>
		</tr>
	</table>


</div>
';