<?php

    include_once("../connection/connection.php");
    class Admin
    {
        private $conn;
        private $table='admin';
        private $old_table='old_data_table';
        public $name='';
        public $username='';
        public $password='';
        public $email='';
        public $role='viewer';
        public $error=null;
        public function __construct($conn)
        {
            $this->conn=$conn;
        }

        public function migrate_table()
        {
            try{
            $qry="INSERT INTO {$this->old_table}(`regno`,`post_with_shift`,`votes`,`election_year`) SELECT c.regno,CONCAT(p.post,' ',p.post_shift),v.vote,c.election_year from candidates as c inner join position as p on p.post_id=c.post_id left join votes as v on c.candidate_id=v.candidate_id";
            $qry_prepare=$this->conn->prepare($qry);
            return $qry_prepare->execute();
            }
            catch(Exception $e)
            {
                $this->error=$e;
                return null;
            }
        }
        public function read_migrate_data()
        {
            try {
                $qry = "Select * from {$this->old_table}";
                $res = $this->conn->query($qry);
                $position = [];
                while ($result = $res->fetch_assoc()) {
                    $position[] = $result;
                }
                return ['data' => $position, 'num_rows' => $res->num_rows];
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }
        }
        public function read_admin_All()
        {
            try {
                $qry = "Select * from {$this->table}";
                $res = $this->conn->query($qry);
                $position = [];
                while ($result = $res->fetch_assoc()) {
                    $position[] = $result;
                }
                return ['data' => $position, 'num_rows' => $res->num_rows];
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }
        }
        public function read_admin_one($username)
        {
            try
            {
            $qry="Select * from {$this->table} where username=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("s",$username);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $data=$res->fetch_assoc();
            if($res->num_rows==0)
                throw new Exception('Not Valid');
            return $data;
            }
            catch(Exception $e)
            {
                $this->error=$e;
                return null;
            }

        }
        public function validate_admin($username,$password)
        {
            //$password=base64_encode($password);
            $password=hash('sha256',$password);
            try
            {
            $qry="Select * from {$this->table} where username=? and password=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ss",$username,$password);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $data=$res->fetch_assoc();
            if($res->num_rows==0)
                throw new Exception('Not Valid');
            return $data;
            }
            catch(Exception $e)
            {
                $this->error=$e;
                return null;
            }

        }
        public function delete_table_contents($table_name)
        {
            try
            {
            if($table_name=='admin')
                throw new Exception('Access Denied to Delete Admin Table Contents');
            $qry="DELETE FROM {$table_name}";
            $qry_prepare=$this->conn->prepare($qry);
            return $qry_prepare->execute();
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }
            
        }
        public function change_admin_password($new_pass,$username)
        {
            //$new_pass=base64_encode($new_pass);
            $new_pass=hash('sha256',$new_pass);
            try{
            $qry="UPDATE {$this->table} SET password=?  where username=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ss",$new_pass,$username);
            $qry_prepare->execute();
            if(!$this->conn->affected_rows)
                return true;                
            }
            catch(Exception $e)
            {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function update_admin_no_pass($username)
        {
            //echo (int)$pass_change;
            //$this->password=hash('sha256',$this->password);
            try {
                
                $qry = "UPDATE {$this->table} SET `username`=?,`name`=?,`email`=?,`role`=? where username=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("sssss", $this->username, $this->name,$this->email,$this->role,$username);
                $qry_prepare->execute();
 		        if($this->conn->affected_rows> 0)
                	return $this->conn->affected_rows;
            	throw new Exception('Update Error or No Rows Affected');
                
            } catch (Exception $e) {
                $this->error=$e;
                echo $e->getMessage();
                return 0;
            }
        }
        public function update_admin($username)
        {
            //echo (int)$pass_change;
            $this->password=hash('sha256',$this->password);
            try {
                
                $qry = "UPDATE {$this->table} SET `username`=?,`name`=?,`password`=?,`email`=?,`role`=? where username=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("ssssss", $this->username, $this->name, $this->password,$this->email,$this->role,$username);
                $qry_prepare->execute();
 		        if($this->conn->affected_rows> 0)
                	return $this->conn->affected_rows;
            	throw new Exception('Update Error or No Rows Affected');
                
            } catch (Exception $e) {
                $this->error=$e;
                echo $e->getMessage();
                return 0;
            }
        }

        /*
            CHECK THIS UPDATE FUNCTION ASAP!
                   public function update_admin($username,$pass_change)
        {
            
            try {
                $qry = "UPDATE {$this->table} SET `username`=?,`name`=?,`email`=?,`role`=? where username=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("ssssss", $this->username, $this->name,$this->email,$this->role,$username);
                if($pass_change)
                {
                    $this->password=hash('sha256',$this->password);
                    $qry = "UPDATE {$this->table} SET `username`=?,`name`=?,`password`=?,`email`=?,`role`=? where username=?";
                    $qry_prepare = $this->conn->prepare($qry);
                    $qry_prepare->bind_param("ssssss", $this->username, $this->name, $this->password,$this->email,$this->role,$username);
                }
                $qry_prepare->execute();
                if($this->conn->affected_rows> 0)
                    return $this->conn->affected_rows;
                throw new Exception('Update Error');
                
            } catch (Exception $e) {
                $this->error=$e;
                echo $e->getMessage();
                return 0;
            }
        }

        */
        public function delete_admin($username)
        {
            try {
                $qry = "DELETE FROM {$this->table} where username=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("s", $username);
                $qry_prepare->execute();
                return $this->conn->affected_rows;
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return 0;
            }
        }
        public function insert_admin()
        {
            $this->password=hash('sha256',$this->password);
            try
            {
            $qry="Insert Into {$this->table}(`username`,`name`,`password`,`email`,`role`) VALUES(?,?,?,?,?)";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("sssss",$this->username,$this->name,$this->password,$this->email,$this->role);
            return $qry_prepare->execute();
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }

        }

    }
    $admin=new Admin($conn);
    
    // $admin->change_admin_password('1234565','muthuabi');
?>