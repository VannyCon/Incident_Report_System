<?php
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");

class DashboardServices extends config {

    public function totalInjuries() {
        try {
            $query = "SELECT `minor`, `major`, `fatal`, `died` FROM `total_of_injuries` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $totalInjuries =  $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
        
            return $totalInjuries;// Outputs locations as JSON
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function topThreeIncident() {
        try {
            $query = "SELECT `type_of_incident`, `total_cases` FROM `top_three_incidents` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $topThree =  $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        
            return $topThree;// Outputs locations as JSON
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function monthlyAnalytic() {
        try {
            $query = "SELECT `month_name`, `incident_count` FROM `month_analytics` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $month =  $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
        
            return $month;// Outputs locations as JSON
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function yearAnalytic() {
        try {
            $query = "SELECT `incident_year`, `incident_count` FROM `past_year_analytics` WHERE 1";
            $stmt = $this->pdo->prepare($query); // Prepare the query
            $stmt->execute(); // Execute the query
            $yearlyData =  $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the result
    
            return $yearlyData; // Outputs year data as an associative array
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    



}




?>
