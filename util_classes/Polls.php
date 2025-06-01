<?php
    include_once("../connection/connection.php");
    class Polls
    {
        private $conn;
        private $table='polls';
        public $poll_id=null;
        public $poll_year='';
        public $poll_status='';
        public $error=null;
        public function __construct($conn)
        {
            $this->conn=$conn;
        }
        public function delete_poll($year)
        {
            try {
                $qry = "DELETE FROM {$this->table} where poll_year=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("s", $year);
                $qry_prepare->execute();
                return $this->conn->affected_rows;
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return 0;
            }
        }
        public function insert_poll($year,$status)
        {
            try{
            $qry="Insert into {$this->table} (`poll_year`,`poll_status`) values(?,?)";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ss",$year,$status);
            return $qry_prepare->execute();
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }

        }
        public function get_status($year)
        {
            try{
            $qry="Select * from polls where poll_year=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("s",$year);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $data=$res->fetch_assoc();
            if($res->num_rows<=0)
                throw new Exception('');
            return $data;
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }
        }
        public function update_poll($year,$status)
        {
            try {
               
                $qry = "UPDATE {$this->table} SET `poll_year`=?,`poll_status`=? where poll_year=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("sss",$year,$status,$year);
                $qry_prepare->execute();
 		        if($this->conn->affected_rows> 0)
                	return $this->conn->affected_rows;
            	throw new Exception('');
                
            } catch (Exception $e) {
                $this->error=$e;
                echo $e->getMessage();
                return 0;
            }
        }
        public function init_status($year,$status)
        {
            try{
                if($this->get_status($year))
                    return $this->update_poll($year,$status);
                return $this->insert_poll($year,$status);
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }

        }
    }
    $poll=new Polls($conn);
   
?>