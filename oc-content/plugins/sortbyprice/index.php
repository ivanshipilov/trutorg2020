<?php
/*
Plugin Name: SortByPrice
Plugin URI:  http://www.mytraderoom.ru/
Description: Для сортировки предложений по цене
Version: 1.0
Author: Ivan
Author URI: http://www.mytraderoom.ru/
Plugin update URI:
*/


osc_add_hook('posted_item', 'sort_by_price');

function sort_by_price($item) {
    $itemId = $item['pk_i_id'];
    $aItem = Item::newInstance()->findByPrimaryKey($itemId);
    Session::newInstance()->_setForm('commentTitle', $title);


?>

<div class="comment">

    <h4><?php echo "проверка";

            }?>

