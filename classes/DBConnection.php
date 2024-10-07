/**
 * Class DBConnection
 * 
 * This class establishes a connection to the database using MySQLi.
 * It initializes the connection in the constructor and closes it in the destructor.
 * 
 * @package CRM\classes
 * 
 * @property string $host The database server host.
 * @property string $username The database username.
 * @property string $password The database password.
 * @property string $database The database name.
 * @property mysqli $conn The MySQLi connection object.
 * 
 * @method __construct() Initializes the database connection.
 * @method __destruct() Closes the database connection.
 */
<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection{

    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    
    public $conn;
    
    public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
    }
    public function __destruct(){
        $this->conn->close();
    }
}
?>