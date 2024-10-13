<?php 
    include_once('../../../controller/AdminController.php');
    $owners = $adminService->getAllIncident();

    //THIS WILL SHOW A JSON DATA WHERE CONSUME BY MAP 
?>