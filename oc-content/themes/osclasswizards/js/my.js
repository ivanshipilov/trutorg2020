function js_showOrHideChkbox($id)
{
    var chekbox = document.getElementById('chk'+$id+'');
    var elem = document.getElementById('el'+$id+'');
    $('input#'+chekbox.id).on('ifChecked', function(event){$('#'+elem.id).slideDown(300);});
    $('input#'+chekbox.id).on('ifUnchecked', function(event){$('#'+elem.id).slideUp(300);});
}

function js_showOrHideDiv($id) // появление информации в предложениях
{
    var chek = document.getElementById('chk'+$id+'');
    var elem = document.getElementById('el'+$id+'');
    $('#chk'+$id).on("click", function(event){$('#'+elem.id).slideDown(300); $('#chk'+$id).slideUp(0)});
    //$('#chk'+$id).on("click", function(event){$('#'+elem.id).slideUp(300);});
}

function js_showZakazchikField($id) 
{
    var chek = document.getElementById('chk1');
    var unchek = document.getElementById('chk2');
    var elem = document.getElementById('el1');
    $('#chk1').on("click", function(event)
    {
        //$('#el3').fadeOut(300);
        $('#el2').fadeOut(300,function()
    {
        $('#'+elem.id).fadeIn(300);
        chek.style.background = "radial-gradient(#1DC5E5, #3CCEE5)";
        chek.style.color = "#F1E8E1";
        chek.style.textShadow = "1px 1px 2px black";
        chek.style.borderColor = "#23A0C4";
        unchek.style.background = "radial-gradient(#0eaae5, #0d88b6)";
        unchek.style.color = "#f8fbfc";
        unchek.style.textShadow = "none";
        unchek.style.borderColor = "#0c678d"

    })
    });

}
function js_showIspolnitelField($id) 
{
    var chek = document.getElementById('chk2');
    var unchek = document.getElementById('chk1');
    var elem = document.getElementById('el2');
    $('#chk2').on("click", function(event)
    {
        $('#el1').fadeOut(300,function()
        {
            $('#el2').fadeIn(300);
            //$('#el3').fadeIn(300);
            chek.style.background = "radial-gradient(#1DC5E5, #3CCEE5)";
            chek.style.color = "#F1E8E1";
            chek.style.textShadow = "1px 1px 2px black";
            chek.style.borderColor = "#23A0C4";
            unchek.style.background = "radial-gradient(#0eaae5, #0d88b6)";
            unchek.style.color = "#f8fbfc";
            unchek.style.textShadow = "none";
            unchek.style.borderColor = "#0c678d"
        })
    });

}

$(document).ready(function(){
    $(".main_button").on("click","a", function (event) {
        //отменяем стандартную обработку нажатия по ссылке
        event.preventDefault();
        //забираем идентификатор бока с атрибута href
        var id  = $(this).attr('href'),
        //узнаем высоту от начала страницы до блока на который ссылается якорь
            top = $(id).offset().top;
        //анимируем переход на расстояние - top за 1500 мс
        $("body").delay(100).animate({scrollTop: top }, 500);
    });
});

$(document).ready(function(){
    $("#menu").on("click","a", function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $("body").delay(100).animate({scrollTop: top -200}, 500);
    });
});

function slideMove(obj) {
    event.preventDefault();
    var id  = $(obj).attr('href'),
        top = $(id).offset().top;
    $("body").delay(100).animate({scrollTop: top -200}, 500);
}

$(document).ready(function(){
    $("#menu1").on("click","a", function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $("body").delay(100).animate({scrollTop: top -200}, 500);
    });
});

