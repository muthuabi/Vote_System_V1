<?php
/*
Vote System Project for St. Xavier's College
Developed By Muthukrishnan M
Started 10 Days Before the 2024-25 Academic Year Election.
*/
$academic_year=date('Y').'-'.((int)date('y')+1);
class Connection
{
    private $db_host='127.0.0.1';
  /* 
   In mobile Termux the host expects the Local Ip so i changed as direct ip ... in lap/system we can use localhost directly 
*/
    private $db_user='root';
    private $db_password='';
    private $db_dbase='sxc_election';
    // public $err=null;
    protected $conn;
    public function __construct()
    {
        try{
        // If any error occurs regarding Database Connection failure
        // Comment the Below two Lines of Codes
		$this->db_user=base64_decode("bXV0aHVhYmk=");
		$this->db_password=base64_decode("TXV0aHUqMTIz");
        $this->conn=new mysqli($this->db_host,$this->db_user,$this->db_password,$this->db_dbase);
        if($this->conn->connect_error)
            throw new Exception('Database Connection Failed');
        }
        catch(Exception $e)
        {
            echo $this->conn->connect_error;
            die("<br>Database Connection Failure");
        }

    }
    public function initConnection()
    {
        return $this->conn;
    }
    public function closeConnection()
    {
        $this->conn->close();
        return $this->conn;
    }

}
$db=new Connection();
$conn=$db->initConnection();
define('ROOT_DIR','SXC_VOTE_SYSTEM/');
?>
