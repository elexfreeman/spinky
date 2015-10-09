<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 01.10.15
 * Time: 15:05
 */

$root_category_id=3;
/*todo: Левое меню сайта с прокруткой а не ссылками*/
/*todo: добавление в корзину*/
/*todo: отдельные страницы товаров*/

include "functions.php";


class Spinky
{

    //Список пунктов меню
    function GetMenuList()
    {
        global $modx;
        global $table_prefix;
        $parent=3;
        $sql = "select * from " . $table_prefix . "site_content where parent=".$parent  ;
        $tmp = Array();
        foreach ($modx->query($sql) as $row)
        {
            $tmp[]=GetPageInfo($row['id']);
        }
        return $tmp;

    }


    function ShowLeftMenu()
    {
        $menuItems=$this->GetMenuList();
        foreach($menuItems as $menuItem)
        {
            ?>
            <h3 class="submenuitem click"  onclick="ShowPage('<?php echo $menuItem->url; ?>','CenterBox');"><?php echo $menuItem->title;?></h3>
            <?php
        }
    }

    //список товаров в корзине
    function GetCardList()
    {
        $menuItems=$this->GetMenuList();
        foreach($menuItems as $menuItem)
        {
            ?>
            <h3 class="submenuitem click"  onclick="ShowPage('<?php echo $menuItem->url; ?>','CenterBox');"><?php echo $menuItem->title;?></h3>
        <?php
        }
    }


    /*Выводит центральную часть сайта*/
    function ShowMainMenu()
    {
        $menuItems=$this->GetMenuList();
        foreach($menuItems as $menuItem)
        {
            ?>
            <div class="centersep">
                <h4 class="centermenusubtitle"><?php echo $menuItem->title; ?></h4>
            </div>
            <?php
            $category=$this->GetCategoryProducts($menuItem->id);
            foreach($category as $product)
            {
                ?>
                <div class="centeritem"><img class="centeritemimg" src="/product-images/<?php echo $product->tv['img'];?>">
                    <h5 class="centeritemtitle"><?php echo $product->title;?></h5>
                    <div class="price centeritemprice"><?php echo $product->tv['Price'];?>&nbsp;₽</div>
                    <div class="dobavit click" onclick="AddToCard(<?php echo $product->id;?>,1)">Добавить в заказ</div>
                </div>

                <?php
            }
        }
    }

    /*Показывает товары в одной категории*/
    function ShowCategorySingle($category_id)
    {
        $category=$this->GetCategoryProducts($category_id);
        foreach($category as $product)
        {
            ?>
            <div class="centeritem">
                <img class="centeritemimg" src="/product-images/<?php echo $product->tv['img'];?>">
                <h5 class="centeritemtitle"><?php echo $product->title;?></h5>
                <div class="price centeritemprice"><?php echo $product->tv['Price'];?>&nbsp;₽</div>
                <div class="dobavit click"  onclick="AddToCard(<?php echo $product->id;?>,1,<?php echo $product->tv['Price'];?>)">Добавить в заказ</div>
            </div>

        <?php
        }
    }

    //влзвращает массив страниц категории
    function GetCategoryProducts($category_id)
    {
        global $modx;
        global $table_prefix;
        $parent=$category_id;
        $sql = "select * from " . $table_prefix . "site_content where parent=".$parent  ;
        $tmp = Array();
        foreach ($modx->query($sql) as $row)
        {
            $tmp[]=GetPageInfo($row['id']);
        }
        return $tmp;
    }



//Возвращает количество товаров в корзине
    function GetCardCountProduct()
    {
        $cc = 0;
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, 3) == 'pro') {
                $cc = $cc + $value;
            };
            //echo $key." ".$value." ".substr($key,0,3);


        }
        return $cc;
    }

    function GetTotalPrice()
    {
        $price = 0;
        $cc=0;
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, 3) == 'pro') $cc = $cc + $value;
            $dd = explode(' ', $value);
            $price += $dd[0] * $dd[1];
        }
        return $price;
    }


    //Для обработка ajax-запросов
    function Ajax()
    {
        if(isset($_GET['action']))
        {
            if($_GET['action']=='AddToCard')
            {
                $this->AddToCard();
            }
        }
    }


    function AddToCard()
    {

        $product_price = mysql_escape_string($_GET['product_price']);
        $product_count = mysql_escape_string($_GET['product_count']);
        if(!isset($_SESSION['product_'.$_GET['product_id']])){
            $_SESSION['product_' . $_GET['product_id']] = $product_count.' '.$product_price;
        } else {
            $dd = explode(" ",$_SESSION['product_' . $_GET['product_id']]);
            $dd[0] = $dd[0] + $product_count;
            $_SESSION['product_' . $_GET['product_id']] = $dd[0]." ".$dd[1];
        }


        //посчитать сумму и рублей
        //вычисляем сумму
        //----------------------------------------------------------
        //----------------------------------------------------------
        $summa = 0;

        $summa = $this->GetTotalPrice();
        //----------------------------------------------------------
        //----------------------------------------------------------
        echo json_encode(array("status" => "1", "count" => $this->GetCardCountProduct(), "summa" => $summa)); //добавили
        //  }
    }

    /*Возвращает массив объектов корзины*/
    function GetCard()
    {

        $card=array();
        foreach ($_SESSION as $key => $value)
        {
            if (substr($key, 0, 3) == 'pro')
            {
                echo $key . " " . $value . "<br>";

                $tmp=explode('_',$key);
                $product_id=$tmp[1];
                $tmp=GetPageInfo($product_id);
                $tmp->CardCount=$value;
                $card[]=$tmp;

            };
        }
        return $card;
    }

    /*Отображает корзину*/
    function tplCard()
    {
        include_once "tpl/tplCard.php";
    }

    function Run($scriptProperties)
    {
        if(isset($scriptProperties['action']))
        {
            if($scriptProperties['action']=='ShowLeftMenu')
            {
                $this->ShowLeftMenu();
            }//ShowMainMenu
            elseif($scriptProperties['action']=='ShowMainMenu')
            {
                $this->ShowMainMenu();
            }//
            elseif($scriptProperties['action']=='tplCard')
            {
                $this->tplCard();
            }//
        }
    }
}