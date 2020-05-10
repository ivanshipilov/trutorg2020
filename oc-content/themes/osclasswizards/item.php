<?php
/*
 *      Osclass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2014 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// meta tag robots
if( osc_item_is_spam() || osc_premium_is_spam() ) {
    osc_add_hook('header','osclasswizards_nofollow_construct');
} else {
    osc_add_hook('header','osclasswizards_follow_construct');
}

osclasswizards_add_body_class('item');

if(osclasswizards_show_as() == 'gallery'){
    $loop_template	=	'loop-search-grid.php';
    $buttonClass = 'active';
}else{
    $loop_template	=	'loop-search-list.php';
    $buttonClass = '';
}

function sidebar(){
    osc_current_web_theme_path('item-sidebar.php');
}

$location = array();
if( osc_item_city_area() !== '' ) {
    $location[] = osc_item_city_area();
}
if( osc_item_city() !== '' ) {
    $location[] = osc_item_city();
}
if( osc_item_region() !== '' ) {
    $location[] = osc_item_region();
}
if( osc_item_country() !== '' ) {
    $location[] = osc_item_country();
}

osc_current_web_theme_path('header.php');

$path = osc_base_path();
include_once "$path/oc-includes/osclass/model/userRaty.php";
include_once "$path/oc-includes/osclass/frm/MyCom.form.class.php";
include_once "$path/oc-includes/osclass/model/myCom.php";
echo '<script src="'.osc_base_url().'/oc-content/plugins/myCom/js_comments.js" type="text/javascript"></script>';

?>

<script src="https://yastatic.net/share2/share.js" async="async"></script>

<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>

<script type="text/javascript">
    VK.init({apiId: 5501574, onlyWidgets: true});
</script>

<div class="row" >

    <div class="col-sm-7 col-md-8">
        <div id="item-content" <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) echo 'style="background-color: #effff4; border-color: #d1eada"'?>>
            <?php if((osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) && ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 0)) { ?>
                <p id="edit_item_view"> <strong> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                            <?php _e('Edit item', OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </a> </strong> </p>
            <?php } ?>
            <h1 class="title title_code"> <strong><?php echo osc_item_title(); ?></strong> </h1>
            <div class="stat_item"><?php _e("Просмотров", 'russia') ; ?>: <strong><?php echo osc_item_views(); ?></strong>
                <?php _e("Предложений", 'russia') ; ?>: <strong><?php echo osc_count_item_comments(); ?></strong></div>
            <ul class="item-header" style="margin-bottom: 1px">
                <li>
                    <?php if( osc_price_enabled_at_items() ) { ?>
                        <i class="fa fa-money"></i>
                        Ориентировочная цена заказчика :
                        <?php echo osc_item_formated_price(); ?>
                    <?php } ?>
                </li>
                <?php if( osc_count_item_comments() >= 1 )
                {?>
                    <!-- Добавил еще одно поле для мин.предложенной цены-->
                    <?php $newPrices = array();?>
                    <li>
                        <i class="fa fa-money"></i>
                        Минимальная предложенная цена:
                        <?php echo osc_format_min_price(osc_item_min_price())?>
                    </li>
                <?php }; ?>
                <li>
                    <?php if ( osc_item_pub_date() !== '' ) { printf( __('<i class="fa fa-calendar-o"></i> Published date: %1$s', OSCLASSWIZARDS_THEME_FOLDER), osc_format_date( osc_item_pub_date() ) ); } ?>
                </li>
                <?php if ( osc_item_mod_date() !== '' ) {?>
                    <li>
                        <?php if ( osc_item_mod_date() !== '' ) { printf( __('<span class="update"><i class="fa fa-calendar"></i> Modified date:</span> %1$s', OSCLASSWIZARDS_THEME_FOLDER), osc_format_date( osc_item_mod_date() ) ); } ?>
                    </li>
                <?php } ?>
                <?php if (count($location)>0) { ?>
                    <li>
                        <ul id="item_location">
                            <li><i class="fa fa-map-marker"></i> <?php echo implode(', ', $location); ?></li>
                        </ul>
                    </li>
                <?php }; ?>
                <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) {?>
                    <li>
                        <i class="fa fa-gavel  "></i>
                        В исполнении
                    </li>
                <?php } ?>
            </ul>

            <?php if( osc_images_enabled_at_items() ) { ?>
                <div class="item-photos">
                    <div class="row">
                        <?php
                        if( osc_count_item_resources() > 0 ) {
                            $i = 0;
                            ?>
                            <div class="col-md-10"> <a href="<?php echo osc_resource_url(); ?>" class="main-photo" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img class="img-responsive" src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" /> </a></div>
                            <div class="col-md-2">
                                <div class="thumbs">
                                    <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                                        <a href="<?php echo osc_resource_url(); ?>" class="fancybox" data-fancybox-group="group" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" class="img-responsive"/> </a>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php
                        } else{?>
                            <!--<div class="col-md-10"> <a href="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="main-photo" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> 1 / 1"> <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" /> </a></div>
          <div class="col-md-2">
            <div class="thumbs"> <a href="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="fancybox" data-fancybox-group="group" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> 1 / 1"> <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="75" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" class="img-responsive"/> </a> </div>
          </div>-->
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div id="description" style="margin-top: -15px">
                <span style="font-weight:bold;  margin-top: 0;  margin-bottom: 1px">Описание:</span>
                <p style="margin-right: 0"><?php echo "   ".osc_item_description(); ?></p>
                <div id="custom_fields">
                    <?php if( osc_count_item_meta() >= 1 ) { ?>
                        <br />
                        <div class="meta_list">
                            <?php while ( osc_has_item_meta() ) { ?>
                                <?php if(osc_item_meta_value()!='') { ?>
                                    <div class="meta"> <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?> </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php osc_run_hook('item_detail', osc_item() ); ?>
                <ul class="contact_button">
                    <!-- <li>
            <?php if( !osc_item_is_expired () ) { ?>
            <?php if( !( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) ) { ?>
            <?php     if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
            <a href="#contact">
            <?php _e('Contact seller', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a>
            <?php     } ?>
            <?php     } ?>
            <?php } ?>
            </li> -->
                    <?php if (((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 0) && ((osc_logged_user_id() !== osc_user_id()) || osc_user_id() == 0)) { ?>
                        <li id="menu"><a href="#here" >Предложить цену</a></li>
                    <?php } ?>
                    <?php if(function_exists('watchlist')) {?>
                        <li>
                            <?php watchlist(); ?>
                        </li>
                    <?php } if (osc_user_id() !== 0) {?>
                    <li><a class="see_all" href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>">
                            страница заказчика
                        </a> </li>
                    <?php } ?>
                    <li id="menu1"><a href="#vk_comments" >Обсудить</a></li>
                </ul>

                <?php osc_run_hook('location'); ?>
            </div>

            <div class="share" style="overflow: hidden"><div class="ya-share2" style="float: right" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter,lj" data-title="<?=osc_item_title();?>" data-description="<?=osc_item_description();?>" data-image="<?="http://trutorg.com/oc-content/themes/osclasswizards/images/logo_for_VK2.jpg" ?>" ></div></div>
        </div>
        <?php if( osc_comments_enabled() ) { ?>
        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
        <div id="comments">
            <?php if( osc_count_item_comments() >= 1 ) { ?>
                <h2 class="title">
                    Предложения
                    <?php

                    ?>
                </h2>
            <?php }  else if (((osc_logged_user_id() == osc_user_id()) || osc_user_id() == 0) && osc_has_item_comments() == 0) { ?>
                <h2 class="title" style="margin: 50px 0 50px 0">
                    Скоро здесь появятся предложения, из которых заказчик сможет выбрать подходящее
                </h2>
            <?php } ?>
            <?php if( osc_count_item_comments() >= 1 ) { ?>
                <div class="comments_list" <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) echo 'style="background-color: #effff4; border-color: #d1eada"'?>>
                    <?php while ( osc_has_item_comments() ) { ?>
                        <div class="comment" style="border-bottom: ridge">
                            <h4 style="margin-bottom: 3px; margin-top: 10px; font-size: large "><?php echo (float) osc_comment_title() ;echo  osc_item_currency_symbol();?>
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
                                <input hidden id="ratingValue<?php echo osc_comment_id()?>" value="<?php echo userRaty::newInstance()->totalRating(osc_comment_user_id()) ?>">
                                <a class="ratingOfUser<?php echo osc_comment_id()?>" style="font-size: 6px; margin-left: 3px; color: #f7aa00"></a>
                                <?php if (userRaty::newInstance()->count(osc_comment_user_id())==1) { ?>
                                    <a>(По оценке <?php echo userRaty::newInstance()->count(osc_comment_user_id()) ?> пользователя)</a>
                                <?php } if (userRaty::newInstance()->count(osc_comment_user_id())>1) {?>
                                    <a>(По оценкам <?php echo userRaty::newInstance()->count(osc_comment_user_id()) ?> пользователей)</a>
                                <?php }?>
                            <?php } else { ?>
                                <b style="font-weight: bold; font-size: larger "><?php echo osc_comment_author_name(); ?></b>
                            <?php }?>
                            <br><a class="chk" style="margin: 1px" id="chk<?php echo osc_comment_id(); ?>" onclick="js_showOrHideDiv(<?php echo osc_comment_id(); ?>)">подробнее</a>
                                <?php include "$path/oc-content/themes/osclasswizards/InfoBlock.php";?>
                            <?php ?>
                            <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                                <p style="margin: 1px"> <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete your comment', OSCLASSWIZARDS_THEME_FOLDER)); ?>">
                                        <?php _e('Delete', OSCLASSWIZARDS_THEME_FOLDER); ?>
                                    </a> </p>
                            <?php } ?>
                            <?php if (osc_comment_user_id()) {?>
                                <script>
                                    //для отображения рейтингов
                                    $('.ratingOfUser<?php echo osc_comment_id()?>').raty({
                                        half     : true,
                                        readOnly : true,
                                        starType : 'i',
                                        score    : document.getElementById('ratingValue<?php echo osc_comment_id()?>').value
                                    });
                                </script>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="pagination"> <?php echo osc_comments_pagination(); ?> </div>
                </div>
            <?php } ?>
        </div>

        <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id()) == 0) && (( osc_logged_user_id() !== osc_user_id() ) || osc_user_id() == 0 ))
        {
            ?>

            <div class="comment_form" id="here">
                <div class="title">
                    <h1> Оставьте ваше ценовое предложение </h1>
                    <ul style="margin-top: 10px" id="comment_error_list"> </ul>
                    <?php CommentForm::js_validation(); ?>

                </div>
                <div class="resp-wrapper">
                    <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                        <fieldset>
                            <input type="hidden" name="action" value="add_comment" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <?php if(osc_is_web_user_logged_in()) { ?>
                            <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                            <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                                <!--<div class="form-group">    -->
                            <input type = 'checkbox' name="showPhone" id = 'chkPhone' >
                                <label class="control-label" for="authorPhone"><b>Оставить номер телефона </b></label>

                                <div id="elPhone" style="display: none">
                                    <input name="authorPhone" value="<?php echo " ". osc_logged_user_phone();?>" />
                                </div>

                                <script>js_showOrHideChkbox('Phone')</script>

                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="control-label" for="authorName">
                                        Ваше имя (или название фирмы)<sup>*</sup>
                                    </label>
                                    <div class="controls">
                                        <?php CommentForm::author_input_text(); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="authorEmail">
                                        <?php _e('Your e-mail', OSCLASSWIZARDS_THEME_FOLDER); ?><sup>*</sup> (будет доступен только заказчику)
                                    </label>
                                    <div class="controls">
                                        <?php CommentForm::email_input_text(); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="authorPhone">
                                        Ваш номер телефона (не обязательно. Будет доступен только заказчику)
                                    </label>
                                    <div class="controls">
                                        <?php CommentForm::phone_input_text(); ?>
                                    </div>
                                </div>

                            <?php }; ?>
                            <div class="form-group">
                                <label class="control-label" for="title">
                                    <!--     <?php _e('Title', OSCLASSWIZARDS_THEME_FOLDER); ?>-->
                                    Ваше ценовое предложение<sup>*</sup>
                                </label>


                                <div class="controls">
                                    <ul class="row">
                                        <li class="col-sm-5 col-md-5">

                                            <?php if( osc_count_item_comments() >= 1 )
                                            {
                                                CommentForm::New_price_fromMin_input_text(null,osc_item_min_price());
                                            }
                                            else  CommentForm::New_price_input_text();
                                            ?>
                                        </li>
                                        <li class="col-sm-7 col-md-7">

                                            <input type="text" style="background-color: gainsboro " value="<?php echo osc_item_field("fk_c_currency_code") ?>" disabled>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                            <div class="form-group">
                                <label class="control-label" for="body">
                                    Комментарий (так же можете добавить ссылки, например, на Ваши работы):
                                </label>
                                <div class="controls textarea">
                                    <?php CommentForm::body_input_textarea(); ?>
                                </div>
                            </div>
                            <div class="actions">
                                <?php anr_captcha_form_field(); ?>
                                <button type="submit" class="btn btn-success">
                                    <?php _e('Send', OSCLASSWIZARDS_THEME_FOLDER); ?>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        <?php } ?>

        <div style="margin: 15px 0 15px 0; border: solid 1px #eaeaea;"><div id="vk_comments" ></div>
            <script type="text/javascript">
                VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*",page_id: <?php echo osc_item_id() ?> });
            </script></div>

    </div>
    <?php } ?>
    <?php } ?>


    <div class="col-sm-5 col-md-4">
        <?php
        if(function_exists('show_qrcode')){
            echo '<div class="block_list block_listed">';
            show_qrcode();
            echo ' </div>';

        }
        ?>
        <div class="alert_block">
            <?php if(!osc_is_web_user_logged_in() || osc_logged_user_id()!=osc_item_user_id()) { ?>
                <form action="<?php echo osc_base_url(true); ?>" method="post" name="mask_as_form" id="mask_as_form" <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) echo 'style="background-color: #effff4; border-color: #d1eada"'?>>
                    <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                    <input type="hidden" name="as" value="spam" />
                    <input type="hidden" name="action" value="mark" />
                    <input type="hidden" name="page" value="item" />
                    <select name="as" id="as" class="mark_as">
                        <option>
                            <?php _e("Mark as...", OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </option>
                        <option value="spam">
                            <?php _e("Mark as spam", OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </option>
                        <option value="badcat">
                            <?php _e("Mark as misclassified", OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </option>
                        <option value="repeated">
                            <?php _e("Mark as duplicated", OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </option>
                        <option value="expired">
                            <?php _e("Mark as expired", OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </option>
                        <option value="offensive">
                            <?php _e("Mark as offensive", OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </option>
                    </select>
                </form>
            <?php } ?>
        </div>
        <?php osc_current_web_theme_path('item-sidebar.php'); ?>
    </div>
</div>
<?php related_listings(); ?>
<?php if( osc_count_items() > 0 ) { ?>
    <div class="similar_ads">
        <h2 class="title">
            Похожие заказы
        </h2>
        <?php
        View::newInstance()->_exportVariableToView("listType", 'items');
        osc_current_web_theme_path($loop_template);
        ?>
    </div>
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>
