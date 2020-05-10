<?php
/**
 * Created by PhpStorm.
 * User: Пользователь
 * Date: 01.07.2016
 * Time: 11:53
 */
?> 

<div style="display: none" class="contact_information" id="el<?php echo osc_comment_id(); ?>">
    <div class="close">X</div>
    <h4 style="margin-bottom: 3px; margin-top: 10px; font-size: large "><?php echo (float) osc_comment_title(); echo " "; echo  osc_item_currency_symbol();?>
        <span style="float: right; font-size: 80%"> <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id()) == 0) && (((osc_logged_user_id() == osc_user_id())) && (osc_user_id() !== 0) && osc_logged_user_id() !== 0 )) {?>
                <a rel="nofollow" href="<?php echo osc_make_choice_url(); ?>" title="<?php echo osc_esc_html(__('Выбрать автора этого предложения исполнителем Вашей заявки', OSCLASSWIZARDS_THEME_FOLDER)); ?>">
                    <?php _e('Выбрать исполнителем', OSCLASSWIZARDS_THEME_FOLDER); ?>
                </a> <?php  } else if (ItemComment::newInstance() ->check_choice(osc_item_id(),osc_comment_id())==1) echo 'Выбор заказчика! '; if ((ItemComment::newInstance() ->check_choice(osc_item_id(),osc_comment_id())==1) && (((osc_logged_user_id() == osc_user_id())) && (osc_user_id() !== 0) && osc_logged_user_id() !== 0 )) { ?><br><a style="font-size: 80%" rel="nofollow" href="<?php echo osc_cancel_choice_url(); ?>" title="<?php echo osc_esc_html(__('Отказаться от исполнителя', OSCLASSWIZARDS_THEME_FOLDER)); ?>">
                <?php _e('Отказаться от исполнителя', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a> <?php } ?>
    </span>
    </h4>
    <a><?php echo osc_format_date(osc_comment_pub_date()) ?>&nbsp от</a>
    <?php if (osc_comment_user_id()) { ?> <a style="font-weight: bold; font-size: larger; color: #5b7c8f " href="<?php echo osc_user_public_profile_url( osc_comment_user_id() ); ?>" ><i class="fa fa-user"></i><?php echo osc_comment_author_name(); ?></a>
        <a class="ratingOfUser<?php echo osc_comment_id()?>" style="font-size: 6px; margin-left: 3px; color: #f7aa00"></a>
        <?php if (userRaty::newInstance()->count(osc_comment_user_id())==1) { ?>
            <a>(По оценке <?php echo userRaty::newInstance()->count(osc_comment_user_id()) ?> пользователя)</a>
        <?php } if (userRaty::newInstance()->count(osc_comment_user_id())>1) {?>
            <a>(По оценкам <?php echo userRaty::newInstance()->count(osc_comment_user_id()) ?> пользователей)</a>
        <?php }?>
    <?php } else { ?>
        <b style="font-weight: bold; font-size: larger "><?php echo osc_comment_author_name(); ?></b>
    <?php }?>

    <?php if((osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id())) {?>
    <h5 style="margin: 0px"> <i class="fa fa-envelope"></i> <?php echo "". osc_comment_author_email(); ?>  </h5>
    <?php
    if (osc_comment_author_phone() or (osc_comment_author_phone() && osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()))) { ?>
        <h6 style="margin-bottom: 6px"> <?php echo osc_comment_author_phone(); ?></h6>
    <?php }?>
    <?php } ?>

    <p><?php echo nl2br( osc_comment_body() ); ?> </p>
    <!-- Добавлю сюда комменты -->
    
    <?php include "$path/oc-content/plugins/myCom/my_comments.php";?>


</div>