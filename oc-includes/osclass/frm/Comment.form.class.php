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

    class CommentForm extends Form
    {

        static public function primary_input_hidden($comment = null)
        {
            $commentId = null;
            if (isset($comment['pk_i_id'])) {
                $commentId = $comment['pk_i_id'];
            }
            if (Session::newInstance()->_getForm('commentId') != '') {
                $commentId = Session::newInstance()->_getForm('commentId');
            }
            if (!is_null($commentId)) {
                parent::generic_input_hidden("id", $commentId);
            }
        }

        static public function title_input_text($comment = null)
        {
            $commentTitle = '';
            if (isset($comment['s_title'])) {
                $commentTitle = $comment['s_title'];
            }
            if (Session::newInstance()->_getForm('commentTitle') != '') {
                $commentTitle = Session::newInstance()->_getForm('commentTitle');
            }
            parent::generic_input_text("title", $commentTitle, null, false);
        }

        // поменял title на newprice, получилась ф-я для ввода новой цены предложения из расчета -10% от предыдущей минимальной
        static public function New_price_fromMin_input_text($comment = null, $minPrice)
        {
            parent::generic_input_text("Newprice", (Round($minPrice - $minPrice * 0.1)), null, false);
        }

        // добавил сюда функцию из класса itemForm
        static public function New_price_input_text($item = null)
        {
            if ($item == null) {
                $item = osc_item();
            };
            if (Session::newInstance()->_getForm('Newprice') != "") {
                $item['i_Newprice'] = Session::newInstance()->_getForm('Newprice');
            }
            //Здесь предлагается ваша новая цена из расчета старая - 10%
            parent::generic_input_text('Newprice', (isset($item['i_price'])) ? round(osc_prepare_price($item['i_price'] - $item['i_price'] * 0.1)) : null);
        }

        static public function author_input_text($comment = null)
        {
            $commentAuthorName = '';
            if (isset($comment['s_author_name'])) {
                $commentAuthorName = $comment['s_author_name'];
            }
            if (Session::newInstance()->_getForm('commentAuthorName') != '') {
                $commentAuthorName = Session::newInstance()->_getForm('commentAuthorName');
            }
            parent::generic_input_text("authorName", $commentAuthorName, null, false);
        }

        /**
         * @param null $comment
         */
        static public function phone_input_text($comment = null)
        {
            $commentAuthorPhone = '';
            if (isset($comment['s_author_phone'])) {
                $commentAuthorPhone = $comment['s_author_phone'];
            }
            if (Session::newInstance()->_getForm('commentAuthorPhone') != '') {
                $commentAuthorPhone = Session::newInstance()->_getForm('commentAuthorPhone');
            }
            parent::generic_input_text("authorPhone", $commentAuthorPhone, null, false);
        }

        static public function show_phone_checkbox($comment = null) {
            if (isset($comment['s_show_phone'])) {
                $showPhone = $comment['s_show_phone'];
            }
            if( Session::newInstance()->_getForm('showPhone') != 0) {
                $comment['s_show_phone'] = Session::newInstance()->_getForm('showPhone');
            }
            parent::generic_input_checkbox('showPhone', '1', (isset($comment['s_show_phone']) ) ? $comment['s_show_phone'] : false );
            return true;
        }


        static public function email_input_text($comment = null)
        {
            $commentAuthorEmail = '';
            if (isset($comment['s_author_email'])) {
                $commentAuthorEmail = $comment['s_author_email'];
            }
            if (Session::newInstance()->_getForm('commentAuthorEmail') != '') {
                $commentAuthorEmail = Session::newInstance()->_getForm('commentAuthorEmail');
            }
            parent::generic_input_text("authorEmail", $commentAuthorEmail, null, false);
        }

        static public function body_input_textarea($comment = null)
        {
            $commentBody = '';
            if (isset($comment['s_body'])) {
                $commentBody = $comment['s_body'];
            }
            if (Session::newInstance()->_getForm('commentBody') != '') {
                $commentBody = Session::newInstance()->_getForm('commentBody');
            }
            parent::generic_textarea("body", $commentBody);
        }
        

        static public function js_validation($admin = false)
        {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    // Code for form validation
                    $("form[name=comment_form]").validate({
                        rules: {
                            body: {
                                required: false,
                                maxlength: 500
                            },
                            authorEmail: {
                                required: true,
                                email: true
                            },
                            Newprice: {
                                required: true,
                                digits: true,
                                min: 1
                            }
                        },
                        messages: {
                            authorEmail: {
                                required: "<?php _e("Email: this field is required"); ?>.",
                                email: "<?php _e("Invalid email address"); ?>."
                            },
                            body: {
                                minlength: "<?php _e("Comment: this field is required"); ?>.",
                                maxlength: "Воу воу, краткость - сестра таланта"
                            },
                            Newprice: {
                                required: "Введите цену за которую готовы выполнить заказ",
                                digits: "Введите число",
                                min: "Предлагаемая цена не может быть меньше 1 рубля"
                            }
                        },
                        wrapper: "li",
                        <?php if($admin) { ?>
                        errorLabelContainer: "#error_list",
                        invalidHandler: function (form, validator) {
                            $('html,body').animate({scrollTop: $('h1').offset().top}, {duration: 250, easing: 'swing'});
                        },
                        submitHandler: function (form) {
                            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
                            form.submit();
                        }
                        <?php } else { ?>
                        errorLabelContainer: "#comment_error_list",
                        invalidHandler: function (form, validator) {
                            $('html,body').animate({scrollTop: $('#comment_error_list').offset().top}, {
                                duration: 250,
                                easing: 'swing'
                            });
                        },
                        submitHandler: function (form) {
                            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
                            form.submit();
                        }
                        <?php }; ?>
                    });
                });
            </script>
            <?php
        }
        
    }?>