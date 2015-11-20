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
            <h4 class="rightbludo"><?php echo $osnova->title; ?></h4>
            <div class="delete">×</div>
        </div>
        <?php
    }
    ?>

</div>
<div class="w-clearfix centecenter">
    <div class="constructorcontainer"> <!-- главный контейнер конструктора -->
        <div class="consempty"> <!-- этот див показывается когда ещё ничего не выбрано и содержит в качестве фона картинку пустой коробки -->
            <div class="consfullbackground"> <!-- этот див показывается когда уже что-то выбрано — так как это подложка, задняя стенка коробки -->
                <div class="consosnova udon"></div> <!-- конструктор сделан из «основы», «топпинга» и соусов. Это див «основы». Основа может быть только одна. -->
                <div class="constopping topping1 svinina"></div> <!-- а это — див «топпинга». У него нет стилей css, потому что он технически существует только для манипуляций в DOM с помощью jQuery. Топпингов может быть не больше четырех. -->
                <div class="constopping topping2 pomidori-cherry"></div> <!-- тоже топпинг -->
                <div class="constopping topping3 govyadina"></div> <!-- ещё один топпинг -->
                <div class="constopping topping4 gribnoy-mix"></div> <!-- топпинг опять -->
                <div class="consmask"></div> <!-- этот див показывается когда уже что-то выбрано — и закрывает собой сверху всё её наполнение. Таким образом этот див является стенками коробки -->
            </div> <!-- закрываем див с задней стенкой коробки -->
        </div> <!-- закрываем див пустой коробкой -->

    </div> <!-- закрываем главный контейнер -->

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
        <div class="w-clearfix consleftitem">
            <div class="price redprice"><?php echo $toping->TV['c_price']; ?>&nbsp;₽</div>
            <h4 class="rightbludo"><?php echo $toping->title; ?></h4>
            <div class="delete">×</div>
        </div>
        <?php
    }
    ?>

</div>
<div class="centersep1">
    <div class="centersepwhite"><a class="consdobavit" href="#">Добавить в заказ</a>
    </div>
</div>