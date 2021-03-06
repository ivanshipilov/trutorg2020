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
?>
<?php
$type = 'items';
if(View::newInstance()->_exists('listType')){
    $type = View::newInstance()->_get('listType');
}

?>

<!--<div class="toolbar toolbars"><span class="sorting"> <a href="<?php echo osc_user_public_profile_url( Params::getParam('id') ); ?>?sShowAs=list" class="list-button <?php if(osclasswizards_show_as()=='list')echo "active"; ?>" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span> <i class="fa fa-th-list"></i> </span></a> <a href="<?php echo osc_user_public_profile_url( Params::getParam('id') ); ?>?sShowAs=gallery" class="grid-button <?php if(osclasswizards_show_as()=='gallery') echo "active"; ?>" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span> <i class="fa fa-th-large"></i></span></a> </span> </div>-->
<ul class="listings_list listing-card" id="listing-card-list">
  <?php
  $i = 0;

  //latest items
  if($type == 'latestItems'){

    while ( osc_has_latest_items() ) {
      ?>
      <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
      <li class="listing-card <?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <div class="list_space" <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) echo 'style="background-color: #effff4; border-color: #d1eada"'?>> <span class="ribbon"> <i class="fa fa-star"></i> </span>
          <div class="row">
            <!--<div class="col-sm-4 col-md-4">
              <figure>
                <?php if( osc_images_enabled_at_items() ) { ?>
                  <?php if(osc_count_item_resources()) { ?>
                    <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                  <?php } else { ?>
                    <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                  <?php } ?>
                <?php } ?>
              </figure>
            </div> -->
            <div class="col-sm-8 col-md-8"  style="margin-left: 5%">
              <div class="info">
                <div class="detail_info">
                  <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a></h4>

                  <div class="attribute_list"> <span class="category"><i class="fa fa-<?php echo osclasswizards_category_icon( osc_item_category_id() ); ?>"></i> <?php echo osc_item_category() ; ?></span> <?php if (osc_item_city()) {?><span class="location"><i class="fa fa-map-marker"></i> <?php echo osc_item_city(); ?>
                      <?php if( osc_item_region()!='' ) { ?>
                        (<?php echo osc_item_region(); ?>)
                      <?php } ?>
                      </span><?php }?> <span class="date"> <i class="fa fa-clock-o"></i> <?php echo osc_format_date(osc_item_pub_date()); ?> </span>
                    <?php if ((ItemComment::newInstance()->has_choice(osc_item_id(), osc_comment_id())) == 1) { ?>
                      <span style="margin: 0px"><i
                          class="fa fa-gavel"></i><?php echo " В исполнении " ?>
                      </span><?php } ?>
                    <?php if (osc_price_enabled_at_items()) { ?>
                      <span class="currency-value" style="margin: 0px"><i
                            class="fa fa-money"></i><?php echo " Ориентировочная цена заказчика: " . osc_item_formated_price(); ?></span>
                      <span class="currency-value"
                            style="margin: 0px; margin-bottom: 3px"><i
                            class="fa fa-money"></i> <?php echo " Минимальная предложенная цена: " . osc_format_min_price(osc_item_min_price()); ?></span>
                    <?php } ?>
                  </div>
                  <p style="margin-bottom: 0px"><?php echo osc_highlight( osc_item_description() ,150) ; ?></p>
                  <?php $admin = false; ?>
                  <?php if($admin){ ?>
                    <span class="admin-options"> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                        <?php _e('Edit item', OSCLASSWIZARDS_THEME_FOLDER); ?>
                      </a> <span>|</span> <a class="delete" onclick="return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', OSCLASSWIZARDS_THEME_FOLDER)); ?>')" href="<?php echo osc_item_delete_url();?>" >
                        <?php _e('Delete', OSCLASSWIZARDS_THEME_FOLDER); ?>
                      </a>
                      <?php if(osc_item_is_inactive()) {?>
                        <span>|</span> <a href="<?php echo osc_item_activate_url();?>" >
                          <?php _e('Activate', OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </a>
                      <?php } ?>
              </span>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <?php
    }

  }

  // premium items
  elseif($type == 'premiums'){
    while ( osc_has_premiums() ) {
      ?>
      <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
      <li class="listings_list listing-card premium">
        <div class="list_space" <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) echo 'style="background-color: #effff4; border-color: #d1eada"'?>> <span class="ribbon"> <i class="fa fa-star"></i> </span>
          <div class="row">
            <!--<div class="col-sm-4 col-md-4">
              <figure>
                <?php if( osc_images_enabled_at_items() ) { ?>
                  <?php if(osc_count_premium_resources()) { ?>
                    <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
                  <?php } else { ?>
                    <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
                  <?php } ?>
                <?php } ?>
              </figure>
            </div> -->
            <div class="col-sm-8 col-md-8"  style="margin-left: 5%">
              <div class="info">
                <div class="detail_info">
                  <h4><a href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_premium_title() ; ?></a></h4>

                  <div class="attribute_list"> <span class="category"><i class="fa fa-<?php echo osclasswizards_category_icon( osc_premium_category_id() ); ?>"></i> <?php echo osc_premium_category() ; ?></span> <span class="location"><i class="fa fa-map-marker"></i> <?php echo osc_premium_city(); ?>
                      <?php if(osc_premium_region()!='') { ?>
                        (<?php echo osc_premium_region(); ?>)
                      <?php } ?>
                </span> <span class="date"> <i class="fa fa-clock-o"></i> <?php echo osc_format_date(osc_premium_pub_date()); ?> </span>
                    <?php if ((ItemComment::newInstance()->has_choice(osc_item_id(), osc_comment_id())) == 1) { ?>
                      <span style="margin: 0px"><i
                          class="fa fa-gavel"></i><?php echo " В исполнении " ?>
                      </span><?php } ?>
                    <?php if (osc_price_enabled_at_items()) { ?>
                      <span class="currency-value" style="margin: 0px"><i
                            class="fa fa-money"></i><?php echo " Ориентировочная цена заказчика: " . osc_item_formated_price(); ?></span>
                      <span class="currency-value"
                            style="margin: 0px; margin-bottom: 3px"><i
                            class="fa fa-money"></i> <?php echo " Минимальная предложенная цена: " . osc_format_min_price(osc_item_min_price()); ?></span>
                    <?php } ?>
                  </div>
                  <p style= "margin-bottom: 0px"><?php echo osc_highlight( osc_premium_description(), 150 ); ?></p>
                  <?php $admin = false; ?>
                  <?php if($admin){ ?>
                    <span class="admin-options"> <a href="<?php echo osc_premium_edit_url(); ?>" rel="nofollow">
                        <?php _e('Edit item', OSCLASSWIZARDS_THEME_FOLDER); ?>
                      </a> <span>|</span> <a class="delete" onclick="return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', OSCLASSWIZARDS_THEME_FOLDER)); ?>')" href="<?php echo osc_premium_delete_url();?>" >
                        <?php _e('Delete', OSCLASSWIZARDS_THEME_FOLDER); ?>
                      </a>
                      <?php if(osc_premium_is_inactive()) {?>
                        <span>|</span> <a href="<?php echo osc_premium_activate_url();?>" >
                          <?php _e('Activate', OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </a>
                      <?php } ?>
              </span>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <?php
    }
  }
  else {
    while(osc_has_items()) {

      $admin = false;
      if(View::newInstance()->_exists("listAdmin")){
        $admin = true;
      }
      ?>
      <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
      <li class="listings_list listing-card<?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <div class="list_space" <?php if ((ItemComment::newInstance() ->has_choice(osc_item_id(),osc_comment_id())) == 1) echo 'style="background-color: #effff4; border-color: #d1eada"'?>> <span class="ribbon"> <i class="fa fa-star"></i> </span>
          <div class="row">
            <!--<div class="col-sm-4 col-md-4">
              <figure>
                <?php if( osc_images_enabled_at_items() ) { ?>
                  <?php if(osc_count_item_resources()) { ?>
                    <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                  <?php } else { ?>
                    <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                  <?php } ?>
                <?php } ?>
              </figure>
            </div>-->
            <div class="col-sm-8 col-md-8"  style="margin-left: 5%">
              <div class="info">
                <div class="detail_info">
                  <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a></h4>

                  <div class="attribute_list"> <span class="category"><i class="fa fa-<?php echo osclasswizards_category_icon( osc_item_category_id() ); ?>"></i> <?php echo osc_item_category() ; ?></span> <span class="location"><i class="fa fa-map-marker"></i> <?php echo osc_item_city(); ?>
                      <?php if( osc_item_region()!='' ) { ?>
                        (<?php echo osc_item_region(); ?>)
                      <?php } ?>
                </span> <span class="date"> <i class="fa fa-clock-o"></i> <?php echo osc_format_date(osc_item_pub_date()); ?> </span>
                    <?php if ((ItemComment::newInstance()->has_choice(osc_item_id(), osc_comment_id())) == 1) { ?>
                      <span style="margin: 0px"><i
                          class="fa fa-gavel"></i><?php echo " В исполнении " ?>
                      </span><?php } ?>
                    <?php if (osc_price_enabled_at_items()) { ?>
                      <span class="currency-value" style="margin: 0px"><i
                            class="fa fa-money"></i><?php echo " Ориентировочная цена заказчика: " . osc_item_formated_price(); ?></span>
                      <span class="currency-value"
                            style="margin: 0px; margin-bottom: 3px"><i
                            class="fa fa-money"></i> <?php echo " Минимальная предложенная цена: " . osc_format_min_price(osc_item_min_price()); ?></span>
                    <?php } ?>
                  </div>
                  <p style="margin-bottom: 0px"><?php echo osc_highlight( osc_item_description() ,150) ; ?></p>
                  <?php if($admin){ ?>
                    <span class="admin-options"> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                        <?php _e('Edit item', OSCLASSWIZARDS_THEME_FOLDER); ?>
                      </a> <span>|</span> <a class="delete" onclick="return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', OSCLASSWIZARDS_THEME_FOLDER)); ?>')" href="<?php echo osc_item_delete_url();?>" >
                        <?php _e('Delete', OSCLASSWIZARDS_THEME_FOLDER); ?>
                      </a>
                      <?php if(osc_item_is_inactive()) {?>
                        <span>|</span> <a href="<?php echo osc_item_activate_url();?>" >
                          <?php _e('Activate', OSCLASSWIZARDS_THEME_FOLDER); ?>
                        </a>
                      <?php } ?>
              </span>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
      <?php
    }
  }
  ?>
</ul>
