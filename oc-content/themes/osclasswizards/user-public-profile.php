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
osc_add_hook('header','osclasswizards_follow_construct');

if(osclasswizards_show_as() == 'gallery'){
    $loop_template	=	'loop-user-public-grid.php';
}else{
    $loop_template	=	'loop-user-public-list.php';
}

$address = '';
if(osc_user_address()!='') {
    if(osc_user_city_area()!='') {
        $address = osc_user_address().", ".osc_user_city_area();
    } else {
        $address = osc_user_address();
    }
} else {
    $address = osc_user_city_area();
}
$location_array = array();
if(trim(osc_user_city()." ".osc_user_zip())!='') {
    $location_array[] = trim(osc_user_city()." ".osc_user_zip());
}
if(osc_user_region()!='') {
    $location_array[] = osc_user_region();
}
if(osc_user_country()!='') {
    $location_array[] = osc_user_country();
}
$location = implode(", ", $location_array);
unset($location_array);

osc_enqueue_script('jquery-validate');

osclasswizards_add_body_class('user-public-profile');

osc_add_hook('before-main','sidebar');

function sidebar(){
    osc_current_web_theme_path('user-public-sidebar.php');
}

osc_current_web_theme_path('header.php');
include_once "$path./oc-includes/osclass/model/userRaty.php";
include_once "$path./oc-includes/osclass/frm/Rating.form.class.php";
?>


<div class="row">
    <div class="col-sm-4 col-md-3">
        <div class="user-card">
            <!--<figure><img class="img-responsive" src="http://www.gravatar.com/avatar/<?php echo md5( strtolower( trim( osc_user_email() ) ) ); ?>?s=400&d=<?php echo osc_current_web_theme_url('images/default.gif') ; ?>" /></figure> -->
            <ul id="user_data">
                <div style="margin-bottom: 15px"><?php profile_picture_show(); ?></div>
                <li class="name">
                    <h3><i class="fa fa-user"></i> <?php echo osc_user_name(); ?></h3>
                </li>
                <li class="name">
                    <input hidden name="ratingValue" value="<?php echo userRaty::newInstance()->totalRating(osc_user_id()) ?>">
                    <div name="ratingOf" style="color: #f7aa00 "></div>
                    <?php if (userRaty::newInstance()->count(osc_user_id())==1) { ?>
                        <p>По оценке <?php echo userRaty::newInstance()->count(osc_user_id()) ?> пользователя</p>
                    <?php } if (userRaty::newInstance()->count(osc_user_id())>1) {?>
                        <p>По оценкам <?php echo userRaty::newInstance()->count(osc_user_id()) ?> пользователей</p>
                    <?php }?>
                </li>
                <?php if (osc_user_phone()&& osc_show_phone_public()) {?><p class="phone"><i class="fa fa-phone"></i><?php printf('%s', osc_user_phone()); ?></p><?php }?>
                <?php if( osc_user_website() !== '' ) { ?>
                    <li class="website"><i class="fa fa-link"></i> <strong><a target="_blank" href="<?php echo osc_user_website(); ?>"><?php echo osc_user_website(); ?></a></strong></li>
                <?php } ?>
                <?php if( $address !== '' ) { ?>
                    <li class="adress"> <i class="fa fa-map-marker"></i> <strong><?php _e('Address', OSCLASSWIZARDS_THEME_FOLDER);?>:</strong><br><?php echo $address; ?></li>
                <?php } ?>
                <?php if( $location !== '' ) { ?>
                    <li class="location"><i class="fa fa-location-arrow"></i> <strong><?php _e('Location', OSCLASSWIZARDS_THEME_FOLDER);?>:</strong><br><?php echo  $location; ?></li>
                <?php } ?>
            </ul>
        </div><!-- тут был закрывающий див для юзеркард-->
        <?php
        if (osc_user_info()) { ?>
            <section class="user_detail_info">
                <?php if( osc_user_info() !== '' ) { ?>
                    <div class="title">
                        <h1>
                            <?php _e('User description', OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </h1>
                    </div>
                <?php } ?>
                <?php echo nl2br(osc_user_info()); ?> </section>
        <?php } ?>
        <?php RatingForm::js_validation(); ?>
        <div class="rating_form">
            <form name="rating_form" id="rating_form">
                <fieldset>
                    <?php if ((osc_logged_user_id()<>osc_user_id()) && (osc_is_web_user_logged_in())) { ?>
                    <?php if (osc_logged_user_id()>0) {?>
                    <label style="margin-top: 10px">Ваш отзыв</label><br>
                    <textarea name="comment" id="rComment"><?php if (userRaty::newInstance()->commentOfLoggedUserforCurrentUser(osc_logged_user_id(),osc_user_id())) echo userRaty::newInstance()->commentOfLoggedUser(osc_logged_user_id())?></textarea>
                    <label><div id="result"><?php if ((userRaty::newInstance()->scoreOfLoggedUser(osc_logged_user_id(),osc_user_id()) ==0)&& (osc_logged_user_id())) {echo 'Оцените исполнителя/заказчика';} else if ((osc_logged_user_id() != osc_user_id()) && userRaty::newInstance()->commentOfLoggedUserforCurrentUser(osc_logged_user_id(),osc_user_id())) {echo 'Ваша оценка';}?></div><label>
                            <?php } ?>


                            <div class="toRate" id="toRate" style="color: #f7aa00">   <!-- описано ниже --> </div>
                            <?php $executor = osc_user_name();
                            $idexecutor = osc_user_id();
                            $userId = Session::newInstance()->_get('userId');
                            $userName = Session::newInstance()->_get('userName');
                            $r_pub_date = date('Y-m-d H:i:s')?>

                            <input hidden id="executor" value="<?php echo $executor; ?>">
                            <input hidden id="idexecutor" value="<?php echo $idexecutor; ?>">
                            <input hidden id="r_of_user" value="<?php echo $userId; ?>">
                            <input hidden id="r_user_name" value="<?php echo $userName; ?>">
                            <input hidden id="r_pub_date" value="<?php echo $r_pub_date; ?>">

                            <div style="margin-bottom: 20px">
                                <button id="button" type="submit" class="btn btn-success">
                                    <?php if ((userRaty::newInstance()->scoreOfLoggedUser(osc_logged_user_id(),osc_user_id()) ==0)&& (osc_logged_user_id())) {echo 'Оценить';} else if (osc_logged_user_id() != osc_user_id()) {echo 'Изменить оценку';}?>
                                </button>
                            </div>
                            <div style="margin-top: 15px" class="errorTxt"></div>
                            <script>// для ввода рейтинга


                                $('#toRate').raty
                                ({
                                    cancel   : false,
                                    half     : false,
                                    starType : 'i',
                                    score    : '<?php echo userRaty::newInstance()->scoreOfLoggedUser(osc_logged_user_id(),osc_user_id())?>'
                                });
                            </script>
                            <?php }?>
                            <script>
                                //для отображения рейтинга

                                $('[name=ratingOf]').raty({
                                    half     : true,
                                    readOnly : true,
                                    starType : 'i',
                                    score    : document.getElementsByName('ratingValue')[0].value
                                });
                            </script>
                </fieldset>
            </form>
        </div>
    </div>
    <!-- если есть отзывы...-->
    <?php if (userRaty::newInstance()->Allcomment(osc_user_id())) {?>
        <div class="col-sm-8 col-md-9">
            <div class="title">
                <h1>Отзывы</h1>
            </div>
            <div class="comments_list">
                <div class="comment" style="border-bottom: ridge">
                    <?php $allComments = userRaty::newInstance()->Allcomment(osc_user_id());
                    $allUsers = userRaty::newInstance()->AllUsers(osc_user_id());
                    $allUsersIds = userRaty::newInstance()->AllUsersId(osc_user_id());
                    $i=0;
                    //var_dump(userRaty::newInstance()->AllUsers(osc_user_id()));
                    while ($allComments[$i])
                    {
                        //var_dump(userRaty::newInstance()->scoreOfLoggedUser($allUsersIds[$i]));
                        ?><input hidden name="ratingValueOfUser<?php echo $allUsersIds[$i]?>" value="<?php echo userRaty::newInstance()->scoreOfLoggedUser($allUsersIds[$i],osc_user_id()) ?>"><?php
                        ?><h3 style="margin-bottom: 5px; margin-top: 0px"><a href="<?php echo osc_user_public_profile_url( $allUsersIds[$i] ); ?>" ><i class="fa fa-user"></i><?php echo $allUsers[$i]; ?></a><a style="font-size: 7px; margin-left: 7px; color: #f7aa00"  name="ratingOfUser<?php echo $allUsersIds[$i]?>"></a></h3><?php
                        ?><p style="margin-bottom: 25px"><?php echo $allComments[$i];?></p><?php
                    ?>
                        <script>
                            //для отображения рейтинга

                            $('[name=ratingOfUser<?php echo $allUsersIds[$i]?>]').raty({
                                half     : true,
                                readOnly : true,
                                starType : 'i',
                                score    : document.getElementsByName('ratingValueOfUser<?php echo $allUsersIds[$i]?>')[0].value
                            });
                        </script>
                        <?php
                        $i++;
                    }?>

                </div>
            </div>
        </div>
    <?php } else {?>
        <!-- если нет отзывов...-->
        <div class="col-sm-8 col-md-9">
            <div class="title">
                <h1>Еще нет отзывов</h1>
            </div>
        </div>

    <?php } ?>

    <div class="col-sm-8 col-md-9">
        <?php if( osc_count_items() > 0 ) { ?>
            <div class="similar_ad">
                <div class="title">
                    <h1 style="margin-top: 15px">
                        <?php _e('Latest listings', OSCLASSWIZARDS_THEME_FOLDER); ?>
                    </h1>
                </div>
                <?php osc_current_web_theme_path($loop_template); ?>
                <div class="pagination"><?php echo osc_pagination_items(); ?></div>
            </div>
        <?php } else {?>
            <div class="title">
                <h1 style="margin-top: 15px">
                    Еще нет объявлений
                </h1>
            </div>
        <?php } ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>


