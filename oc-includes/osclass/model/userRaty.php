<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
Copy from ItemComment table description
 */

    /**
     * Model database for os_t_rating table
     *
     */
    class userRaty extends DAO
    {
        /**
         * It references to self object: userRaty.
         * It is used as a singleton
         *
         * @access private
         * @since unknown
         * @var Item
         */
        private static $instance;

        /**
         * It creates a new userRaty object class ir if it has been created
         * before, it return the previous object
         *
         * @access public
         * @since unknown
         * @return userRaty
         */
        public static function newInstance()
        {
            if (!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         * Set data related to t_item_comment table
         */
        function __construct()
        {
            parent::__construct();
            $this->setTableName('t_rating');
            $this->setPrimaryKey('r_id');
            $array_fields = array(
                'r_id',
                'r_pub_date',
                'id_executor',
                'r_executor',
                'r_rating',
                'r_comment',
                'r_of_user',
                'r_user_name'
            );
            $this->setFields($array_fields);
        }

        /**
         * Searches for comments information, given an item id.
         *
         * @access public
         * @since unknown
         * @param integer $id
         * @return array
         */
        function findByItemIDAll($id)
        {
            $this->dao->select();
            $this->dao->from($this->getTableName());
            $this->dao->where('r_id', $id);
            $result = $this->dao->get();

            if ($result == false) {
                return array();
            }

            return $result->result();
        }

        /**
         * Count the number of comments
         *
         * @param int item's ID or null
         * @return int
        **/
        public function count($userId = null) {
            $this->dao->select('COUNT(*) AS numrows');
            $this->dao->from($this->getTableName());

            $this->dao->where('id_executor',$userId);
            $aux = $this->dao->get();
            if($aux == false) {
                return array();
            }
            $row = $aux->row();
            return $row['numrows'];
        }

        /**
         * Count the middle rating
         *
         * @param int item's ID or null
         * @return int
         **/

        function totalRating($id)
        {
            $rating = 0;
            $this->dao->select('r_rating',$rating);
            $this->dao->from($this->getTableName());
            $this->dao->where('id_executor', $id);
            $result = $this->dao->get();

            if ($result == false) {
                return array();
            }
            $allRatings = $result->result();
            $ratings = array();
            foreach ($allRatings as $rat){
                array_push($ratings,$rat['r_rating']);}
                if (count($ratings)>0)
                $totalRating=array_sum($ratings)/count($ratings);
            return $totalRating;
        }

        function checking($loggedUserId) //для проверки, оставлял ли уже этот пользователь оценку этому исполнителю
        {
            $this->dao->select('r_of_user');
            $this->dao->from($this->getTableName());
            $this->dao->where('r_of_user', $loggedUserId);
            $result = $this->dao->get();
            $checking = $result->result();
            if (empty($checking))
                return 1; // пользователь еще не оценивал текущего юзера
            else
                return 0; // пользователь уже оценивал текущего юзера
        }

    function scoreOfLoggedUser($loggedUserId, $currentUser)
    {
        $this->dao->select('r_rating');
        $this->dao->from($this->getTableName());
        $conditions = array('r_of_user'   => $loggedUserId,
            'id_executor' => $currentUser);
        $this->dao->where($conditions);
        $result = $this->dao->get();
        $resArr = $result->result();
        if (empty($resArr))
            return 0;
        else
            $score=$resArr['0'];
        return $score['r_rating'];
    }

    function commentOfLoggedUser($loggedUserId)
    {
        $this->dao->select('r_comment');
        $this->dao->from($this->getTableName());
        $this->dao->where('r_of_user', $loggedUserId);
        $result = $this->dao->get();
        $resArr = $result->result();
        if (empty($resArr))
            return 0;
        else
            $comment=$resArr['0'];
        return $comment['r_comment'];
    }

    function commentOfLoggedUserforCurrentUser($loggedUserId,$currentUser)
    {
        $this->dao->select('r_comment');
        $this->dao->from($this->getTableName());
        $conditions = array('r_of_user'   => $loggedUserId,
            'id_executor'  => $currentUser);
        $this->dao->where($conditions);
        $result = $this->dao->get();
        $resArr = $result->result();
        if (empty($resArr))
            return 0;
        else
            $comment=$resArr['0'];
        return $comment['r_comment'];
    }

        function Allcomment($id)
        {
            $this->dao->select('r_comment');
            $this->dao->from($this->getTableName());
            $this->dao->where('id_executor', $id);
            $result = $this->dao->get();
            $resArr = $result->result();
            if (empty($resArr))
                return 0;
            else
                $AllComments = array();
            foreach ($resArr as $comments)
                array_push($AllComments,$comments['r_comment']);
            return $AllComments;
        }


    function AllUsersId($id)
    {
        $this->dao->select('r_of_user');
        $this->dao->from($this->getTableName());
        $this->dao->where('id_executor', $id);
        $result = $this->dao->get();
        $resArr = $result->result();
        if (empty($resArr))
            return 0;
        else
            $AllusersIds = array();
        foreach ($resArr as $users)
            array_push($AllusersIds,$users['r_of_user']);
        return $AllusersIds;
    }

        function AllUsers($id)
        {
            $this->dao->select('r_user_name');
            $this->dao->from($this->getTableName());
            $this->dao->where('id_executor', $id);
            $result = $this->dao->get();
            $resArr = $result->result();
            if (empty($resArr))
                return 0;
            else
                $Allusers = array();
                foreach ($resArr as $users)
                    array_push($Allusers,$users['r_user_name']);
            return $Allusers;
        }
    }



?>