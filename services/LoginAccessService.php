<?php 
require_once("connection/config.php");
require_once("connection/connection.php");


class LoginAccess extends config {

    //This is the Function use to LOGIN
    public function login($username, $password){
        try {
            // Prepare and execute query to get user by username
            // If user exists and password is correct, start a session and redirect to protected page.
            // Otherwise, display an error message.
            // This is a basic example and should be replaced with more secure and robust methods.
            $query = "SELECT * FROM tbl_admin_access WHERE username = :username";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && $password === $user['password']) {
                // Password is correct, start a session
                $_SESSION['fullname'] =  $user['fullname'];
                $_SESSION['username'] = $user['username'];
                // Redirect to a protected page
                return true;
                exit();
            } else {
                $error = "Invalid username or password.";
                return false;
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
            return false;
        }
    }
    
}
?>