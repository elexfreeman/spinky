<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 01.10.15
 * Time: 15:05
 */

$root_category_id=3;


function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 'c',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'C',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '_',  'Ы' => 'Y',   'Ъ' => '_',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

function encodestring($str) {
    // переводим в транслит
    $str = rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");


    return $str;
}

function GetPageInfo($page_id)
{
    global $modx;
    global $table_prefix;

    $sql = "select * from " . $table_prefix . "site_content where id=" . $page_id;
    foreach ($modx->query($sql) as $row) {
        $product = new stdClass();
        $product->id = $row['id'];
        $product->introtext = $row['introtext'];
        $product->description = $row['description'];
        $product->title = $row['pagetitle'];
        $product->url = $row['uri'];
        //теперь дополнительные поля
        // - 1 - если это подарки, то тут нету дополнительных цен
        $tv = GetContentTV($page_id);
        $product->tv = $tv;

    }
    return $product;
}

//Инфо по продукту

function GetContentTV($content_id)
{
    global $modx;
    global $table_prefix;
    $sql_tv = "select
                            tv.name,
                            cv.value

                            from " . $table_prefix . "site_tmplvar_contentvalues cv

                            join " . $table_prefix . "site_tmplvars tv
                            on tv.id=cv.tmplvarid

                            where cv.contentid=" . $content_id;

    // echo $sql_tv;
    foreach ($modx->query($sql_tv) as $row_tv) {
        $tv[$row_tv['name']] = $row_tv['value'];
    }
    return $tv;
}


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
            <h3 class="submenuitem"><?php echo $menuItem->title;?></h3>
            <?php
        }
    }

    //список товаров в корзине
    function GetCardList()
    {

    }

    function GetProductsListFromCategory($category_id)
    {
        global $modx;
        global $table_prefix;
    }

    function Run($scriptProperties)
    {
        if(isset($scriptProperties['action']))
        {
            if($scriptProperties['action']=='ShowLeftMenu')
            {
                $this->ShowLeftMenu();
            }
        }
    }
}