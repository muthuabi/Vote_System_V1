<?php
    // header("Access-Control-Allow-Origin:*");
    include_once('../connection/connection.php');
    include_once('../util_classes/Polls.php');
    
    class Ballot
    {
        private $conn=null;
        private $table1='candidates';
        private $table2='position';
        private $table3='votes';
        public $error=null;
        public function __construct($conn)
        {
            $this->conn=$conn;
        }
        public function showMaxbyPost($id)
        {
            try{
            $qry="SELECT v.candidate_id as 'max_candidate_id',v.vote as 'sum' FROM {$this->table1} as c inner join {$this->table2} as p on p.post_id=c.post_id left join {$this->table3} as v on c.candidate_id=v.candidate_id where p.post_id=? order by v.vote DESC limit 1";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("i",$id);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            return $res->fetch_assoc();
            }
            catch(Exception $e)
            {
                
                return null;
            }

        }
        public function showMaxbyPostAll()
        {
            try{
            $qry="Select op.post_id,oc.candidate_id as 'max_candidate_id',ov.vote from {$this->table1} as oc inner join {$this->table2} as op on op.post_id=oc.post_id left join {$this->table3} as ov on oc.candidate_id=ov.candidate_id  where (op.post_id,ov.vote) in (Select p.post_id,max(v.vote) FROM {$this->table1} as c inner join {$this->table2} as p on p.post_id=c.post_id left join {$this->table3} as v on c.candidate_id=v.candidate_id  group by p.post_id) order by ov.last_voted_on";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $max_post=[];
            while($result=$res->fetch_assoc())
                $max_post[$result['post_id']]=$result;
            return $max_post;
                
            }
            catch(Exception $e)
            {
                
                return null;
            }

        }
        public function totalVotesCandidatesbyPost()
        {
            try{
            $qry="SELECT p.post_id,p.post,p.post_shift ,count(c.candidate_id) as 'candidate_count',sum(v.vote) as 'total_votes' FROM {$this->table1} as c right outer join {$this->table2} as p on p.post_id=c.post_id left outer join {$this->table3} as v on c.candidate_id=v.candidate_id group by p.post_id";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $votes=[];
            while($result=$res->fetch_assoc())
            {
                $votes[]=$result;
            }
            return ['data'=>$votes,'num_rows'=>$res->num_rows];
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function showBallotAllbyPost($id)
        {
            try{
            $qry="SELECT c.*,p.*,v.vote FROM {$this->table1} as c inner join {$this->table2} as p on p.post_id=c.post_id left join {$this->table3} as v on c.candidate_id=v.candidate_id where p.post_id=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("i",$id);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $votes=[];
            while($result=$res->fetch_assoc())
            {
                $votes[]=$result;
            }
            $max=$this->showMaxbyPost($id);
            return ['data'=>$votes,'num_rows'=>$res->num_rows,'max_candidate_id'=>$max['max_candidate_id']];
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function showBallotAll()
        {
            try{
            $qry="SELECT c.*,p.*,v.vote FROM {$this->table1} as c inner join {$this->table2} as p on p.post_id=c.post_id left join {$this->table3} as v on c.candidate_id=v.candidate_id ORDER BY p.post_id,v.vote DESC,v.last_voted_on DESC";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $votes=[];
            while($result=$res->fetch_assoc())
            {
                if(empty($result['vote']))
                {
                    $result['vote']=0;
                }
                $votes[]=$result;
            }
            //print_r($votes);
            
            return ['data'=>$votes,'max_post_data'=>$this->showMaxbyPostAll(),'num_rows'=>$res->num_rows];
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }

    }
    

?>