function centerBox($id) {
    var boxWidth = 400;
    /* определяем нужные данные */
    var winWidth = $(window).width();
    var winHeight = $(window).height();
    var docHeight = $(document).height();
    var scrollPos = $(window).scrollTop();

    /* Вычисляем позицию */

    var disWidth = (winWidth - boxWidth) / 2;
    var disHeight = (winHeight - winHeight/2)/2;

    /* Добавляем стили к блокам */
    $('#el'+$id).css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px', 'maxHeight' : winHeight/2+'px'});
    $('#blackout').css({'width' : winWidth+'px', 'height' : docHeight+'px'});

    return false;
}

function js_showOrHideDiv($id) // появление pop-up окна "подробно"
{
    var infoBlock = $('#el'+$id);
    js_blackoutShow();
    $('#blackout').fadeIn(100);
    $(window).resize(centerBox);
    $(window).scroll(centerBox);
    centerBox($id);

    $(infoBlock).fadeIn(300,function()
    {
        $('html,body').css('overflow', 'hidden');
        $('#blackout').click(function () {

            $(infoBlock).fadeOut(300);
            var scrollPos = $(window).scrollTop();
            /* Скрыть окно, когда кликаем вне его области */
            //$('.contact_information').hide();
            $('#blackout').hide();
            $("html,body").css("overflow", "auto");
            $('html').scrollTop(scrollPos);
        });

        $('.close').click(function () {
            $(infoBlock).fadeOut(300);
            var scrollPos = $(window).scrollTop();
            /* Скрываем тень и окно, когда пользователь кликнул по X */
            //$('.contact_information').hide();
            $('#blackout').hide();
            $("html,body").css("overflow", "auto");
            $('html').scrollTop(scrollPos);
        });

        $(window).keydown(function (e) {
            if (e.which == 27) {
                $(infoBlock).fadeOut(300);
                var scrollPos = $(window).scrollTop();
                /* Скрываем тень и окно, когда пользователь кликнул по X */
                //$('.contact_information').hide();
                $('#blackout').hide();
                $("html,body").css("overflow", "auto");
                $('html').scrollTop(scrollPos);
            }
        });

    })
}
function js_blackoutShow() {
    if ($("div").is($('#blackout'))==false) {$('body').append('<div id="blackout"></div>')}
}

function js_showOrHideMyCom($offerId) // выезд формы для ввода комента
{
    var sendForm = $('#myComSend'+$offerId+'');
    var textArea = $('#myCom_text'+$offerId);
    var AllForCom = $('#All_for_com'+$offerId);
    var infoBlock = $('#el'+$offerId);
    var pointOfDestination = AllForCom.height();

    infoBlock.delay(0).animate({scrollTop: pointOfDestination }, 300);
    if(sendForm.css('display') == 'none') {sendForm.slideDown(300)}
    textArea.focus();

    if ($("#comForCom"+$offerId).children("ul").length !== 0)  {sendForm.css({"border-top" : "none", "-webkit-border-radius" : "0px 0px 5px 5px", "-moz-border-radius" : "0px 0px 5px 5px", "border-radius" : "0px 0px 5px 5px"})}
}

function clearText(field)
{
    if(field.defaultValue == field.value)field.value = '';else if(field.value == '')field.value = field.defaultValue;
}

function js_toComment($offerId) // отправка нового коммента
{
    var sendForm = $('#myComSend'+$offerId+'');
    var textArea = $('#myCom_text'+$offerId);
    var AllForCom = $('#All_for_com'+$offerId);
    var infoBlock = $('#el'+$offerId);
    var pointOfDestination = AllForCom.height();
    js_showOrHideMyCom($offerId);
    textArea.val('');
    $('#answer_for_'+$offerId).val(0);

}

function js_answer($offerId)  // ф-я ответа на коммент
{
    var $id=event.target.id.substring(7);
    js_showOrHideMyCom($offerId);
    var $textArea = document.getElementById('myCom_text'+$offerId);
    var $whome = document.getElementById('author_'+$id);
    $('#myCom_text'+$offerId).val($("#author_"+$id).html()+', ');
    $('#answer_for_'+$offerId).val($id);

}

function sendCommentByKey($offerId) {
    if (event.keyCode==13)
    {
        event.preventDefault();
        $('#button'+$offerId).click();
        js_toComment($offerId);
    }
}

function js_echo_comments($comments,$offerId,$userLoggedEmail) {
    if ($comments==0) {$('#All_for_com'+$offerId).hide() } else
    {

    $.each($comments, function(index, value)
    {
        if (value['author_email'] == $userLoggedEmail) {var action = '<div><a class="myComDelete" rel="nofollow" onclick="js_delMyCom('+value.com_id+')" title="Удалить Ваш комментарий">Удалить</a></div>'}
        else {
            if (value['answer_for']==0){var action = '<div><a id="answer_'+value['com_id']+'" class="myComAnswer" onclick="js_answer('+$offerId+')">Ответить</a></div>'}
            else {{var action = ''}}}
        if (index==0) {var firstClassCom = 'class="firstClassCom"'}
        

        if (value['answer_for']==0)
        {
            $('#comForCom'+$offerId).append
            ('<ul id="comForOfferID'+value['com_id']+ '"' +firstClassCom + '>' +
                '<li><a id="author_'+value['com_id']+'">'+value.author_name+' </a>('+value.pub_date+'):</li>' +
                '<li id="myComText'+value['com_id']+'">'+value.com_text+'</li>' + action +
                '<div style="clear:both;"></div>' +
                '</ul>');
        }
        else
        {
            $('#comForOfferID'+value['answer_for']).append
            ('<ul id="comForOfferID'+value['com_id']+'" style="margin-left: 10%">' +
                '<li><a id="author_'+value['com_id']+'">'+value.author_name+' </a>('+value.pub_date+'):</li>' +
                '<li id="myComText'+value['com_id']+'">'+value.com_text+'</li>' + action +
                '<div style="clear:both;"></div>'+
                '</ul>');
        }
    });

    }
}


function js_mark_comment(comment,$offerId) {
   $(document).ready(function () {

    var newComment = $('#comForOfferID'+comment['com_id']);
    var infoBlock = $('#el'+$offerId);
    var parent = $('#comForCom'+$offerId);
    var textArea = $('#myCom_text'+$offerId);
    newComment.fadeIn(500);
    newComment.animate({ backgroundColor: "rgba( 200, 255, 219, 0.9 )"}, 500);
    newComment.animate({ backgroundColor: "rgba( 0, 0, 0, 0 )"}, 500);

    a= parent.offset().top;
    b=newComment.offset().top ;
    c=newComment.height();
        $distance = b-a +c/2;
    infoBlock.delay(0).animate({scrollTop: $distance }, 300);
    textArea.val('');
   })
}

function js_delMyCom($idMyCom) {
    $(document).ready(function ()
    {
        $.ajax
        ({
            type: "POST",
            url: '?page=ajax&action=myComDel',
            data: {
                "myCom_Id": $idMyCom
                //"myCom_text": $myCom_text
            },
            response: 'text',
            success: function () {
                $('#comForOfferID'+$idMyCom).remove();
            }
        })
    });
}
