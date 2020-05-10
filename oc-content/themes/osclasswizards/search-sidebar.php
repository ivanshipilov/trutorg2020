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
     $category = __get("category");
     if(!isset($category['pk_i_id']) ) {
         $category['pk_i_id'] = null;
     }

?>
<style>
  ul.sub {
    padding-left: 20px;
  }
  .chbx{
    width:15px; height:15px;
    display: inline;
    padding:8px 3px;
    background-repeat:no-repeat;
    cursor: pointer;



  }
</style>

<script type="text/javascript">
  $(document).ready(function(){
    $('li.parent').each(function() {
      var totalInputSub = $(this).find('ul.sub>li>input').size();
      var totalInputSubChecked = $(this).find('ul.sub>li>input:checked').size();
      $(this).find('ul.sub>li>input').each(function(){
        $(this).hide();
        var id = $(this).attr('id');
        id = id+'_';
        if( $(this).is(':checked') ){
          var aux = $('<div class="chbx checked"><span></span></div>').attr('id', id);
          $(this).before(aux);
        } else {
          var aux = $('<div class="chbx"><span></span></div>').attr('id', id);
          $(this).before(aux);
        }
      });

      var input = $(this).find('input.parent');
      $(input).hide();
      var id = $(input).attr('id');
      id = id+'_';
      if(totalInputSub == totalInputSubChecked) {
        if(totalInputSub == 0) {
          if( $(this).find("input[name='sCategory[]']:checked").size() > 0) {
            var aux = $('<div class="chbx checked"><span></span></div>').attr('id', id);
            $(input).before(aux);
          } else {
            var aux = $('<div class="chbx"><span></span></div>').attr('id', id);
            $(input).before(aux);
          }
        } else {
          var aux = $('<div class="chbx checked"><span></span></div>').attr('id', id);
          $(input).before(aux);
        }
      }else if(totalInputSubChecked == 0) {
        // no input checked
        var aux = $('<div class="chbx"><span></span></div>').attr('id', id);
        $(input).before(aux);
      }else if(totalInputSubChecked < totalInputSub) {
        var aux = $('<div class="chbx semi-checked"><span></span></div>').attr('id', id);
        $(input).before(aux);
      }
    });

    $('li.parent').prepend('<span style="width:6px;display:inline-block; color: #4e6d80" class="toggle">+</span>');
    $('ul.sub').toggle();

    $('span.toggle').click(function(){
      $(this).parent().find('ul.sub').toggle();
      if($(this).text()=='+'){
        $(this).html('-');
      } else {
        $(this).html('+');
      }
    });

    $("li input[name='sCategory[]']").change( function(){
      var id = $(this).attr('id');
      $(this).click();
      $('#'+id+'_').click();
    });

    $('div.chbx').click( function() {
      var isChecked       = $(this).hasClass('checked');
      var isSemiChecked   = $(this).hasClass('semi-checked');

      if(isChecked) {
        $(this).removeClass('checked');
        $(this).next('input').prop('checked', false);
      } else if(isSemiChecked) {
        $(this).removeClass('semi-checked');
        $(this).next('input').prop('checked', false);
      } else {
        $(this).addClass('checked');
        $(this).next('input').prop('checked', true);
      }

      // there are subcategories ?
      if($(this).parent().find('ul.sub').size()>0) {
        if(isChecked){
          $(this).parent().find('ul.sub>li>div.chbx').removeClass('checked');
          $(this).parent().find('ul.sub>li>input').prop('checked', false);
        } else if(isSemiChecked){
          // if semi-checked -> check-all
          $(this).parent().find('ul.sub>li>div.chbx').removeClass('checked');
          $(this).parent().find('ul.sub>li>input').prop('checked', false);
          $(this).removeClass('semi-checked');
        } else {
          $(this).parent().find('ul.sub>li>div.chbx').addClass('checked');
          $(this).parent().find('ul.sub>li>input').prop('checked', true);
        }
      } else {
        // is subcategory checkbox or is category parent without subcategories
        var parentLi = $(this).closest('li.parent');

        // subcategory
        if($(parentLi).find('ul.sub').size() > 0) {
          var totalInputSub           = $(parentLi).find('ul.sub>li>input').size();
          var totalInputSubChecked    = $(parentLi).find('ul.sub>li>input:checked').size();

          var input    = $(parentLi).find('input.parent');
          var divInput = $(parentLi).find('div.chbx').first();

          $(input).prop('checked', false);
          $(divInput).removeClass('checked');
          $(divInput).removeClass('semi-checked');

          if(totalInputSub == totalInputSubChecked) {
            $(divInput).addClass('checked');
            $(input).prop('checked', true);
          }else if(totalInputSubChecked == 0) {
            // no input checked;
          }else if(totalInputSubChecked < totalInputSub) {
            $(divInput).addClass('semi-checked');
          }
        } else {
          // parent category
        }
      }
    });
  });
</script>
<div class="col-sm-4 col-md-3">
  <div id="sidebar">
    <div class="filters">
      <form action="<?php echo osc_base_url(true); ?>" method="get" onsubmit="return doSearch()" class="nocsrf">
        <input hidden name="page" value="search" />
        <input hidden name="sOrder" value="<?php echo osc_esc_html(osc_search_order()); ?>" />
        <input hidden name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting(); echo osc_esc_html($allowedTypesForSorting[osc_search_order_type()]); ?>" />
        <?php foreach(osc_search_user() as $userId) { ?>
          <input type="hidden" name="sUser[]" value="<?php echo osc_esc_html($userId); ?>" />
        <?php } ?>
        <fieldset class="box location">
          <h3><strong><?php _e('Your search', OSCLASSWIZARDS_THEME_FOLDER); ?></strong></h3>
          <div class="row one_input">
            <input type="text" name="sPattern" id="query" value="<?php echo osc_esc_html( osc_search_pattern() ); ?>" />
            <div id="search-example"></div>
          </div>
          <h3><strong><?php _e('City', OSCLASSWIZARDS_THEME_FOLDER); ?></strong></h3>
          <div class="row one_input">

            <input type="text" id="sCity" name="sCity" value="<?php echo osc_esc_html( osc_search_city() ); ?>" />
            <input type="hidden" id="sRegion" name="sRegion" value="" />
          </div>
        </fieldset>

        <fieldset class="box show_only">
          <?php if( osc_images_enabled_at_items() ) { ?>
            <!--<h3><strong><?php _e('Show only', OSCLASSWIZARDS_THEME_FOLDER); ?></strong></h3>
            <div class="row checkboxes">
              <ul>
                <li>
                  <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
                  <label for="withPicture"><?php _e('Show only listings with pictures', OSCLASSWIZARDS_THEME_FOLDER); ?></label>
                </li>
              </ul>
            </div>
            -->
          <?php } ?>
          <?php if( osc_price_enabled_at_items() ) { ?>
            <div class="row two_input">
              <h3><strong><?php _e('Price', OSCLASSWIZARDS_THEME_FOLDER); ?></strong></h3>
              <div><?php _e('Min', OSCLASSWIZARDS_THEME_FOLDER); ?>.</div>
              <input type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_esc_html(osc_search_price_min()); ?>" size="6" maxlength="6" />
              <div><?php _e('Max', OSCLASSWIZARDS_THEME_FOLDER); ?>.</div>
              <input type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_esc_html(osc_search_price_max()); ?>" size="6" maxlength="6" />
            </div>
          <?php } ?>
          <?php  osc_get_non_empty_categories(); ?>
          <?php  if ( osc_count_categories() ) { ?>
            <div class="row checkboxes">
              <h3><strong><?php _e('Category', OSCLASSWIZARDS_THEME_FOLDER); ?></strong></h3>
              <ul>
                <?php // RESET CATEGORIES IF WE USED THEN IN THE HEADER ?>
                <?php osc_goto_first_category(); ?>
                <?php while(osc_has_categories()) { ?>
                  <li class="parent">
                    <input class="parent" type="checkbox" id="cat<?php echo osc_esc_html(osc_category_id()); ?>" name="sCategory[]" value="<?php echo osc_esc_html(osc_category_id()); ?>" <?php $parentSelected=false; if (in_array(osc_category_id(), osc_search_category()) || in_array(osc_category_slug()."/", osc_search_category()) || in_array(osc_category_slug(), osc_search_category()) || count(osc_search_category())==0 ){ echo 'checked="checked"'; $parentSelected=true;} ?> /> <label for="cat<?php echo osc_esc_html(osc_category_id()); ?>"><strong><?php echo osc_category_name(); ?></strong></label>
                    <?php if(osc_count_subcategories() > 0) { ?>
                      <ul class="sub">
                        <?php while(osc_has_subcategories()) { ?>
                          <li>
                            <input type="checkbox" id="cat<?php echo osc_esc_html(osc_category_id()); ?>" name="sCategory[]" value="<?php echo osc_esc_html(osc_category_id()); ?>"  <?php if( $parentSelected || in_array(osc_category_id(), osc_search_category()) || in_array(osc_category_slug()."/", osc_search_category()) || in_array(osc_category_slug(), osc_search_category()) || count(osc_search_category())==0 ){echo 'checked="checked"';} ?> />
                            <label for="cat<?php echo osc_esc_html(osc_category_id()); ?>"><strong><?php echo osc_category_name(); ?></strong></label>
                          </li>
                        <?php } ?>
                      </ul>
                    <?php } ?>
                  </li>
                <?php } ?>
              </ul>
            </div>
          <?php } //osclasswizards_footer_js() ?> <!-- подключаю ihelper, который сидит в хуке footer-->
        </fieldset>
        <?php
        if(osc_search_category_id()) {
          osc_run_hook('search_form', osc_search_category_id());
        } else {
          osc_run_hook('search_form');
        }
        ?>
        <button type="submit" class="apply"><?php _e('Apply', OSCLASSWIZARDS_THEME_FOLDER); ?></button>
      </form>
      <?php osc_alert_form(); ?>
    </div>
  </div>
</div>
