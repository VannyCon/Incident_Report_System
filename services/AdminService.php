<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class AdminServices extends config {

    //THis part get All the Incident which pass to map for Mapping
    public function getAllIncident() {
        try {
            $query = "SELECT `locationID_fk`, `location_count`, `latitude`, `longitude` FROM `map_incident_cases` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $locations =  $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        
            echo json_encode($locations); // Outputs locations as JSON
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Get all the information of the Specific Location this function need $LocID
    public function getAllIncidentByLocId($LocID) {
        try {
            $query = "SELECT 
                        tbl_incident.id AS incident_id,
                        tbl_incident.incidentID_fk,
                        tbl_incident.complaint,
                        tbl_incident.rescuer_team,
                        tbl_incident.referred_hospital,
                        tbl_incident.incident_date,
    
                        tbl_patient_info.patient_name,
                        tbl_patient_info.patient_birthdate,
                        tbl_patient_info.patient_age,
                        tbl_patient_info.patient_sex,
                        tbl_patient_info.patient_address,
                        tbl_patient_info.statusID,
    
                        tbl_incident_location.latitude,
                        tbl_incident_location.longitude,
                        tbl_incident_location.location_name,
                        tbl_patient_status.color AS patient_status_color,
                        tbl_patient_status.description AS patient_status_description,
                        tbl_type_incident.type_of_incident,
                        tbl_type_incident.description AS incident_description,
                        tbl_type_incident.isVehiclular,
                        
                        CASE
                            WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.patient_classification
                            ELSE NULL
                        END AS patient_classification,
                        CASE
                            WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.vehicle_type
                            ELSE NULL
                        END AS vehicle_type,
                        CASE
                            WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.intoxication
                            ELSE NULL
                        END AS intoxication,
                        CASE
                            WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.helmet
                            ELSE NULL
                        END AS helmet,
                        CASE
                            WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.stray
                            ELSE NULL
                        END AS stray
                        
                    FROM tbl_incident
    
                    LEFT JOIN tbl_patient_info 
                        ON tbl_incident.incidentID_fk = tbl_patient_info.incidentID_fk
    
                    LEFT JOIN tbl_incident_location 
                        ON tbl_incident.locationID_fk = tbl_incident_location.locationID
    
                    LEFT JOIN tbl_patient_status 
                        ON tbl_patient_info.statusID = tbl_patient_status.statusID
    
                    LEFT JOIN tbl_type_incident 
                        ON tbl_incident.incidentID_fk = tbl_type_incident.incidentID
    
                    LEFT JOIN tbl_vehicular_incident 
                        ON tbl_type_incident.incidentID = tbl_vehicular_incident.incidentID 
                        AND tbl_type_incident.isVehiclular = 1
    
                    WHERE tbl_incident_location.locationID = :LocID
    
                    ORDER BY tbl_incident.incident_date DESC";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':LocID', $LocID);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Grouping patient info by incident
            $incidents = [];
            foreach ($results as $row) {
                $incidentID = $row['incident_id'];
                if (!isset($incidents[$incidentID])) {
                    // Initialize incident information
                    $incidents[$incidentID] = [
                        'incident_id' => $row['incident_id'],
                        'incidentID_fk' => $row['incidentID_fk'],
                        'complaint' => $row['complaint'],
                        'rescuer_team' => $row['rescuer_team'],
                        'referred_hospital' => $row['referred_hospital'],
                        'incident_date' => $row['incident_date'],
                        'latitude' => $row['latitude'],
                        'longitude' => $row['longitude'],
                        'location_name' => $row['location_name'],
                        'type_of_incident' => $row['type_of_incident'],
                        'incident_description' => $row['incident_description'],
                        'isVehiclular' => $row['isVehiclular'],
                        'patient_classification' => $row['patient_classification'],
                        'vehicle_type' => $row['vehicle_type'],
                        'intoxication' => $row['intoxication'],
                        'helmet' => $row['helmet'],
                        'stray' => $row['stray'],
                        'patients' => [] // Initialize patients array
                    ];
                }
    
                // Add patient info to the patients array
                $incidents[$incidentID]['patients'][] = [
                    'patient_name' => $row['patient_name'],
                    'patient_birthdate' => $row['patient_birthdate'],
                    'patient_age' => $row['patient_age'],
                    'patient_sex' => $row['patient_sex'],
                    'patient_address' => $row['patient_address'],
                    'statusID' => $row['statusID'],
                    'patient_status_color' => $row['patient_status_color'],
                    'patient_status_description' => $row['patient_status_description'],
                ];
            }
    
            return $incidents; // Return grouped incidents with patients
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    // Get all the information of the Specific incident this function need $incidentID
    public function getIncidentById($incidentID) {
        try {
            $query = "SELECT 
                            i.incidentID_fk,
                            i.complaint,
                            i.rescuer_team,
                            i.referred_hospital,
                            i.incident_date,
    
                            il.latitude,
                            il.longitude,
    
                            ti.isVehiclular,
                            ti.type_of_incident,
                            ti.description,
                            
                            vi.patient_classification,
                            vi.vehicle_type,
                            vi.intoxication,
                            vi.helmet,
                            vi.stray
                        FROM tbl_patient_info pi
                        -- Join with incident table
                        INNER JOIN tbl_incident i ON pi.incidentID_fk = i.incidentID_fk
                        -- Join with incident location table
                        INNER JOIN tbl_incident_location il ON i.locationID_fk = il.locationID
                        -- Join with type of incident table
                        LEFT JOIN tbl_type_incident ti ON i.incidentID_fk = ti.incidentID
                        -- Left join with vehicular incident table (optional if vehicular)
                        LEFT JOIN tbl_vehicular_incident vi ON i.incidentID_fk = vi.incidentID

                        WHERE pi.incidentID_fk = :incidentID";
    
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->bindParam(':incidentID', $incidentID);  // Bind the value
            $stmt->execute(); // Execute the query
            
            $results = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch all results
            return $results; // Return all matching records
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Return an empty array on error
        }
    }

    // This part get all the patient information usiong IncidentID
    public function getIncidentPatientsById($incidentID) {
        try {
            $query = "SELECT `id`, `incidentID_fk`, `patientID`, `statusID`, `patient_name`, `patient_birthdate`, `patient_age`, `patient_sex`, `patient_address` FROM `tbl_patient_info` WHERE incidentID_fk = :incidentID";
    
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->bindParam(':incidentID', $incidentID);  // Bind the value
            $stmt->execute(); // Execute the query
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
            return $results; // Return all matching records
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Return an empty array on error
        }
    }

    // Function to generate unique patient ID
    function generatePatientID() {
        // Prefix (optional) for the patient ID (e.g., "patient-")
        $prefix = "PID-";
        
        // Get the current timestamp in microseconds
        $timestamp = microtime(true);
        
        // Generate a random number to add more uniqueness
        $randomNumber = mt_rand(100000, 999999);
        
        // Hash the timestamp and random number to create a unique identifier
        $uniqueHash = hash('sha256', $timestamp . $randomNumber);
        
        // Take the first 12 characters of the hash (or any desired length)
        $patientID = substr($uniqueHash, 0, 10);
        
        // Return the final patient ID with prefix
        return $prefix . strtoupper($patientID);
    }

    // Function to generate unique location ID
    function generateLocationID() {
        // Prefix (optional) for the patient ID (e.g., "patient-")
        $prefix = "LID-";
        
        // Get the current timestamp in microseconds
        $timestamp = microtime(true);
        
        // Generate a random number to add more uniqueness
        $randomNumber = mt_rand(100000, 999999);
        
        // Hash the timestamp and random number to create a unique identifier
        $uniqueHash = hash('sha256', $timestamp . $randomNumber);
        
        // Take the first 12 characters of the hash (or any desired length)
        $patientID = substr($uniqueHash, 0, 10);
        
        // Return the final patient ID with prefix
        return $prefix . strtoupper($patientID);
    }

    // Generate Custome Status ID
    function generateStatusID() {
        // Prefix (optional) for the patient ID (e.g., "patient-")
        $prefix = "SID-";
        
        // Get the current timestamp in microseconds
        $timestamp = microtime(true);
        
        // Generate a random number to add more uniqueness
        $randomNumber = mt_rand(100000, 999999);
        
        // Hash the timestamp and random number to create a unique identifier
        $uniqueHash = hash('sha256', $timestamp . $randomNumber);
        
        // Take the first 12 characters of the hash (or any desired length)
        $patientID = substr($uniqueHash, 0, 10);
        
        // Return the final patient ID with prefix
        return $prefix . strtoupper($patientID);
    }

    // Generate Custome Incident ID
    function generateIncidentID() {
        // Prefix (optional) for the patient ID (e.g., "patient-")
        $prefix = "IID-";
        
        // Get the current timestamp in microseconds
        $timestamp = microtime(true);
        
        // Generate a random number to add more uniqueness
        $randomNumber = mt_rand(100000, 999999);
        
        // Hash the timestamp and random number to create a unique identifier
        $uniqueHash = hash('sha256', $timestamp . $randomNumber);
        
        // Take the first 12 characters of the hash (or any desired length)
        $patientID = substr($uniqueHash, 0, 10);
        
        // Return the final patient ID with prefix
        return $prefix . strtoupper($patientID);
    }

    
    


    // CREATE PATIENT
    public function createIncident( 
        $latitude, 
        $longitude,
        $location_name, 
        $patients, //array patient info
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
    ) {
        try {
            // Begin the transaction
            $this->pdo->beginTransaction();
            $patientID = $this->generatePatientID();

            // IF Location is Not Null its mean location is already exist you want just to create then thsi will run
            if($locID != null){
                $locationID = $locID;
                // Execute the fourth query
            }else{
                //if The Location is not exist yet then this will run which mean it will create new location and User Custome LocID
                $locationID = $this->generateLocationID();
                $table_incident_location_query = "INSERT INTO `tbl_incident_location`(`locationID`,`location_name`, `latitude`, `longitude`) VALUES (:locationID,:location_name, :latitude, :longitude)";
                $stmt1 = $this->pdo->prepare($table_incident_location_query);
                $stmt1->bindParam(':locationID', $locationID);
                $stmt1->bindParam(':location_name', $location_name);
                $stmt1->bindParam(':latitude', $latitude);
                $stmt1->bindParam(':longitude', $longitude);
                $stmt1->execute();
            }

            $incidentID = $this->generateIncidentID();

            $incident_query = "INSERT INTO `tbl_incident`(`locationID_fk`, `incidentID_fk`, `complaint`, `rescuer_team`, `referred_hospital`, `incident_date`) VALUES (:locationID_fk, :incidentID_fk, :complaint, :rescuer_team, :referred_hospital, :incident_date)";

            $stmt3 = $this->pdo->prepare($incident_query);
            $stmt3->bindParam(':locationID_fk', $locationID);
            $stmt3->bindParam(':incidentID_fk', $incidentID);
            $stmt3->bindParam(':complaint', $complaint);
            $stmt3->bindParam(':rescuer_team', $rescuer_team);
            $stmt3->bindParam(':referred_hospital', $referred_hospital);
            $stmt3->bindParam(':incident_date', $incident_date);

            // Execute the fourth query
            $stmt3->execute();


            //INSERT HERE ALL THE Patient
            // Insert each patient data
            //This Part Pass Array which can Insert Multiple Data Patient Data
            foreach ($patients as $patient) {
                $patientID = $this->generatePatientID();  // Generate unique patientID for each patient
                // Insert patient info
                $tbl_patient_info_query = "INSERT INTO `tbl_patient_info`(`incidentID_fk`, `patientID`, `statusID`, `patient_name`, `patient_birthdate`, `patient_age`, `patient_sex`, `patient_address`) VALUES (:incidentID_fk, :patientID, :statusID, :patient_name, :patient_birthdate, :patient_age, :patient_sex, :patient_address)";
                $stmt2 = $this->pdo->prepare($tbl_patient_info_query);
                $stmt2->bindParam(':incidentID_fk', $incidentID);
                $stmt2->bindParam(':patientID', $patientID);
                $stmt2->bindParam(':statusID', $patient['statusID']);
                $stmt2->bindParam(':patient_name', $patient['patient_name']);
                $stmt2->bindParam(':patient_birthdate', $patient['patient_birthdate']);
                $stmt2->bindParam(':patient_age', $patient['patient_age']);
                $stmt2->bindParam(':patient_sex', $patient['patient_sex']);
                $stmt2->bindParam(':patient_address', $patient['patient_address']);
                $stmt2->execute();
            }

            // Insert Insert type of incident
            $type_of_incident_query = "INSERT INTO `tbl_type_incident`(`incidentID`, `isVehiclular`, `type_of_incident`, `description`) VALUES (:incidentID,:isVehiclular ,:type_of_incident, :description)";
            $stmt4 = $this->pdo->prepare($type_of_incident_query);
            $stmt4->bindParam(':incidentID', $incidentID);
            $stmt4->bindParam(':isVehiclular', $isVehiclular);
            $stmt4->bindParam(':type_of_incident', $type_of_incident);
            $stmt4->bindParam(':description', $description);
            // Execute the fourth query
            $stmt4->execute();

            // If the Incident is Vehiculalar then this will run else it wont create tbl_vehicular_incident
            if($isVehiclular){  
                $va_incident_query = "INSERT INTO `tbl_vehicular_incident`(`incidentID`, `patient_classification`, `vehicle_type`, `intoxication`, `helmet`, `stray`) VALUES (:incidentID, :patient_classification, :vehicle_type, :intoxication, :helmet, :stray)";
                $stmt5 = $this->pdo->prepare($va_incident_query);
                $stmt5->bindParam(':incidentID', $incidentID);
                $stmt5->bindParam(':patient_classification', $patient_classification);
                $stmt5->bindParam(':vehicle_type', $vehicle_type);
                $stmt5->bindParam(':intoxication', $intoxication);
                $stmt5->bindParam(':helmet', $helmet);
                $stmt5->bindParam(':stray', $stray);
                // Execute the fourth query
                $stmt5->execute();
            }
            // Commit the transaction
            $this->pdo->commit();

            // Return success
            return true;

        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $this->pdo->rollBack();
            
            return "Error: " . $e->getMessage();
        }
    }

    // UPDATE PATIENT
    public function updateIncident( 
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
    ) {
        try {
            // Begin the transaction
            $this->pdo->beginTransaction();
             // IF Location is Not Null its mean location is already exist you want just to create then thsi will run
            if ($locID != null) {
                $locationID = $locID;
                // Execute the fourth query
            } else {
                 //if The Location is not exist yet then this will run which mean it will create new location and User Custome LocID
                $locationID = $this->generateLocationID();
                $table_incident_location_query = "INSERT INTO `tbl_incident_location`(`locationID`, `latitude`, `longitude`) VALUES (:locationID, :latitude, :longitude)";
                $stmt1 = $this->pdo->prepare($table_incident_location_query);
                $stmt1->bindParam(':locationID', $locationID);
                $stmt1->bindParam(':latitude', $latitude);
                $stmt1->bindParam(':longitude', $longitude);
                $stmt1->execute();
            }
    
            //This Part Pass Array which can Insert Multiple Data Patient Data
            foreach ($patients as $patient) {
                // Check if the patient exists in the database
                $check_patient_query = "SELECT COUNT(*) FROM `tbl_patient_info` WHERE `patientID` = :patientID";
                $stmt_check = $this->pdo->prepare($check_patient_query);
                $stmt_check->bindParam(':patientID', $patient['patientID']);
                $stmt_check->execute();
                
                $exists = $stmt_check->fetchColumn() > 0;
                // IF patient is already exist then it will just update else it will create
                if ($exists) {
                    // Update patient info
                    $update_patient_info_query = "UPDATE `tbl_patient_info` SET `statusID` = :statusID, `patient_name` = :patient_name, `patient_birthdate` = :patient_birthdate, `patient_age` = :patient_age, `patient_sex` = :patient_sex, `patient_address` = :patient_address WHERE `patientID` = :patientID";
                    $stmt2 = $this->pdo->prepare($update_patient_info_query);
                    
                    $stmt2->bindParam(':statusID', $patient['statusID']);
                    $stmt2->bindParam(':patient_name', $patient['patient_name']);
                    $stmt2->bindParam(':patient_birthdate', $patient['patient_birthdate']);
                    $stmt2->bindParam(':patient_age', $patient['patient_age']);
                    $stmt2->bindParam(':patient_sex', $patient['patient_sex']);
                    $stmt2->bindParam(':patient_address', $patient['patient_address']);
                    $stmt2->bindParam(':patientID', $patient['patientID']);
                    $stmt2->execute();
                } else {
                    $patientID = $this->generatePatientID();
                    // Insert new patient info
                    $insert_patient_info_query = "INSERT INTO `tbl_patient_info` (`incidentID_fk`,`patientID`, `statusID`, `patient_name`, `patient_birthdate`, `patient_age`, `patient_sex`, `patient_address`) VALUES (:incidentID_fk, :patientID, :statusID, :patient_name, :patient_birthdate, :patient_age, :patient_sex, :patient_address)";
                    $stmt3 = $this->pdo->prepare($insert_patient_info_query);
                    
                    $stmt3->bindParam(':incidentID_fk', $incidentID_fk);
                    $stmt3->bindParam(':patientID', $patientID);
                    $stmt3->bindParam(':statusID', $patient['statusID']);
                    $stmt3->bindParam(':patient_name', $patient['patient_name']);
                    $stmt3->bindParam(':patient_birthdate', $patient['patient_birthdate']);
                    $stmt3->bindParam(':patient_age', $patient['patient_age']);
                    $stmt3->bindParam(':patient_sex', $patient['patient_sex']);
                    $stmt3->bindParam(':patient_address', $patient['patient_address']);
                    $stmt3->execute();
                }
            }
    
            // Update incident
            $update_incident_query = "UPDATE `tbl_incident` SET `locationID_fk` = :locationID_fk, `complaint` = :complaint, `rescuer_team` = :rescuer_team, `referred_hospital` = :referred_hospital, `incident_date` = :incident_date WHERE `incidentID_fk` = :incidentID_fk";
            $stmt3 = $this->pdo->prepare($update_incident_query);
            $stmt3->bindParam(':locationID_fk', $locationID);
            $stmt3->bindParam(':complaint', $complaint);
            $stmt3->bindParam(':rescuer_team', $rescuer_team);
            $stmt3->bindParam(':referred_hospital', $referred_hospital);
            $stmt3->bindParam(':incident_date', $incident_date);
            $stmt3->bindParam(':incidentID_fk', $incidentID_fk);
            $stmt3->execute();
    
            // Update type of incident
            $update_type_of_incident_query = "UPDATE `tbl_type_incident` SET `isVehiclular` = :isVehiclular, `type_of_incident` = :type_of_incident, `description` = :description WHERE `incidentID` = :incidentID";
            $stmt4 = $this->pdo->prepare($update_type_of_incident_query);
            $stmt4->bindParam(':isVehiclular', $isVehiclular);
            $stmt4->bindParam(':type_of_incident', $type_of_incident);
            $stmt4->bindParam(':description', $description);
            $stmt4->bindParam(':incidentID', $incidentID_fk);
            $stmt4->execute();
    
            // If vehicular, update the vehicular incident details
            if ($isVehiclular) {  
                $check_incident_query = "SELECT `incidentID` FROM `tbl_vehicular_incident` WHERE incidentID= :incidentID_fk";
                $stmt_check_incident = $this->pdo->prepare($check_incident_query); // Changed the variable name here
                $stmt_check_incident->bindParam(':incidentID_fk', $incidentID_fk);
                $stmt_check_incident->execute();
    
                $exists = $stmt_check_incident->fetchColumn() > 0;
                
                // This part if the Incident Vehiclular is then check if the Incident Is already then if exist then it will just UPDATE else if not exist then CREATE
                if ($exists) {
                    $update_vehicular_incident_query = "UPDATE `tbl_vehicular_incident` SET `patient_classification` = :patient_classification, `vehicle_type` = :vehicle_type, `intoxication` = :intoxication, `helmet` = :helmet, `stray` = :stray WHERE `incidentID` = :incidentID";
                    $stmt5 = $this->pdo->prepare($update_vehicular_incident_query);
                    $stmt5->bindParam(':patient_classification', $patient_classification);
                    $stmt5->bindParam(':vehicle_type', $vehicle_type);
                    $stmt5->bindParam(':intoxication', $intoxication);
                    $stmt5->bindParam(':helmet', $helmet);
                    $stmt5->bindParam(':stray', $stray);
                    $stmt5->bindParam(':incidentID', $incidentID_fk);
                    $stmt5->execute();
                } else {
                    $va_incident_query = "INSERT INTO `tbl_vehicular_incident`(`incidentID`, `patient_classification`, `vehicle_type`, `intoxication`, `helmet`, `stray`) VALUES (:incidentID, :patient_classification, :vehicle_type, :intoxication, :helmet, :stray)";
                    $stmt5 = $this->pdo->prepare($va_incident_query);
                    $stmt5->bindParam(':incidentID', $incidentID_fk);
                    $stmt5->bindParam(':patient_classification', $patient_classification);
                    $stmt5->bindParam(':vehicle_type', $vehicle_type);
                    $stmt5->bindParam(':intoxication', $intoxication);
                    $stmt5->bindParam(':helmet', $helmet);
                    $stmt5->bindParam(':stray', $stray);
                    $stmt5->execute();
                }
            }
    
            // Commit the transaction
            $this->pdo->commit();
    
            // Return success
            return true;
    
        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $this->pdo->rollBack();
            
            return "Error: " . $e->getMessage();
        }
    }
    

    // UPDATE INCIDENT LOCATION NAME
    public function updateBrgyLocation($locID, $location_name) {
        try {
            // Begin the transaction
            $this->pdo->beginTransaction();
                $table_incident_location_query = "UPDATE `tbl_incident_location` SET `location_name`=:location_name WHERE locationID=:locationID";
                $stmt1 = $this->pdo->prepare($table_incident_location_query);
                $stmt1->bindParam(':locationID', $locID);
                $stmt1->bindParam(':location_name', $location_name);
                $stmt1->execute();
            // Commit the transaction
            $this->pdo->commit();
            // Return success
            return true;
        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $this->pdo->rollBack();
            
            return "Error: " . $e->getMessage();
        }
    }

    //DELETE INCIDENT
    public function deleteIncidentByID($incidentID_fk) {
        try {
            // Debugging
            echo "Deleting incident with ID: " . $incidentID_fk;
    
            // Begin the transaction
            $this->pdo->beginTransaction();
            // Delete from tbl_incident first
            $delete_vehicular_incident_query = "DELETE FROM `tbl_incident` WHERE incidentID_fk = :incidentID_fk";
            $stmt1 = $this->pdo->prepare($delete_vehicular_incident_query);
            $stmt1->bindParam(':incidentID_fk', $incidentID_fk);
            $stmt1->execute();
    
            // Commit the transaction
            $this->pdo->commit();
            
            return true;
        } catch (PDOException $e) {
            // Roll back the transaction on error
            $this->pdo->rollBack();
            // Handle any errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    


    //GET ALL THE INCIDENT
    public function getAllIncidentInfo() {
        try {
            // SQL query with joins and conditional logic
            $query = "
                SELECT 
                    tbl_incident.id AS incident_id,
                    tbl_incident.patientID_fk,
                    tbl_patient_info.patient_name,
                    tbl_patient_info.patient_birthdate,
                    tbl_patient_info.patient_age,
                    tbl_patient_info.patient_sex,
                    tbl_patient_info.patient_address,
                    tbl_patient_info.statusID,
                    tbl_incident_location.latitude,
                    tbl_incident_location.longitude,
                    tbl_patient_status.color AS patient_status_color,
                    tbl_patient_status.description AS patient_status_description,
                    tbl_type_incident.type_of_incident,
                    tbl_type_incident.description AS incident_description,
                    tbl_type_incident.isVehiclular,
    
                    -- Vehicular incident details, if applicable
                    CASE
                        WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.patient_classification
                        ELSE NULL
                    END AS patient_classification,
                    CASE
                        WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.vehicle_type
                        ELSE NULL
                    END AS vehicle_type,
                    CASE
                        WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.intoxication
                        ELSE NULL
                    END AS intoxication,
                    CASE
                        WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.helmet
                        ELSE NULL
                    END AS helmet,
                    CASE
                        WHEN tbl_type_incident.isVehiclular = 1 THEN tbl_vehicular_incident.stray
                        ELSE NULL
                    END AS stray
    
                FROM tbl_incident
    
                -- Join patient info table
                LEFT JOIN tbl_patient_info 
                    ON tbl_incident.patientID_fk = tbl_patient_info.patientID
    
                -- Join location table
                LEFT JOIN tbl_incident_location 
                    ON tbl_incident.locationID_fk = tbl_incident_location.locationID
    
                -- Join patient status table
                LEFT JOIN tbl_patient_status 
                    ON tbl_patient_info.statusID = tbl_patient_status.statusID
    
                -- Join type of incident table
                LEFT JOIN tbl_type_incident 
                    ON tbl_incident.incidentID_fk = tbl_type_incident.incidentID
    
                -- Conditionally join vehicular incident table only if isVehiclular = 1
                LEFT JOIN tbl_vehicular_incident 
                    ON tbl_type_incident.incidentID = tbl_vehicular_incident.incidentID 
                    AND tbl_type_incident.isVehiclular = 1
            ";
    
            // Prepare and execute the query
            $stmt = $this->pdo->prepare($query); 
            $stmt->execute(); 
            
            // Fetch all results
            $locations = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            
            // Output results as JSON
            echo json_encode($locations); 
        } catch (PDOException $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    public function reportForMonth() {
        try {
            $query = "SELECT `barangay`, `incident_count`, `incident_types` FROM `incident_count_current_month_per_barangay_with_type` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $locations =  $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        
            return $locations;// Outputs locations as JSON
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }



}




?>
