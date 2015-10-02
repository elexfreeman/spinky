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


$(function() {
    GetConstructor();
    GetCard();
    GetMainPage();
    GetLeftMenu();
});