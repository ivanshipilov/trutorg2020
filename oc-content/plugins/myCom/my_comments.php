<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/**
 * Created by PhpStorm.
 * User: Пользователь
 * Date: 24.06.2016
 * Time: 9:50
 */
$path = dirname(dirname(dirname(__DIR__)));
$path = osc_base_path();
include_once "$path./oc-includes/osclass/model/myCom.php";
$myComNI = myCom::newInstance();

?>

<?php MyComForm::js_validation(osc_comment_id());  ?>


<div class="myCom_form">
    <?php // include_once "$path/oc-content/plugins/myCom/show_comments.php";?>
    <div id="addcoment<?php echo osc_comment_id()?>" class="addcoment" >
            <form name="myCom_form" id="myCom_form<?php echo osc_comment_id()?>">
                <fieldset>

            <input hidden id="item_id<?php echo osc_comment_id()?>" value="<?php echo osc_item_id(); ?>">
            <input hidden id="parent_com_id<?php echo osc_comment_id()?>" value="<?php echo osc_comment_id(); ?>">
            <input hidden id="myCom_time<?php echo osc_comment_id()?>" value="<?php echo time(); ?>">

                   <?php include "$path/oc-content/plugins/myCom/show_comments.php"; ?>
       <div class="myComSend" id="myComSend<?php echo osc_comment_id()?>" style="display: none">
        <input id="myCom_name<?php echo osc_comment_id()?>" <?php if (osc_logged_user_email() !== "") {echo 'hidden';}?> type="text" name="myCom_name" value="<?php if (osc_logged_user_name() !== "") {echo osc_logged_user_name();} else {echo "Имя (Обязательно)";} ?>" maxlength="60" onfocus="clearText(this)" onblur="clearText(this)"/>
        <input id="myCom_email<?php echo osc_comment_id()?>" <?php if (osc_logged_user_email() !== "") {echo 'hidden';}?>  type="text" name="myCom_email" value="<?php if (osc_logged_user_email() !== "") {echo osc_logged_user_email();} else {echo "Почта (Обязательно, не публикуется)";} ?>" maxlength="60" onfocus="clearText(this)" onblur="clearText(this)"/>
        <textarea id="myCom_text<?php echo osc_comment_id()?>" name="myCom_text"  onkeydown="sendCommentByKey(<?php echo osc_comment_id()?>)"></textarea>

                    <div style="margin-top: 10px">
                        <button id="button<?php echo osc_comment_id()?>" type="submit" class="btn btn-success">
                            Оставить коммент
                        </button>
                    </div>
                    <div  class="errorMyCom" id="errorMyCom<?php echo osc_comment_id()?>"></div>
       </div>
                   <div class="a_for_comment">
                    <a id="trigger<?php echo osc_comment_id()?>" onClick="js_toComment('<?php echo osc_comment_id()?>')" >Комменировать</a>
                   </div> 
                </fieldset>
            </form>
    </div>
</div>


       