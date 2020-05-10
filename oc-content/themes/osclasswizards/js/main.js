//function invokeScript(){var e=$("#plugin-hook select");"undefined"!=typeof e.html()&&e.each(function(){$(this).next().is("a")||selectUi($(this))});var i=$("");$("input").on("ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed",function(){i.prepend("")}).iCheck({checkboxClass:"square",radioClass:"circle",increaseArea:"20%"})}$(document).ready(function(){$(".toggle").click(function(){return $(".links").slideToggle(400),!1}),$(".language span").click(function(){return $(".language ul").slideToggle(400),!1}),$("#show_filters").click(function(){return $("#filters_shown").slideToggle(400),!1}),invokeScript(),$("#mask_as_form select").on("change",function(){$("#mask_as_form").submit()}),$(".item-post, #plugin-hook").on("mouseover hover click",function(){invokeScript()}),$("#sCountry").on("change",function(){var e=$("#sRegionSelect").text(),i=$("#sCitySelect").text();$("#sRegion").next().children(".select-box-label").text(e),$("#sCity").next().children(".select-box-label").text(i);var t=$(this).val(),s=osclasswizards.base_url+"?page=ajax&action=regions&countryId="+t,o='<option value="" id="sRegionSelect">'+e+"</option>";""!=t&&$.ajax({type:"POST",url:s,dataType:"json",success:function(e){var i=e.length;if(i>0){for(key in e)o+='<option value="'+e[key].pk_i_id+'">'+e[key].s_name+"</option>";$("#sRegion").html(o)}}})}),$("#sRegion").on("change",function(){var e=$("#sCitySelect").text();$("#sCity").next().children(".select-box-label").text(e);var i=$(this).val(),t=osclasswizards.base_url+"?page=ajax&action=cities&regionId="+i,s='<option value="" id="sCitySelect">'+e+"</option>";""!=i&&$.ajax({type:"POST",url:t,dataType:"json",success:function(e){var i=e.length;if(i>0){for(key in e)s+='<option value="'+e[key].s_name+'">'+e[key].s_name+"</option>";$("#sCity").empty().html(s)}}})}),_rtl="1"==osclasswizards.rtl_view?!0:!1,$(".premium_slider").slick({dots:!1,infinite:!0,speed:300,slidesToShow:4,slidesToScroll:1,autoplay:!0,autoplaySpeed:3e3,rtl:_rtl,responsive:[{breakpoint:1024,settings:{slidesToShow:3}},{breakpoint:600,settings:{slidesToShow:2}},{breakpoint:480,settings:{slidesToShow:1}}]}),$(".premium_slider_grid").slick({dots:!1,infinite:!0,speed:300,slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:3e3,rtl:_rtl,responsive:[{breakpoint:1024,settings:{slidesToShow:3}},{breakpoint:600,settings:{slidesToShow:2}},{breakpoint:480,settings:{slidesToShow:1}}]})});


//для украшения чекбоксов
$(document).ready(function(){
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-aero',
        radioClass: 'iradio_square-aero',
        increaseArea: '20%' // не обязательно
    });
});


//для функции маски для инпутов
    jQuery(function($) {

        $.mask.definitions['~']='[+-]';

        $('#date').mask('99/99/9999');

        $("[name *= hone]:text").mask('+9(999) 999-99-99');  // маска для телефонов

        $('#phoneext').mask("(999) 999-9999? x99999");

        $("#tin").mask("99-9999999");

        $("#ssn").mask("999-99-9999");

        $("#product").mask("a*-999-a999");

        $("#eyescript").mask("~9.99 ~9.99 999");

    });




