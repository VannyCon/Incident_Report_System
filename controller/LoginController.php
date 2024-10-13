<?php 
    session_start();
    // Redirect to login if not logged in
    if (isset($_SESSION['username'])) {
        header("Location: view/pages/admin/index.php");
        exit();
    }
    require('services/LoginAccessService.php');
    // Instantiate the class LoginAccess to Get Services
    $access = new LoginAccess();

    // Check if the action is login                   
    // <input type="hidden" name="action" value="login">
    // if POST is the request method ata the sametime the action is login then this will run
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
        // Retrieve form input
        // Santize the Username and password to avoid scripting
        $username = $access->clean('username', 'post');
        $password = $access->clean('password', 'post');

        // Check if username and password is exist
        if (!empty($username) && !empty($password)) { 
            // username and password is exist then pass to login function from services
            $status = $access->login($username,$password);
            // if status is true then go to admin index
            if($status == true){
                header("Location: view/pages/admin/index.php");
                exit();
            }else{
                header("Location: index.php?error=1");
            }
           
        } else {
            $error = "Please fill in both fields.";
        }
    }

?>