<?php
session_start();
// import Admin services
require_once('../../../services/AdminService.php');
require_once('../../../services/DashboardService.php');



// check if the admin is already log in then it will go to index.php
if (!isset($_SESSION['username'])) {
    header("Location: ../../../index.php");
    exit();
}

// Instantiate the class from require_once('../../../services/DashboardService.php');
$adminService = new AdminServices();

$error_message = '';


// Check if this is the "Create Incident" page and the latitude/longitude are provided
if (isset($_GET['lat']) && isset($_GET['long'])) {
    // Retrieve and sanitize input values
    $latitude = $_GET['lat'];
    $longitude = $_GET['long'];

    // if Loc ID is already exist then it will use that since the location is already exist else throw null because if null the $locID then the Service create new location.
    if(isset($_GET['locID'])){
        $locID = $_GET['locID'];
    }else{
        $locID = null;
    }

    //Check if There is a POST METHOD
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $title != "LocationIncident") {

        // Patient ID,patient Name, Patient Birthdate, patient_age, patient_sex, patient_address,statusID are put in This array $patients = []; because it allow you to create multiple patient when its own information
        $patients = [];

        // Check if all the $_POST need to create is exist else it wont have array of Patient
        if (isset($_POST['patient_name'], $_POST['patient_birthdate'], $_POST['patient_age'], $_POST['patient_sex'], $_POST['patient_address'], $_POST['statusID'])) {
            // Iterate over the number of patients based on one of the fields (assuming they are all the same length)
            for ($i = 0; $i < count($_POST['patient_name']); $i++) {
                $patients[] = [
                    'patientID' => $_POST['patientID'][$i],
                    'patient_name' => $_POST['patient_name'][$i],
                    'patient_birthdate' => $_POST['patient_birthdate'][$i],
                    'patient_age' => $_POST['patient_age'][$i],
                    'patient_sex' => $_POST['patient_sex'][$i],
                    'patient_address' => $_POST['patient_address'][$i],
                    'statusID' => $_POST['statusID'][$i]
                ];
            }
        }


        // This are the things pass to database to create a Info ALL POST on this part is shared so its mean Create Function and Update Function Use $_POST since they have a same argument also to Perform DRY Principle
        $location_name = isset($_POST['location_name']) ? $_POST['location_name'] : null;
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


        // If Action is createIncident , this located to FORM           
        // <input type="hidden" name="action" value="createIncident">
        // If this Exist on Form then it will RUN this FUnction createIncident() 
        if($_POST['action'] == 'createIncident'){
             // Call the service to create the incident
            $status = $adminService->createIncident(
                $latitude,
                $longitude,
                $location_name,
                $patients,
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
            // If status is true then go to map.php else throw error
            if ($status === true) {
                // Redirect to map.php after success
                header("Location: map.php");
                exit();
            } else {
                $error_message = $status;
            }
        
        // If Action is updateIncident , this located to FORM           
        // <input type="hidden" name="action" value="updateIncident">
        // If this Exist on Form then it will RUN this FUnction updateIncident() 
        }else if( $_POST['action'] == 'updateIncident'){
            if(isset($_POST['incidentID_fk'])){
                $incidentID_fk = $_POST['incidentID_fk'];
            }else{
                header("Location: update.php??PatientID=$patientID&locID=$locID&lat=$lat&long=$long");
                exit();
            }
            $status = $adminService->updateIncident( 
                $incidentID_fk,
                $latitude, 
                $longitude, 
                $patients,
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
                // Redirect to map.php after success
                header("Location: location_incident.php?locID=$locID&lat=$latitude&long=$longitude");
                exit();
            } else {
                $error_message = $status;
            }
        }      
        // If Action is deleteIncident , this located to FORM           
        // <input type="hidden" name="action" value="deleteIncident">
        // If this Exist on Form then it will RUN this FUnction deleteIncident() 
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'deleteIncident'){
        if(isset($_POST['incidentID'])){
            $incidentID_fk = $_POST['incidentID'];
            $status = $adminService->deleteIncidentByID($incidentID_fk);
            if ($status === true) {
                // Redirect to map.php after success
                header("Location: map.php");
                exit();
            }
        }
        
    
    }
}

?>
