<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23.04.2016
 * Time: 11:39

if(isset($_POST['score'])) {
    header("Content-type: text/txt; charset=UTF-8");
    if($_POST['score']>'0') {
        echo "score =".$_POST['score'];
        echo "исполнитель =".$_POST['executor'];
        echo "оценку поставил =".$_POST['r_of_user'];
        echo $_POST['r_pub_date']." числа";
    }
    else {
        echo 'карявый POST запрос';
    }
}
        ;$path = $_SERVER['DOCUMENT_ROOT'] . '/doska';

//include_once "$path./oc-includes/osclass/classes/database/DAO.php";
//include_once "$path./oc-includes/osclass/model/SiteInfo.php";
//include_once "$path./oc-includes/osclass/helpers/hDatabaseInfo.php";
//include_once "$path./oc-includes/osclass/classes/database/DBCommandClass.php";
//include_once "$path./oc-includes/osclass/classes/database/DBConnectionClass.php";

//include_once "$path./oc-includes/osclass/model/userRaty.php";




        $executor = $_POST['executor'];
        $rating = $_POST['score'];
        $userId = $_POST['r_of_user'];
        $r_pub_date = $_POST['r_pub_date'];

        $mRaty = userRaty::newInstance();


//$strSQL = "INSERT INTO oc_t_rating(r_pub_date,r_executor,r_rating,r_of_user) VALUES('$r_pub_date','$executor','$rating',' $userId')";
//mysql_query($strSQL) or die(mysql_error());

         $aRaty = array(
          'r_pub_date' => date('Y-m-d H:i:s')
        , 'r_executor' => $executor
        , 'r_rating' => $rating
        , 'r_of_user' => $userId)
        //,'r_id'           => $ratyId
        //,'r_comment'      => $rComment
        ;
        if ($mRaty->insert($aRaty)) {
            $ratyID = $mRaty->dao->insertedId();
        }

 */
?>

        
    
