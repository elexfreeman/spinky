<div class="topinfo"></div>
<h3 class="priziv">Конструктор блюд:</h3>
<div class="centerleft">
    <h2 class="constructortitle">Выбери основу:</h2>
    <?php $osnova_list=$this->GetConstructorOsnovaList();
    foreach ($osnova_list as $osnova)
    {
        ?>
        <div class="w-clearfix consleftitem">
            <div class="price redprice"><?php echo $osnova->TV['c_price']; ?>&nbsp;₽</div>
            <h4 class="rightbludo click" onclick="ConstructorAddBase(<?php echo $osnova->id; ?>)"><?php echo $osnova->title; ?></h4>
            <div class="delete click" onclick="ConstructoDeleteBase(<?php echo $osnova->id; ?>)">×</div>
        </div>
        <?php
    }
    ?>

</div>

<?php
//Строим конструктор

$base = $_GET['base']+0;
$topping = $_GET['topping'];
$topping=explode('||',$topping);

$base_item='';
if($base>0)
{
    $base_item = GetPageInfo($base);
    $base_item='<div class="consosnova" style="background:url('."'".$base_item->TV['c_img']."'".') no-repeat;"></div>';
}

$topping_item='';
$i=1;
if(($topping[0]+0)>0)
{
    $topping_img=GetPageInfo($topping[0]);
    $topping_item.=' <div class="constopping topping1" style="background:url('."'".$topping_img->TV['c_img']."'".') no-repeat;"></div>';
}
if(($topping[1]+0)>0)
{
    $topping_img=GetPageInfo($topping[1]);
    $topping_item.=' <div class="constopping topping2" style="background:url('."'".$topping_img->TV['c_img']."'".') no-repeat;"></div>';
}

if(($topping[2]+0)>0)
{
    $topping_img=GetPageInfo($topping[2]);
    $topping_item.=' <div class="constopping topping3" style="background:url('."'".$topping_img->TV['c_img']."'".') no-repeat;"></div>';
}

if(($topping[3]+0)>0)
{
    $topping_img=GetPageInfo($topping[3]);
    $topping_item.=' <div class="constopping topping4" style="background:url('."'".$topping_img->TV['c_img']."'".') no-repeat;"></div>';
}


?>
<div class="w-clearfix centecenter">
    <!-- главный контейнер конструктора -->
    <div class="constructorcontainer">
        <!-- этот див показывается когда ещё ничего не выбрано и содержит в качестве фона картинку пустой коробки -->
        <div class="consempty">
            <!-- этот див показывается когда уже что-то выбрано — так как это подложка, задняя стенка коробки -->
            <div class="consfullbackground">
                <!-- конструктор сделан из «основы», «топпинга» и соусов. Это див «основы». Основа может быть только одна. -->
               <?php echo $base_item;?>
               <?php echo $topping_item; ?>
                <!-- этот див показывается когда уже что-то выбрано — и закрывает собой сверху всё её наполнение. Таким образом этот див является стенками коробки -->
                <div class="consmask"></div>

            <!-- закрываем див с задней стенкой коробки -->
            </div>
        <!-- закрываем див пустой коробкой -->
        </div>
    <!-- закрываем главный контейнер -->
    </div>

    <!-- Радуемся! -->

    <h2 class="constructortitle priprav">Приправь<br>соусом:</h2>
    <?php $sous_list=$this->GetConstructorSousList();
    foreach ($sous_list as $sous)
    {
        ?>
        <h4 class="rightbludo sauce"><?php echo $sous->title; ?></h4>

        <?php
    }
    ?>

</div>
<div class="centerright">
    <h2 class="constructortitle">Добавь топпинг:</h2>
    <?php $toping_list=$this->GetConstructorTopingList();
    foreach ($toping_list as $toping)
    {
        ?>
        <div class="w-clearfix consleftitem click">
            <div class="price redprice"><?php echo $toping->TV['c_price']; ?>&nbsp;₽</div>
            <h4 class="rightbludo click" onclick="ConstructorAddTopping(<?php echo $toping->id; ?>);"><?php echo $toping->title; ?></h4>
            <div class="delete click"  onclick="ConstructoDeleteTopping(<?php echo $toping->id; ?>)">×</div>
        </div>
        <?php
    }
    ?>

</div>
<div class="centersep1">
    <div class="centersepwhite"><a class="consdobavit" href="#">Добавить в заказ</a>
    </div>
</div>