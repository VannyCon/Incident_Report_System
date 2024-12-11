<?php
$title = "admin";

require_once('../../../controller/AdminController.php');

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../../index.php");
    exit();
}

if (!isset($_GET['baranggay'])) {
    header("Location: ../../../baranggay.php");
    exit();
}

// Get Barangay Data
$brgyDatas = $adminService->getBaranggayDatabyLocationnName($_GET['baranggay']);
require_once('../../components/header.php');
?>

<style>
    .dashboard-text {
        font-size: 35px;
        font-weight: bold;
        color: #e00909;
    }
    .dashboard-subtext {
        font-size: 15px;
        font-weight: light;
    }
</style>

<div class="container-fluid mt-2">
    <a href="baranggay_data.php" class="btn btn-outline-danger">Back</a>
    <h4>Barangay <?php echo $_GET['baranggay']?> Data</h4>
    <div class="card p-3">
        <table class="table table-bordered rounded">
            <thead class="table-primary">
                <tr class="rounded">
                    <th scope="col">Location Purok</th>
                    <th scope="col">Incident Date</th>
                    <th scope="col">Incident Time</th>
                    <th scope="col">Is Vehicular?</th>
                    <th scope="col">Incident Type</th>
                    <th scope="col">Patient Count</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are results
                if ($brgyDatas) {
                    foreach ($brgyDatas as $brgyData) {

                        $incidentDate = new DateTime($brgyData['incident_date']);
                        $formattedDate = $incidentDate->format('F j, Y');

                        // Format incident_time to 'g:i A' (e.g., 2:00 AM)
                        $incidentTime = new DateTime($brgyData['incident_time']);
                        $formattedTime = $incidentTime->format('g:i A');
                        // Display each brgyData of data
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($brgyData['location_purok']) . "</td>";
                        echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                        echo "<td>" . htmlspecialchars($formattedTime) . "</td>";
                        echo "<td>" . ($brgyData['isVehiclular'] == 1 ? "Yes" : "No") . "</td>";
                        echo "<td>" . htmlspecialchars($brgyData['type_of_incident']) . "</td>";
                        echo "<td>" . htmlspecialchars($brgyData['patient_count']) . "</td>";
                        echo "<td>" . htmlspecialchars($brgyData['description']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // If no results, display a message
                    echo "<tr><td colspan='6'>No incidents found for this Barangay.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php require_once('../../components/footer.php'); ?>
