<?php 
    include_once('../connection/connection.php');
    // Utitlity Class to Manipulae table 'candidates';
    class Candidate
    {
        private $conn;
        private $table='candidates';
        private $file_target;
        public $candidate_id=null;
        public $regno=null;
        public $name='';
        public $course='';
        public $year=3;
        public $post_id=null;
        public $vote_count=0;
        public $image_url=null;
        public $election_year='';
        public $shift=null;
        public $error=null;
        public function __construct($conn)
        {
            $this->file_target="../assets/images/candidate_images/".date('Y')."/";
            $this->conn=$conn;
        }
        public function readAll()
        {
            try{
            $qry="Select * from {$this->table}";
            $res=$this->conn->query($qry);
            $position=[];
            while($result=$res->fetch_assoc())
            {
                $position[]=$result;
            }
            return ['data'=>$position,'num_rows'=>$res->num_rows];
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function readAllbyPost($id)
        {
            try{
            $qry="Select * from {$this->table} where post_id=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("i",$id);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $position=[];
            while($result=$res->fetch_assoc())
            {
                $position[]=$result;
            }
            return ['data'=>$position,'num_rows'=>$res->num_rows];
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function readOne($id)
        {
            try
            {
                $qry="SELECT * From {$this->table} where candidate_id=?";
                $qry_prepare=$this->conn->prepare($qry);
                $qry_prepare->bind_param("i",$id);
                $qry_prepare->execute();
                $res=$qry_prepare->get_result();
                return $res->fetch_assoc();
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        /*
        OLD ONE
        public function fileUpload($file)
        {
            try
            {
            $target=$this->file_target;
            if(!file_exists($target))
                mkdir($target,0777);
            $fname=$target.$file['name'];
            if(move_uploaded_file($file['tmp_name'],$fname))
            {
                $this->image_url=$fname;
                return $this->image_url;
            }
            }
            catch(Exception $e)
            {
                $this->error=$e;
                return null;
            }
        }
        */
        public function fileUpload($file)
        {
            try
            {
                $target = $this->file_target;
                if (!file_exists($target)) mkdir($target, 0777, true);

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $unique_name = uniqid('candidate_', true) . '.' . $ext;
                $fname = $target . $unique_name;

                if (move_uploaded_file($file['tmp_name'], $fname))
                {
                    $this->image_url = $fname;
                    return $this->image_url;
                }
            }
            catch(Exception $e)
            {
                $this->error = $e;
                return null;
            }
        }
        /*
        OLD ONE
        public function fileDelete($image_delete_url)
        {
            try{
            if(file_exists($image_delete_url))
            {
                unlink($image_delete_url);
                return true;
            }
            else 
            {
                throw new Exception('File Deletion Failed');
            }
            }
            catch(Exception $e)
            {
                return false;
            }
        }*/
        public function fileDelete($image_delete_url)
        {
        try {
            if (file_exists($image_delete_url)) {
                unlink($image_delete_url);
//             rename($image_delete_url, "trashed_" . time() . "_" . basename($image_delete_url));
                    return true;
                } else {
                    throw new Exception('File Deletion Failed');
                }
            } catch (Exception $e) {
                return false;
            }
        }


        /*
        OLD ONE
        public function fileUpdate($file)
        {
            try
            {
            $target=$this->file_target;
            if(!file_exists($target))
                mkdir($target,0777);
            $fname=$target.$file['name'];
            //$this->fileDelete($fname);
            if(move_uploaded_file($file['tmp_name'],$fname))
            {
                $this->image_url=$fname;
                return $this->image_url;
            }
            }
            catch(Exception $e)
            {
                $this->error=$e;
                return null;
            }

        }*/

        public function fileUpdate($file)
        {
            try
            {
                $target = $this->file_target;
                if (!file_exists($target)) mkdir($target, 0777, true);

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $unique_name = uniqid('candidate_', true) . '.' . $ext;
                $fname = $target . $unique_name;

                if (move_uploaded_file($file['tmp_name'], $fname))
                {
                    $this->image_url = $fname;
                    return $this->image_url;
                }
            }
            catch(Exception $e)
            {
                $this->error = $e;
                return null;
            }
        }

        public function insert()
        {
           
            try
            {
            if($this->shift!='Shift-I' && $this->shift!='Shift-II')
            {
                throw new Exception('Shift Shoulde be either 1 or 2');
            }
            $this->course=strtoupper(trim($this->course));
            $qry="INSERT INTO {$this->table} (`regno`,`name`,`shift`,`course`,`year`,`post_id`,`vote_count`,`image_url`,`election_year`) VALUES (?,?,?,?,?,?,?,?,?)";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ssssiiiss",$this->regno,$this->name,$this->shift,$this->course,$this->year,$this->post_id,$this->vote_count,$this->image_url,$this->election_year);
            return $qry_prepare->execute();
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function deleteOne($id)
        {
            try
            {
                if($val=$this->readOne($id))
                    $url=$val['image_url'];
                $qry="DELETE FROM {$this->table} where candidate_id=?";
                $qry_prepare=$this->conn->prepare($qry);
                $qry_prepare->bind_param("i",$id);
                $qry_prepare->execute();
                if($this->conn->affected_rows>0)
                {
                    $this->fileDelete($url);
                    $this->error=null;
                }
                else
                    throw new Exception("No Rows Affected");
                return $this->conn->affected_rows;
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return 0;
            }
        }
        public function deleteAll()
        {
            try
            {
                $qry="DELETE FROM {$this->table}";
                $qry_prepare=$this->conn->prepare($qry);
                $qry_prepare->execute();
                return $this->conn->affected_rows;
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return 0;
            }
        }
        public function update($id)
        {
            try{
            $this->course=strtoupper(trim($this->course));
            $qry="UPDATE {$this->table} SET `regno`=?,`name`=?,`shift`=?,`course`=?,`year`=?,`post_id`=?,`vote_count`=?,`image_url`=?,`election_year`=? where candidate_id=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ssssiiissi",$this->regno,$this->name,$this->shift,$this->course,$this->year,$this->post_id,$this->vote_count,$this->image_url,$this->election_year,$id);
            $qry_prepare->execute();
            $this->error=null;
            if($this->conn->affected_rows> 0)
                return $this->conn->affected_rows;
            throw new Exception('Update Error');
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
    }
    $can=new Candidate($conn);
   
?>
