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

    class RatingForm extends Form
    {

        static public function js_validation($admin = false)
        {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    // Code for form validation
                    $("form[name=rating_form]").validate({
                        rules: {
                            comment: {
                                required: true,
                                minlength: 3,
                                maxlength: 500
                            }
                        },
                        messages: {
                            comment: {
                                required: "Для оценки отзыв обязателен",
                                minlength: "Отзыв слишком короткий",
                                maxlength: "Воу воу, краткость - сестра таланта"
                            }
                        },
                        errorElement : 'div',
                        errorLabelContainer: '.errorTxt',
                        
                        
                        submitHandler: function(form) {

                            var $executor = document.getElementById('executor').value;
                            var $idexecutor = document.getElementById('idexecutor').value;
                            var $r_of_user = document.getElementById('r_of_user').value;
                            var $r_user_name = document.getElementById('r_user_name').value;
                            var $r_pub_date = document.getElementById('r_pub_date').value;
                            var $rComment = document.getElementById('rComment').value;
                            var $rScore = document.getElementsByName('score')[1].value;
                            $.ajax
                            ({
                                type: "POST",
                                url: '<?php echo osc_base_url(true); ?>?page=ajax&action=rating',
                                data: {
                                    "score": $rScore,
                                    "executor": $executor,
                                    "idexecutor": $idexecutor,
                                    "r_of_user": $r_of_user,
                                    "r_user_name": $r_user_name,
                                    "rComment": document.getElementById('rComment').value
                                },
                                response: 'text',
                                success: function (data) {
                                    $("#result").html(data);
                                    $("#button").html('Оценка отправлена');
                                    
                                }

                            })

                        }
                    });
                });
            </script>
            <?php
        }
        
    }?>