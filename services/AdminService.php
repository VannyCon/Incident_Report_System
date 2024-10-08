<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class AdminServices extends config {

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

    public function getAllIncidentById($LocID) {
        try {
            $query = "SELECT 
                        tbl_incident.id AS incident_id,
                        tbl_incident.incidentID_fk,
                        tbl_incident.patientID_fk,
                        tbl_incident.complaint,
                        tbl_incident.rescuer_team,
                        tbl_incident.referred_hospital,
                        tbl_incident.incident_date,
                        tbl_patient_info.patient_name,
                        tbl_patient_info.patient_age,
                        tbl_patient_info.patient_sex,
                        tbl_patient_info.patient_address,
                        tbl_incident_location.latitude,
                        tbl_incident_location.longitude,
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
                        ON tbl_incident.patientID_fk = tbl_patient_info.patientID
    
                    LEFT JOIN tbl_incident_location 
                        ON tbl_incident.locationID_fk = tbl_incident_location.locationID
    
                    LEFT JOIN tbl_patient_status 
                        ON tbl_incident.statusID_fk = tbl_patient_status.statusID
    
                    LEFT JOIN tbl_type_incident 
                        ON tbl_incident.incidentID_fk = tbl_type_incident.incidentID
    
                    LEFT JOIN tbl_vehicular_incident 
                        ON tbl_type_incident.incidentID = tbl_vehicular_incident.incidentID 
                        AND tbl_type_incident.isVehiclular = 1
    
                    WHERE tbl_incident_location.locationID = :LocID
                    
                    ORDER BY tbl_incident.incident_date DESC";
    
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->bindParam(':LocID', $LocID);  // Bind the value
            $stmt->execute(); // Execute the query
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function getPatientIncidentById($patientID) {
        try {
            $query = "SELECT 
                            pi.patientID,
                            pi.patient_name,
                            pi.patient_age,
                            pi.patient_sex,
                            pi.patient_address,
                            
                            i.incidentID_fk,
                            i.complaint,
                            i.rescuer_team,
                            i.referred_hospital,
                            i.incident_date,
                            i.statusID_fk,

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
                        INNER JOIN tbl_incident i ON pi.patientID = i.patientID_fk

                        -- Join with incident location table
                        INNER JOIN tbl_incident_location il ON i.locationID_fk = il.locationID

                        -- Join with type of incident table
                        LEFT JOIN tbl_type_incident ti ON i.incidentID_fk = ti.incidentID

                        -- Left join with vehicular incident table (optional if vehicular)
                        LEFT JOIN tbl_vehicular_incident vi ON i.incidentID_fk = vi.incidentID

                        WHERE pi.patientID = :patientID";
    
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->bindParam(':patientID', $patientID);  // Bind the value
            $stmt->execute(); // Execute the query
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    

    



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
    ) {
        try {
            // Begin the transaction
            $this->pdo->beginTransaction();
            $patientID = $this->generatePatientID();
            if($locID != null){
                $locationID = $locID;
                // Execute the fourth query
            }else{
                $locationID = $this->generateLocationID();
                $table_incident_location_query = "INSERT INTO `tbl_incident_location`(`locationID`, `latitude`, `longitude`) VALUES (:locationID, :latitude, :longitude)";
                $stmt1 = $this->pdo->prepare($table_incident_location_query);
                $stmt1->bindParam(':locationID', $locationID);
                $stmt1->bindParam(':latitude', $latitude);
                $stmt1->bindParam(':longitude', $longitude);
                $stmt1->execute();
            }
            $incidentID = $this->generateIncidentID();

            
           

            $tbl_patient_info_query = "INSERT INTO `tbl_patient_info`(`patientID`, `patient_name`, `patient_age`, `patient_sex`, `patient_address`) VALUES (:patientID, :patient_name, :patient_age, :patient_sex, :patient_address)";
            $stmt2 = $this->pdo->prepare($tbl_patient_info_query);
            $stmt2->bindParam(':patientID', $patientID);
            $stmt2->bindParam(':patient_name', $patient_name);
            $stmt2->bindParam(':patient_age', $patient_age);
            $stmt2->bindParam(':patient_sex', $patient_sex);
            $stmt2->bindParam(':patient_address', $patient_address);
            // Execute the fourth query
            $stmt2->execute();


            $incident_query = "INSERT INTO `tbl_incident`(`patientID_fk`, `locationID_fk`, `statusID_fk`, `incidentID_fk`, `complaint`, `rescuer_team`, `referred_hospital`, `incident_date`) VALUES (:patientID_fk, :locationID_fk, :statusID_fk , :incidentID_fk, :complaint, :rescuer_team, :referred_hospital, :incident_date)";

            $stmt3 = $this->pdo->prepare($incident_query);
            $stmt3->bindParam(':patientID_fk', $patientID);
            $stmt3->bindParam(':locationID_fk', $locationID);
            $stmt3->bindParam(':statusID_fk',  $statusID_fk);
            $stmt3->bindParam(':incidentID_fk', $incidentID);
            $stmt3->bindParam(':complaint', $complaint);
            $stmt3->bindParam(':rescuer_team', $rescuer_team);
            $stmt3->bindParam(':referred_hospital', $referred_hospital);
            $stmt3->bindParam(':incident_date', $incident_date);

            // Execute the fourth query
            $stmt3->execute();

            $type_of_incident_query = "INSERT INTO `tbl_type_incident`(`incidentID`, `isVehiclular`, `type_of_incident`, `description`) VALUES (:incidentID,:isVehiclular ,:type_of_incident, :description)";
            $stmt4 = $this->pdo->prepare($type_of_incident_query);
            $stmt4->bindParam(':incidentID', $incidentID);
            $stmt4->bindParam(':isVehiclular', $isVehiclular);
            $stmt4->bindParam(':type_of_incident', $type_of_incident);
            $stmt4->bindParam(':description', $description);
            // Execute the fourth query
            $stmt4->execute();

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

    // UPDATE INCIDENT
    public function updateIncident( 
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
    ) {
        try {
            // Begin the transaction
            $this->pdo->beginTransaction();
            
            if($locID != null){
                $locationID = $locID;
                // Execute the fourth query
            }else{
                $locationID = $this->generateLocationID();
                $table_incident_location_query = "INSERT INTO `tbl_incident_location`(`locationID`, `latitude`, `longitude`) VALUES (:locationID, :latitude, :longitude)";
                $stmt1 = $this->pdo->prepare($table_incident_location_query);
                $stmt1->bindParam(':locationID', $locationID);
                $stmt1->bindParam(':latitude', $latitude);
                $stmt1->bindParam(':longitude', $longitude);
                $stmt1->execute();
            }

            // Update patient info
            $update_patient_info_query = "UPDATE `tbl_patient_info` SET `patient_name` = :patient_name, `patient_age` = :patient_age, `patient_sex` = :patient_sex, `patient_address` = :patient_address WHERE `patientID` = :patientID";
            $stmt2 = $this->pdo->prepare($update_patient_info_query);
            $stmt2->bindParam(':patient_name', $patient_name);
            $stmt2->bindParam(':patient_age', $patient_age);
            $stmt2->bindParam(':patient_sex', $patient_sex);    
            $stmt2->bindParam(':patient_address', $patient_address);
            $stmt2->bindParam(':patientID', $patientID);
            $stmt2->execute();

            // Update incident
            $update_incident_query = "UPDATE `tbl_incident` SET `locationID_fk` = :locationID_fk, `statusID_fk` = :statusID_fk, `complaint` = :complaint, `rescuer_team` = :rescuer_team, `referred_hospital` = :referred_hospital, `incident_date` = :incident_date WHERE `patientID_fk` = :patientID";
            $stmt3 = $this->pdo->prepare($update_incident_query);
            $stmt3->bindParam(':locationID_fk', $locationID);
            $stmt3->bindParam(':statusID_fk', $statusID_fk);
            $stmt3->bindParam(':complaint', $complaint);
            $stmt3->bindParam(':rescuer_team', $rescuer_team);
            $stmt3->bindParam(':referred_hospital', $referred_hospital);
            $stmt3->bindParam(':incident_date', $incident_date);
            $stmt3->bindParam(':patientID', $patientID);
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
            if($isVehiclular) {  
                $update_vehicular_incident_query = "UPDATE `tbl_vehicular_incident` SET `patient_classification` = :patient_classification, `vehicle_type` = :vehicle_type, `intoxication` = :intoxication, `helmet` = :helmet, `stray` = :stray WHERE `incidentID` = :incidentID";
                $stmt5 = $this->pdo->prepare($update_vehicular_incident_query);
                $stmt5->bindParam(':patient_classification', $patient_classification);
                $stmt5->bindParam(':vehicle_type', $vehicle_type);
                $stmt5->bindParam(':intoxication', $intoxication);
                $stmt5->bindParam(':helmet', $helmet);
                $stmt5->bindParam(':stray', $stray);
                $stmt5->bindParam(':incidentID', $incidentID_fk);
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
    
    



    public function getAllIncidentInfo() {
        try {
            // SQL query with joins and conditional logic
            $query = "
                SELECT 
                    tbl_incident.id AS incident_id,
                    tbl_incident.patientID_fk,
                    tbl_patient_info.patient_name,
                    tbl_patient_info.patient_age,
                    tbl_patient_info.patient_sex,
                    tbl_patient_info.patient_address,
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
                    ON tbl_incident.statusID_fk = tbl_patient_status.statusID
    
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
    



}




?>
