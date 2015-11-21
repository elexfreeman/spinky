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

    /*Удаляет товар из корзины*/
    function CardProductDelete(product_id)
    {
        console.info("AddToCard="+product_id);
        $.get(
            "mainL.php",
            {
                //log1:1,
                action:"CardProductDelete",
                product_id:product_id

            },
            function (data) {
                console.info(data);
                if(data.status=="1")
                {
                    location.reload();
                }

            },"json"
        ); //$.get  END

    }


/*Вставляет конструктор блюд в центр*/
function GetConstructor(base,topping)
{

    $.get(
        "/index/konstruktor.html",
        {
            base:base,
            topping:topping
        },
        function (data)
        {
            $(".constructor").html(data);
        },"html"
    ); //$.get  END
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
    $(".card").fadeIn("slow");
}



    //добавление в корзину
    function AddToCard(product_id, product_count, product_price) {
        console.info("AddToCard=" + product_id);
        $(".card").fadeOut("slow");
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
                GetCard();
                /*else {
                 $(".top2_cart").html('')
                 }*/

            }, "json"
        ); //$.get  END

    }


    //добавление в корзину
    function DeleteFromCard(product_id) {
        $(".card").fadeOut("slow");
        $.get(
            "ajax.html",
            {
                //log1:1,
                action: "DeleteFromCard",
                product_id: product_id

            },
            function (data) {
                console.info(data);
                //меняла чекнуто не екнуто
                GetCard();


            }, "json"
        ); //$.get  END

    }


    $(function() {
    GetConstructor();
    GetCard();
    GetMainPage();
    //GetLeftMenu();
});

    function card_form_close()
    {

        $(".card_form_do_hide").show("slow");

        $(".card_form").hide("slow");
    }

    function PayWhenDelivery()
    {

        $(".card_form_do_hide").hide("slow");

        $(".card_form").show("slow");
    }

    function PayWhenDeliveryDone()
    {
        var user_name = $("input[name='user_name']").val();
        var user_phone = $("input[name='user_phone']").val();
        var user_email = $("input[name='user_email']").val();
        var user_delivery_address = $("input[name='user_delivery_address']").val();
        $.get(
            "ajax.html",
            {
                //log1:1,
                action: "PayWhenDeliveryDone",
                user_name: user_name,
                user_phone: user_phone,
                user_email: user_email,
                user_name: user_name,
                user_delivery_address: user_delivery_address


            },
            function (data) {
                console.info(data);
                $(".card_form_do_hide").hide("slow");
                $(".card_form").hide("slow");
                $(".card_thx").show("slow");
                $(".total").html("");


            }, "json"
        ); //$.get  END
    }


    function ConstructorGetPrice()
    {
        var base =    $(".logo").attr('base');
        var topping = $(".logo").attr('topping');
        $.get(
            "ajax.html",
            {
                //log1:1,
                action: "ConstructorGetPrice",
                base: base,
                topping:topping
            },
            function (data) {
                console.info(data.price);
            }, "json"
        ); //$.get  END
    }

    function ConstructorAddBase(base_id)
    {
        var base =    base_id;
        $(".logo").attr('base',base_id);
        var topping = $(".logo").attr('topping');

        GetConstructor(base,topping);
      /*  $.get(
            "ajax.html",
            {
                //log1:1,
                action: "ConstructorAddBase",
                base_id: base_id,
                base:base
            },
            function (data) {
                GetConstructor(data.base,data.topping);
            }, "json"
        ); //$.get  END*/

    }

    function ConstructorAddTopping(topping_id)
    {
        var base =    $(".logo").attr('base');
        var topping = $(".logo").attr('topping');

        topping = topping.split("||");
        if(topping[0]=='0')
        {
            topping[0]= topping_id;
        }else
        if(topping[1]=='0')
        {
            topping[1]= topping_id;
        }else
        if(topping[2]=='0')
        {
            topping[2]= topping_id;
        }else
        if(topping[3]=='0')
        {
            topping[3]= topping_id;
        }
        topping = topping.join("||");
        $(".logo").attr('topping',topping);
        GetConstructor(base,topping);
    }

    function ConstructoDeleteBase(base_id)
    {
        $(".logo").attr('base',0);
        var topping = $(".logo").attr('topping');
        GetConstructor(0,topping);
    }

    function ConstructoDeleteTopping(topping_id)
    {
        var base =    $(".logo").attr('base');
        var topping = $(".logo").attr('topping');

        topping = topping.split("||");
        if(topping[0]==topping_id)
        {
            topping[0]= 0;
        }else
        if(topping[1]==topping_id)
        {
            topping[1]= 0;
        }else
        if(topping[2]==topping_id)
        {
            topping[2]= 0;
        }else
        if(topping[3]==topping_id)
        {
            topping[3]= 0;
        }
        topping = topping.join("||");
        $(".logo").attr('topping',topping);
        GetConstructor(base,topping);
    }

    function ConstructorAddToCard()
    {
        var base =    $(".logo").attr('base');
        var topping = $(".logo").attr('topping');
        $.get(
             "ajax.html",
             {
                 //log1:1,
                 action: "ConstructorAddToCard",
                 base: base,
                 topping:topping
             },
             function (data) {
                 GetCard();
             }, "json"
         ); //$.get  END
    }

