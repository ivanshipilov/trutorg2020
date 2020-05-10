<?php
    /*
    Plugin Name: SortByPrice
    Plugin URI:
    Description: плагин для сортировки по ценам
    Version: 0.1
    Author: Ivan
    Author URI:
    */

osc_register_plugin(osc_plugin_path(__FILE__), 'custom_function_call_after_install') ;

    $myplugin_prefs_table = myplugin_get_table_handle(); # в этой переменной будет содержаться имя таблицы с настройкам написанного нами плагина wordpress
    function myplugin_get_table_handle() {
        global $wpdb; # класс wordpress для работы с БД
        return $wpdb->prefix . "myplugin_preferences"; # создаём имя таблицы настроек плагина
    }
?>