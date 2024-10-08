<?php
session_start();
require_once('../../../services/AdminService.php');

// Instantiate the class
$adminService = new AdminServices();

$error_message = '';

// Check if this is the "Create Incident" page and the latitude/longitude are provided
if (isset($_GET['lat']) && isset($_GET['long'])) {
    // Retrieve and sanitize input values
    $latitude = $_GET['lat'];
    $longitude = $_GET['long'];
    if(isset($_GET['locID'])){
        $locID = $_GET['locID'];
    }else{
        $locID = null;
    }

    //Check if There is a POST METHOD
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $title != "LocationIncident") {
        // Check if the required POST data exists before accessing it
        $patient_name = isset($_POST['patient_name']) ? $_POST['patient_name'] : null;
        $patient_age = isset($_POST['patient_age']) ? $_POST['patient_age'] : null;
        $patient_sex = isset($_POST['patient_sex']) ? $_POST['patient_sex'] : null;
        $patient_address = isset($_POST['patient_address']) ? $_POST['patient_address'] : null;
        $statusID_fk = isset($_POST['statusID']) ? $_POST['statusID'] : null;
        $complaint = isset($_POST['complaint']) ? $_POST['complaint'] : null;
        $rescuer_team = isset($_POST['rescuer_team']) ? $_POST['rescuer_team'] : null;
        $referred_hospital = isset($_POST['referred_hospital']) ? $_POST['referred_hospital'] : null;
        $incident_date = isset($_POST['incident_date']) ? $_POST['incident_date'] : null;

        // For vehicular incidents
        $isVehiclular = isset($_POST['incident_type']) && $_POST['incident_type'] === 'isVehiclular';
        $patient_classification = $isVehiclular ? (isset($_POST['patient_classification']) ? $_POST['patient_classification'] : null) : null;
        $vehicle_type = $isVehiclular ? (isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : null) : null;
        $intoxication = $isVehiclular ? (isset($_POST['intoxication']) ? $_POST['intoxication'] : null) : null;
        $helmet = $isVehiclular ? (isset($_POST['helmet']) ? $_POST['helmet'] : null) : null;
        $stray = $isVehiclular ? (isset($_POST['stray']) ? $_POST['stray'] : null) : null;

        // For other types of incidents
        $type_of_incident = !$isVehiclular ? (isset($_POST['type_of_incident']) ? $_POST['type_of_incident'] : null) : $_POST['va_type_of_incident'];
        $description = !$isVehiclular ? (isset($_POST['description']) ? $_POST['description'] : null) : $_POST['va_description'];


        //if POST Data is for Create this RUn
        if($_POST['action'] == 'createIncident'){
             // Call the service to create the incident
            $status = $adminService->createIncident(
                $latitude,
                $longitude,
                $patient_name,
                $patient_age,
                $patient_sex,
                $patient_address,
                $statusID_fk,
                $complaint,
                $rescuer_team,
                $referred_hospital,
                $incident_date,
                $isVehiclular,
                $patient_classification,
                $vehicle_type,
                $intoxication,
                $helmet,
                $stray,
                $type_of_incident,
                $description,
                $locID 
            );
            if ($status === true) {
                // Redirect to index.php after success
                header("Location: index.php");
                exit();
            } else {
                $error_message = $status;
            }
        // else if the POST Data is for Update this Run Thie need a Incident 
        }else if( $_POST['action'] == 'updateIncident'){
            if(isset($_POST['patiendID']) && isset($_POST['incidentID_fk'])){
                $patientID = $_POST['patiendID'];
                $incidentID_fk = $_POST['incidentID_fk'];
            }else{
                header("Location: update.php??PatientID=$patientID&locID=$locID&lat=$lat&long=$long");
                exit();
            }
            $status = $adminService->updateIncident( 
                $patientID,
                $incidentID_fk,
                $latitude, 
                $longitude, 
                $patient_name, 
                $patient_age, 
                $patient_sex, 
                $patient_address, 
                $statusID_fk, 
                $complaint, 
                $rescuer_team, 
                $referred_hospital, 
                $incident_date, 
                $isVehiclular, 
                $patient_classification, 
                $vehicle_type, 
                $intoxication, 
                $helmet, 
                $stray, 
                $type_of_incident, 
                $description,
                $locID
            );

            if ($status === true) {
                // Redirect to index.php after success
                header("Location: location_incident.php?locID=$locID&lat=$latitude&long=$longitude");
                exit();
            } else {
                $error_message = $status;
            }
        }      

    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'deleteIncident'){
        if(isset($_POST['incidentID'])){
            $incidentID_fk = $_POST['incidentID'];
            $status = $adminService->deleteIncidentByID($incidentID_fk);
            if ($status === true) {
                // Redirect to index.php after success
                header("Location: index.php");
                exit();
            }
        }
        
    
    }
}

?>
