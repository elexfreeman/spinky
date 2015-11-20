<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 01.10.15
 * Time: 15:05
 */

$root_category_id=3;

/*todo: отдельные страницы товаров для продвижения*/

include "functions.php";


class Spinky
{

    public $AdminEmail = 'elextraza@gmail.com';

    public $z_parent= 79;
    public $z_template= 6;

    public $constructor_osnova_template= 8;
    public $constructor_osnova_parent= 100;

    public $constructor_sous_template= 10;
    public $constructor_sous_parent= 102;

    public $constructor_toping_template= 9;
    public $constructor_toping_parent= 101;




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
            <a class="submenuitem-a" href="#menuItem_<?php echo $menuItem->id; ?>">
                <h3 class="submenuitem click" ><?php echo $menuItem->title;?></h3>
            </a>
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
    function tplShowMainMenu()
    {
        include_once "tpl/tplShowMainMenu.php";
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
                <div class="dobavit click"  onclick="AddToCard(<?php echo $product->id;?>,1,<?php echo $product->TV['Price'];?>)">Добавить в заказ</div>
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

    function GetCardTotalPrice()
    {
       $price = 0;
       $card=$this->GetCard();
       foreach($card as $product)
       {
           $price+=$product->TV['Price']*$product->CardCount;

       }
        return $price;
    }


    /*Обаботчик нажатия Оплатить при доставке после введения данных пользователем*/
    function PayWhenDeliveryDone()
    {
        $result['status']='done';
        /*одготавливаем письмицо в конверте
        1 - заказчику
        2 - администратору
        */
        //$this->ClearCard();
        $card=$this->GetCard();
        print_r($card);
        $products='';
        $summa=0;
        foreach ($card as $product)
        {
            $products.=$product->id."-".$product->CardCount."||";
            $summa+=$product->TV['Price']*$product->CardCount;
        }

        $user_delivery_address=mysql_escape_string($_GET['user_delivery_address']);
        $user_email=mysql_escape_string($_GET['user_email']);
        $user_name=mysql_escape_string($_GET['user_name']);
        $user_phone=mysql_escape_string($_GET['user_phone']);

        $obj = new stdClass();
        $obj->pagetitle="z_".rand(5, 60)."_".$user_name."-".$user_phone;
        $obj->parent=$this->z_parent;
        $obj->template=$this->z_template;
        $obj->TV['z_user_email']=$user_email;
        $obj->TV['z_user_name']=$user_name;
        $obj->TV['z_user_phone']=$user_phone;
        $obj->TV['z_user_delivery_address']=$user_delivery_address;
        $obj->TV['z_order_product_list']=$products;
        $obj->TV['z_summa']=$summa;

        $obj->alias = encodestring($obj->pagetitle);
        $obj->url="zakazyi/". $obj->alias.".html";
        //echo json_encode($card);
        $order_id=IncertPage($obj);

        /*Получаем тело письма из шаблона*/
        include "tpl/tplCustomerEmail.php";



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
            elseif($_GET['action']=='DeleteFromCard')
            {
                $this->DeleteFromCard();
            }
            elseif($_GET['action']=='PayWhenDeliveryDone')
            {
                $this->PayWhenDeliveryDone();
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

        $summa = $this->GetCardTotalPrice();
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
                //echo $key . " " . $value . "<br>";

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

    function DeleteFromCard()
    {
        if(isset($_SESSION['product_'.$_GET['product_id']]))
        {
            unset($_SESSION['product_'.$_GET['product_id']]);
            echo   json_encode(array("status"=>"1")); //удалили из корзины
        }
        else echo   json_encode(array("status"=>"0")); //хер там нету такого товара
    }

    /*Очищает корзину*/
    function ClearCard()
    {
        foreach($_SESSION as $key=>$value)
        {
            if(substr($key,0,3)=='pro')
            {
                echo $key." ".$value." ".substr($key,0,3);
                unset($_SESSION[$key]);
            }
        }
    }


    /*Выводит конструктор на страницу через ajax*/
    function tplConstructor()
    {
        include_once "tpl/tplConstructor.php";
    }

    /*Получает список объектов с основой для конструктора*/
    function GetConstructorOsnovaList()
    {
        return $this->GetCategoryProducts($this->constructor_osnova_parent);
    }

    /*Получает список объектов с соусов для конструктора*/
    function GetConstructorSousList()
    {
        return $this->GetCategoryProducts($this->constructor_sous_parent);
    }

    /*Получает список объектов с топингов для конструктора*/
    function GetConstructorTopingList()
    {
        return $this->GetCategoryProducts($this->constructor_toping_parent);
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
                $this->tplShowMainMenu();
            }//
            elseif($scriptProperties['action']=='tplCard')
            {
                $this->tplCard();
            }//
            elseif($scriptProperties['action']=='tplConstructor')
            {
                $this->tplConstructor();
            }//
        }
    }
}