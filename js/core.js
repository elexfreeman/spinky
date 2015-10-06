    function ShowPage(link,targert)
{
    $.get(
        link,
        {
            //log1:1,

        },
        function (data)
        {
            $("."+targert).html(data);
        },"html"
    ); //$.get  END
}


/*Вставляет конструктор блюд в центр*/
function GetConstructor()
{
    ShowPage("/index/konstruktor.html",'constructor');
}

function GetLeftMenu()
{
    ShowPage("/index/leftmenu.html",'LeftMenu');
}

function GetMainPage()
{
    ShowPage("/index/mainpage.html",'MainPage');
}

function GetCard()
{
    ShowPage("/index/card.html",'card');
}



    //добавление в корзину
    function AddToCard(product_id, product_count, product_price) {
        console.info("AddToCard=" + product_id);
        $.get(
            "ajax.html",
            {
                //log1:1,
                action: "AddToCard",
                product_id: product_id,
                product_count: product_count,
                product_price: product_price
            },
            function (data) {
                console.info(data);
                //меняла чекнуто не екнуто
                if (data.status == "1") {
                    $(".product_content_buy").css("cursor", "no-drop").attr("disabled", "disabled");
                }
                else {
                    $(".product_" + product_id).css("background-position", "");
                }

                if (parseInt(data.count) > 0) {
                    var tmp = "<a href='/cart/'><img src='/assets/bonsan/tpl/img/cart.png' alt='Корзина заказов'/><p><span>В вашей корзине:</span>";
                    tmp = tmp + "<br>" + String(data.count) + " товаров на сумму";
                    tmp = tmp + "<br>" + String(data.summa) + " руб.</p></a>";
                    $(".top2_cart").html(tmp);
                   // $('.modal').modal('show');
                    /*setTimeout(function () {
                     $('.modalThx').modal('hide');
                     }, 5000);*/
                }
                /*else {
                 $(".top2_cart").html('')
                 }*/

            }, "json"
        ); //$.get  END

    }


    $(function() {
    GetConstructor();
    GetCard();
    GetMainPage();
    GetLeftMenu();
});