<?php 
    require_once('../../../connection/connection.php');
    $access = new config();
    // this is the part will pass the Log out which from config() located
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'logout') {
        $status = $access->logout();
        if($status == true){
            header("Location: ../../../index.php");
            exit();
        }else{
            header("Location: index.php?error=1");
        }
    }
?>