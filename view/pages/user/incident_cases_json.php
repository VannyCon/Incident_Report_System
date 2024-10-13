<?php 

//SHOW INCIDENT TO USER IN JSON
    include_once('../../../controller/UserController.php');
    $owners = $adminService->getAllIncident();
?>