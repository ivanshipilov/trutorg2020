<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
 Cron & alerts for myCom
 */
$path = osc_base_path();
include_once "$path/oc-includes/osclass/model/myCom.php";
include_once "$path/oc-includes/osclass/model/myCron.php";
$d_now = date('Y-m-d H:i:s');
$i_now = strtotime($d_now);
if ( ! defined('CLI')) {
    define('CLI', (PHP_SAPI==='cli'));
}

// Minutly crons
$cron = MyCron::newInstance()->getCronByType('MINUTLY');
if(is_array($cron)) {
    $i_next = strtotime($cron['d_next_exec']);

    //Alerts for new comments
    $AllComments = myCom::newInstance()->allAllComments();
    $t= MyCron::newInstance()->showLastExecTime('MINUTLY');
    foreach ($AllComments as $comment)
    {
        if ($comment['pub_date'] > $t['d_last_exec'])
        {
            osc_run_hook('hook_email_newCom', $comment);
        }
    }

    // update the next execution time in t_cron
    $d_next = date('Y-m-d H:i:s', $i_now + (60));
    MyCron::newInstance()->update(array('d_last_exec' => $d_now, 'd_next_exec' => $d_next),
        array('e_type'      => 'MINUTLY'));

    /*
        // Run cron AFTER updating the next execution time to avoid double run of cron
        $purge = osc_purge_latest_searches();
        if( $purge == 'week' ) {
            LatestSearches::newInstance()->purgeDate( date('Y-m-d H:i:s', ( time() - (7 * 24 * 3600) ) ) );
        }
        osc_run_hook('cron_weekly');
     */
}


//osc_run_hook('cron');
/* file end: ./oc-includes/osclass/cron.php */
?>