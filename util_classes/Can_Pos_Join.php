
<?php
    include_once('../connection/connection.php');
    // Utitlity Class to Manipulae table 'candidates';
    class CandidateAndPosition
    {
        private $conn;
        private $table1='candidates';
        private $table2='position';
        public $error=null;
        public function __construct($conn)
        {
            $this->conn=$conn;
        }
        public function readJoinAll()
        {
            try{
                $qry="Select * from {$this->table1} as c inner join {$this->table2} as p on p.post_id=c.post_id";
                $res=$this->conn->query($qry);
                $can_pos=[];
                while($result=$res->fetch_assoc())
                {
                    $can_pos[]=$result;
                }
                return ['data'=>$can_pos,'num_rows'=>$res->num_rows];
                }
                catch(Exception $e)
                {
                    $this->error=$e;
                    echo $e->getMessage();
                    return null;
                }
        }
        public function readJoinAllGroupbyPostId($shift,$gender)
        {
            try{
                $qry="Select * from {$this->table1} as c right outer join {$this->table2} as p on p.post_id=c.post_id where p.post_shift=? and (p.who_can_vote=? or p.who_can_vote='MF') ;";
                $qry_prepare=$this->conn->prepare($qry);
                $qry_prepare->bind_param("ss",$shift,$gender);
                $qry_prepare->execute();
                $res=$qry_prepare->get_result();
                $can_pos=[];
                while($result=$res->fetch_assoc())
                {
                    $can_pos[]=$result;
                }
                return ['data'=>$can_pos,'num_rows'=>$res->num_rows];
                }
                catch(Exception $e)
                {
                    $this->error=$e;
                    echo $e->getMessage();
                    return null;
                }
        }

    }
    $canpos=new CandidateAndPosition($conn)

    ?>