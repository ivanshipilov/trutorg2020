<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
 * Copyright 2014 Osclass
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class MyComForm extends Form
{

    static public function js_validation($id)
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function ()
            {
                // Code for form validation
                $("#myCom_form<?php echo $id?>").validate({
                    rules: {
                        myCom_name: {
                            required: true,
                            minlength: 1,
                            maxlength: 30
                        },
                        myCom_email: {
                            required: true,
                            email: true
                        },
                        myCom_text: {
                            required: true,
                            minlength: 3,
                            maxlength: 500
                        }
                    },
                    messages: {
                        myCom_name: {
                            required: "Введите имя!",
                            minlength: "Имя слишком короткое",
                            maxlength: "Воу воу, краткость - сестра таланта"
                        },
                        myCom_email: {
                            required: "Введите email!",
                            email: "Неверно введен email!"
                        },
                        myCom_text: {
                            required: "Введите комментарий!",
                            minlength: "Комментарий слишком короткий",
                            maxlength: "Воу воу, краткость - сестра таланта"
                        }
                    },
                    errorElement : 'div',
                    errorLabelContainer: '#errorMyCom<?php echo $id?>',


                    submitHandler: function(form) {

                        var $myCom_name<?php echo $id?> = document.getElementById('myCom_name<?php echo $id?>').value;
                        var $item_id<?php echo $id?> = document.getElementById('item_id<?php echo $id?>').value;
                        var $parent_com_id<?php echo $id?> = document.getElementById('parent_com_id<?php echo $id?>').value;
                        var $myCom_email<?php echo $id?> = document.getElementById('myCom_email<?php echo $id?>').value;
                        var $myCom_time<?php echo $id?> = document.getElementById('myCom_time<?php echo $id?>').value;
                        var $myCom_text<?php echo $id?> = document.getElementById('myCom_text<?php echo $id?>').value;
                        var $answer_for_<?php echo $id?> = document.getElementById('answer_for_<?php echo $id?>').value;

                        $.ajax
                        ({
                            type: "POST",
                            url: '<?php echo osc_base_url(true); ?>?page=ajax&action=myCom',
                            data: {
                                "myCom_name": $myCom_name<?php echo $id?>,
                                "item_id": $item_id<?php echo $id?>,
                                "parent_com_id": $parent_com_id<?php echo $id?>,
                                "myCom_email": $myCom_email<?php echo $id?>,
                                "pubDate": $myCom_time<?php echo $id?>,
                                "myCom_text": $myCom_text<?php echo $id?>,
                                "answer_for": $answer_for_<?php echo $id?>
                            },
                            response: 'text',
                            success: function (data) {
                                var comment = JSON.parse(data);
                                var $offerId = <?php echo $id?>;
                                var comForCom = $("#comForCom"+$offerId);
                                if (comForCom.children("ul").length == 0) {var $checkFirstCom = 1}

                                if (comment['answer_for']==0)
                                {
                                    $('#comForCom'+$offerId).append
                                    ('<ul id="comForOfferID'+comment['com_id']+'" style="display: none">' +
                                        '<li><a id="author_'+comment['com_id']+'">'+comment.author_name+' </a>('+comment.pub_date+'):</li>' +
                                        '<li>'+comment.com_text+'</li>' +
                                        '<div><a class="myComDelete" rel="nofollow" onclick="js_delMyCom('+comment.com_id+')" title="Удалить Ваш комментарий">Удалить</a></div>' +
                                        '</div><div style="clear:both;"></div>' +
                                        '</ul>');
                                }
                                else
                                {
                                    $('#comForOfferID'+comment['answer_for']).append
                                    ('<ul id="comForOfferID'+comment['com_id']+'" style="margin-left: 10%;">' +
                                        '<li><a id="author_'+comment['com_id']+'">'+comment.author_name+' </a>('+comment.pub_date+'):</li>' +
                                        '<li>'+comment.com_text+'</li>' +
                                        '<div><a class="myComDelete" rel="nofollow" onclick="js_delMyCom('+comment.com_id+')" title="Удалить Ваш комментарий">Удалить</a></div>' +
                                        '</div><div style="clear:both;"></div>' +
                                        '</ul>');
                                }
                                $('#All_for_com'+$offerId).fadeIn(300);
                                if (comForCom.children("ul").length >0) {$('#myComSend'+$offerId+'').css({"border-top" : "none", "-webkit-border-radius" : "0px 0px 5px 5px", "-moz-border-radius" : "0px 0px 5px 5px", "border-radius" : "0px 0px 5px 5px"})}
                                if ($checkFirstCom == 1) {$('#comForOfferID'+comment['com_id']).css({"border-top" : "none"})}
                                js_mark_comment(comment,$offerId);
                                //$("#button<?php echo $id?>").html('Комент отправлен');

                            }
                        })
                    }
                });
            });
        </script>
        <?php
    }
}?>