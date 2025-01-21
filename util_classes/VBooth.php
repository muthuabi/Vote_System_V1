<?php
    include_once("../connection/connection.php");
    error_reporting(E_ALL);
    class VBooth
    {
        private $conn;
        private $table='vbooth';
        public $vb_id=null;
        public $vb_name='';
        public $vb_status='';
        public $vb_location='';
        public $vb_incharge='';
        public $vb_updatedOn;
        public $error=null;
        public function __construct($conn)
        {
            $this->conn=$conn;
        }
        public function delete_booth_id($id)
        {
            try {
                $qry = "DELETE FROM {$this->table} where vb_id=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("i", $id);
                $qry_prepare->execute();
                if($this->conn->affected_rows>0)
                    $this->error=null;
                else
                    throw new Exception("No Rows Affected");
                return $this->conn->affected_rows;
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return 0;
            }
        }
        public function delete_booth_name($name)
        {
            try {
                $qry = "DELETE FROM {$this->table} where vb_name=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("s", $name);
                $qry_prepare->execute();
                if($this->conn->affected_rows>0)
                    $this->error=null;
                else
                    throw new Exception("No Rows Affected");
                return $this->conn->affected_rows;
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return 0;
            }
        }
        public function delete_all_booth()
        {   
            try {
                $qry = "DELETE FROM {$this->table}";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->execute();
                if($this->conn->affected_rows>0)
                    $this->error=null;
                else
                    throw new Exception("No Rows Affected");
                return $this->conn->affected_rows;
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->error=$e;
                return 0;
            }
        }
        public function insert_booth()
        {
            try{
            $qry="Insert into {$this->table} (`vb_name`,`vb_status`,`vb_location`,`vb_incharge`) values(?,?,?,?)";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ssss",$this->vb_name,$this->vb_status,$this->vb_location,$this->vb_incharge);
            return $qry_prepare->execute();
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }
        }
        public function update_booth_byid($id)
        {
            try{
            $qry="Update {$this->table} SET `vb_name`=?,`vb_status`=?,`vb_location`=?,`vb_incharge`=? WHERE vb_id=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ssssi",$this->vb_name,$this->vb_status,$this->vb_location,$this->vb_incharge,$id);
            $qry_prepare->execute();
            if($this->conn->affected_rows>0)
                return $this->conn->affected_rows;
            throw new Exception('No Rows Affected');
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }

        }
        public function update_booth_byname($name)
        {
            try{
            $qry="Update {$this->table} SET `vb_name`=?,`vb_status`=?,`vb_location`=?,`vb_incharge`=? WHERE vb_name=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("sssss",$this->vb_name,$this->vb_status,$this->vb_location,$this->vb_incharge,$name);
            $qry_prepare->execute();
            if($this->conn->affected_rows>0)
                return $this->conn->affected_rows;
            throw new Exception('No Rows Affected');
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }

        }
        public function readAll()
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
        public function readOne($id,$name='')
        {
            try {
                $qry = "SELECT * From {$this->table} where vb_id=? or vb_name=?";
                $qry_prepare = $this->conn->prepare($qry);
                $qry_prepare->bind_param("is", $id,$name);
                $qry_prepare->execute();
                $res = $qry_prepare->get_result();
                return $res->fetch_assoc();
            } catch (Exception $e) {
                $this->error=$e;
                echo $e->getMessage();
                return null;
            }
        }
        public function get_status($id=0,$name='')
        {
            try{
            $qry="Select vb_status,updatedOn from {$this->table} where vb_id=? or vb_name=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("is",$id,$name);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
            $data=$res->fetch_assoc();
            if($res->num_rows<=0)
                throw new Exception('No Data');
            return $data;
            }
            catch(Exception $e)
            {
                //echo $e->getMessage();
                $this->error=$e;
                return null;
            }
        }
        public function update_status($status,$id=0,$name='')
        {
            try{

            $qry="Update {$this->table} SET `vb_status`=? WHERE vb_id=? or vb_name=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("sis",$status,$id,$name);
            $qry_prepare->execute();
            if($this->conn->affected_rows>0)
                return $this->conn->affected_rows;
            throw new Exception('No Rows Affected');
            }
            catch(Exception $e)
            {
                //echo $e->getMessage();
                $this->error=$e;
                return null;
            }
        }
        public function init_status($id=0,$name='')
        {
            try{
                if($this->get_status($id,$name))
                    return $this->update_status($status,$id,$name);
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                $this->error=$e;
                return null;
            }

        }
    }
    $vb=new VBooth($conn);   
?>