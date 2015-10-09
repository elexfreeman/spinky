<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 29.09.15
 * Time: 6:40
 */

$shipKey='ad441cf7449bc9af3977e6b0c2a6806e3655247c';

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
        $product->alias = $row['alias'];
        //теперь дополнительные поля
        // - 1 - если это подарки, то тут нету дополнительных цен
        $tv = GetContentTV($page_id);
        $product->TV = $tv;

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


function GetTV_Id_ByName($TV_name)
{
    global $modx;
    global $table_prefix;

    $TV_id=0;
    $sql="select * from ".$table_prefix."site_tmplvars where name='".$TV_name."'";

    echo $sql;
    foreach ($modx->query($sql) as $row_tv) {
        $TV_id = $row_tv['id'];
    }

    return $TV_id;
}

function IncertPageTV($page_id,$tv_name,$tv_value)
{
    global $modx;
    global $table_prefix;

    $tv_id=GetTV_Id_ByName($tv_name);


    //modx_site_tmplvar_templates - содежит связь между полями и шаблонами
    //modx_site_tmplvar_contentvalues - содежит значения полей в странице
    //modx_site_tmplvars - поля
    //modx_site_content - страницы

    $sql="select * from " . $table_prefix . "site_tmplvar_contentvalues where (contentid='".$page_id."')and(tmplvarid=".$tv_id.") ";
    $c_tv_id=0;
    foreach ($modx->query($sql) as $row_c_tv) {
        $c_tv_id = $row_c_tv['id'];
    }

    if ($c_tv_id == 0) {
        $sql_modx_vars = "INSERT INTO " . $table_prefix . "site_tmplvar_contentvalues
(tmplvarid,contentid,value) VALUES ('" . $tv_id . "','".$page_id."','".$tv_value."');";
        echo $sql_modx_vars . "<br>";
        $modx->query($sql_modx_vars);
    } else {
        $sql_modx_vars = "update " . $table_prefix . "site_tmplvar_contentvalues
            set value='".$tv_value."' where  (tmplvarid='" . $tv_id . "')and(contentid='".$page_id."')";
        echo $sql_modx_vars . "<br>";
        $modx->query($sql_modx_vars);
    }
}


/*Вставляет страницу в ModX из объекта*/
function IncertPage($page)
{
    global $modx;
    global $table_prefix;

    /*
   * Описание объекта Ship
   * $page->pagetitle - Название корабля
   * $page->parent=2 - Родитель
   * $page->template=2 - Шаблон
   * $page->url=2 - Шаблон
   * $page->TV['t_title']
   * $page->TV['t_inner_id']
   * $page->TV['t_title_img']
   *
   *$page->alias = encodestring($Ship->TV['t_inner_id'].'_'.$Ship->TV['t_title']);
   *$page->url="ships/" .$Ship->alias . ".html"
   * */

    //импортируем страницы

    //Ищем такую страницу
    $product_id = 0;
    $sql_page = "select * from " . $table_prefix . "site_content where pagetitle='" . mysql_escape_string($page->pagetitle) . "'";
   // echo $sql_page;
    foreach ($modx->query($sql_page) as $row_page) {
        $product_id = $row_page['id'];
    }
    if ($product_id == 0) {
        $sql_product = "INSERT INTO " . $table_prefix . "site_content
(id, type, contentType, pagetitle, longtitle,
description, alias, link_attributes,
published, pub_date, unpub_date, parent,
isfolder, introtext, content, richtext,
template, menuindex, searchable,
cacheable, createdby, createdon,
editedby, editedon, deleted, deletedon,
deletedby, publishedon, publishedby,
menutitle, donthit, privateweb, privatemgr,
content_dispo, hidemenu, class_key, context_key,
content_type, uri, uri_override, hide_children_in_tree,
show_in_tree, properties)
VALUES (NULL, 'document', 'text/html', '" .  $page->pagetitle . "', '', '', '" . $page->alias . "',
'', true, 0, 0, " . $page->parent . ", false, '', '', true, " . $page->template . ", 1, true, true, 1, 1421901846, 0, 0, false, 0, 0, 1421901846, 1, '',
false, false, false, false, false, 'modDocument', 'web', 1,
 '" . $page->url . "', false, false, true, null
 );

;";

        $modx->query($sql_product);
        $page_id = $modx->lastInsertId();
    }
    foreach($page->TV as $TV_name=>$TV_value)
    {
        IncertPageTV($page_id,$TV_name,$TV_value);
    }
  //  print_r($page);

    return $page_id;
}

