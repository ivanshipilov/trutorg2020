<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23.06.2016
 * Time: 22:17
 */
$comments = ($myComNI -> allComments(osc_comment_id()));
$jsonComments = json_encode($comments);
$offerId = osc_comment_id();
$jsonMail = json_encode(osc_logged_user_email());
 ?>
<div id="All_for_com<?php echo osc_comment_id() ?>">
<h3 style="margin-left: 5%"> Комментарии к предложению:</h3>
      <input hidden id='answer_for_<?php echo osc_comment_id() ?>' value = '0'>
    <div class="comForCom" id="comForCom<?php echo osc_comment_id() ?>">
    <script>js_echo_comments(<?php echo $jsonComments ?>,<?php echo $offerId ?>, <?php echo $jsonMail ?>)</script>
    </div>
</div>
  <?php  ?>

