<?php
/*
Vote System Project for St. Xavier's College
Developed By Muthukrishnan M
Started 10 Days Before the 2024-25 Academic Year Election.
*/

error_reporting(0);
$academic_year = date('Y') . '-' . ((int)date('y') + 1);

class Connection
{
    private $db_host = '127.0.0.1';
    private $db_dbase = 'sxc_election';
    private $db_port=3306;
    //Change Port As needed
    protected $conn;

    public function __construct()
    {
        // Enable mysqli exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Primary (encoded) credentials
        $user1 = base64_decode("bXV0aHVhYmk=");
        $pass1 = base64_decode("TXV0aHUqMTIz");

        // Fallback credentials
        $user2 = 'root';
        $pass2 = '';

        try {
            // First attempt
            $this->conn = new mysqli($this->db_host, $user1, $pass1, $this->db_dbase,$this->db_port);
            $this->conn->set_charset("utf8mb4");
        } catch (mysqli_sql_exception $e1) {
            try {
                // Fallback attempt
                $this->conn = new mysqli($this->db_host, $user2, $pass2, $this->db_dbase,$this->db_port);
                $this->conn->set_charset("utf8mb4");
            } catch (mysqli_sql_exception $e2) {
                // Final failure
                die("Database Connection Failed<br>" . $e2->getMessage());
            }
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

$db = new Connection();
$conn = $db->initConnection();
define('ROOT_DIR', 'SXC_VOTE_SYSTEM/');
?>
