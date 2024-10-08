<?php 
class config {
    public $pdo; // Declare $pdo as a class property

    // Corrected function to return base URL
    public function base_url(){
        require_once('config.php');
        return URL;
    }
    public function getfile(){
        require_once('config.php');
        return FILEPATH;
    }

    public function __construct(){
        require_once('config.php'); // Include config.php for DB constants
        $dsn = "mysql:host=".H.";dbname=".DB; // Corrected concatenation
        $username = U;
        $password = P;
        try {
            // Initialize PDO with correct parameters
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    function clean($data, $type) {
        $data = trim($data);
        if($type=="post") {
            //sanitize input post 
            $data = filter_input(INPUT_POST, $data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        } 
        else if($this=="get") {
            //sanitize input get
            $data = filter_input(INPUT_GET, $data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        if(is_null($data)) {
            $data="";
        }
        return $data;
    }
    function logout(){
        session_start();
        // Unset all session variables
        $_SESSION = array();
        // Destroy the session
        session_destroy();
        header("Location: index.php");
        return true;
    }
}



?>
