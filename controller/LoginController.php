<?php 
    session_start();
    // Redirect to login if not logged in
    if (isset($_SESSION['username'])) {
        header("Location: view/pages/Dashboard/index.php");
        exit();
    }
    require('services/LoginAccessService.php');
    // Instantiate the class to get nursery owners
    $access = new LoginAccess();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
        // Retrieve form input
        $username = $access->clean('username', 'post');
        $password = $access->clean('password', 'post');

        if (!empty($username) && !empty($password)) { 
            $status = $access->login($username,$password);
            if($status == true){
                header("Location: view/pages/Dashboard/index.php");
                exit();
            }else{
                header("Location: index.php?error=1");
            }
           
        } else {
            $error = "Please fill in both fields.";
        }
    }

?>