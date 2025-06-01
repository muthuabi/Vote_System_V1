<?php
include_once('../connection/connection.php');
// Utitlity Class to Manipulae table 'position';
class Position
{
    private $conn;
    private $table = 'position';
    public $post_id = null;
    public $post = null;
    public $description = '';
    public $post_shift = null;
    public $post_status='opposed';
    public $who_can_vote='';
    public $error=null;
    public function __construct($conn)
    {
        $this->conn = $conn;
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
    public function readShiftAll($post_shift)
    {
        try {
            $qry = "Select * from {$this->table} where post_shift=?";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("s",$post_shift);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
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
    public function readShiftGenderAll($post_shift,$gender)
    {
        try {
            $qry = "Select * from {$this->table} where (post_shift=? or post_shift='Both') and (who_can_vote=? or who_can_vote='MF') and post_status!='nocontest'; ";
            $qry_prepare=$this->conn->prepare($qry);
            $qry_prepare->bind_param("ss",$post_shift,$gender);
            $qry_prepare->execute();
            $res=$qry_prepare->get_result();
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
    public function readOne($id)
    {
        try {
            $qry = "SELECT * From {$this->table} where post_id=?";
            $qry_prepare = $this->conn->prepare($qry);
            $qry_prepare->bind_param("i", $id);
            $qry_prepare->execute();
            $res = $qry_prepare->get_result();
            return $res->fetch_assoc();
        } catch (Exception $e) {
            $this->error=$e;
            echo $e->getMessage();
            return null;
        }
    }
    public function insert()
    {

        try {
            if ($this->post_shift != 'Shift-I' && $this->post_shift != 'Shift-II' && $this->post_shift != 'Both') {
                throw new Exception('Shift Shoulde be either 1 or 2');
            }
            if ($this->who_can_vote != 'M' && $this->who_can_vote != 'F' && $this->who_can_vote!='MF') {
                throw new Exception('who can vote should be MF,M or F');
            }
            $this->post=trim($this->post);
            $qry = "INSERT INTO {$this->table} (`post`,`description`,`post_shift`,`who_can_vote`,`post_status`) VALUES (?,?,?,?,?)";
            $qry_prepare = $this->conn->prepare($qry);
            $qry_prepare->bind_param("sssss", $this->post, $this->description, $this->post_shift,$this->who_can_vote,$this->post_status);
            return $qry_prepare->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->error=$e;
            return null;
        }
    }
    public function deleteOne($id)
    {
        try {
            $qry = "DELETE FROM {$this->table} where post_id=?";
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
    public function deleteAll()
    {
        try {
            $qry = "DELETE FROM {$this->table}";
            $qry_prepare = $this->conn->prepare($qry);
            $qry_prepare->execute();
            return $this->conn->affected_rows;
        } catch (Exception $e) {
            $this->error=$e;
            echo $e->getMessage();
            return 0;
        }
    }
    public function update($id)
    {
        try {
            if ($this->post_shift != 'Shift-I' && $this->post_shift != 'Shift-II' && $this->post_shift!='Both') {
                throw new Exception('Shift Shoulde be either 1 or 2');
            }
            if ($this->who_can_vote != 'M' && $this->who_can_vote != 'F' && $this->who_can_vote!='MF') {
                throw new Exception('who can vote should be MF,M or F');
            }
            $this->post=trim($this->post);
            $qry = "UPDATE {$this->table} SET `post`=?,`description`=?,`post_shift`=?,`who_can_vote`=?,`post_status`=? where post_id=?";
            $qry_prepare = $this->conn->prepare($qry);
            $qry_prepare->bind_param("sssssi", $this->post, $this->description, $this->post_shift,$this->who_can_vote,$this->post_status ,$id);
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
}
$pos = new Position($conn);
// print_r($pos->readAll());
