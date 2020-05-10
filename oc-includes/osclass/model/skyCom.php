<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/**
 * Model database for SkyCom table
 * Created by PhpStorm.
 * User: Пользователь
 * Date: 21.06.2016
 * Time: 15:18
 */
class skyCom extends DAO
{
    private static $instance;

    /**
     * It creates a new skyCom object class ir if it has been created
     * before, it return the previous object
     *
     * @access public
     * @since unknown
     * @return ItemComment
     */
    public static function newInstance()
    {
        if( !self::$instance instanceof self ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Set data related to skyCom table
     */
    function __construct()
    {
        parent::__construct();
        $this->setTableName('skyCom');
        $this->setPrimaryKey('com_id');
        $array_fields = array(
            'com_id',
            'com_adm',
            'com_kgol',
            'com_papa',
            'com_kto',
            'com_kogda',
            'com_email',
            'com_text',
            'com_ip'
        );
        $this->setFields($array_fields);
    }

}
    