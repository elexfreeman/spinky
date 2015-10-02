/*Вставляет конструктор блюд в центр*/
function GetConstructor()
{
    $.get(
        "/index/konstruktor.html",
        {
            //log1:1,

        },
        function (data)
        {
           $(".constructor").html(data);
        },"html"
    ); //$.get  END
}

function GetLeftMenu()
{
    $.get(
        "/index/leftmenu.html",
        {
            //log1:1,

        },
        function (data)
        {
            $(".LeftMenu").html(data);
        },"html"
    ); //$.get  END
}

function GetMainPage()
{
    $.get(
        "/index/mainpage.html",
        {
            //log1:1,

        },
        function (data)
        {
            $(".MainPage").html(data);
        },"html"
    ); //$.get  END
}

function GetCard()
{
    $.get(
        "/index/card.html",
        {
            //log1:1,

        },
        function (data)
        {
            $(".card").html(data);
        },"html"
    ); //$.get  END
}


$(function() {
    GetConstructor();
    GetCard();
    GetMainPage();
    GetLeftMenu();
});