<?php 
$title = "User";
// SHOW ALL THE INCIDENT TO USER WHICH LIMITED ONLY
    include_once('../../../controller/UserController.php');

    if (isset($_GET['locID']) && isset($_GET['lat']) && isset($_GET['long'])) {  // Change 'LocID' to 'locID'
        $LocID = $_GET['locID'];
        $lat = $_GET['lat'];
        $long = $_GET['long'];
        $incidents = $adminService->getAllIncidentByLocId($LocID);
    }
?>

<?php require_once('../../components/header.php')?>
<div class="d-flex justify-content-between mx-5 mt-5">
    <a href="index.php" class="btn btn-outline-danger">Back</a>
</div>

<div class="container mt-4">

        <div class="card">
            <div class="card-header bg-success">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title text-white"><?php echo htmlspecialchars($_GET['locName']); ?></h5>
                </div>
                
            </div>
            <div class="card-body">
                <p><strong>Purok: </strong><?php echo htmlspecialchars($_GET['locPurok']); ?> </p>
                <p><strong>Incident Count:</strong> 
                <?php 
                if (!empty($incidents)): 
                    // Remove duplicates and count incidents.
                    $uniqueIncidentIds = [];
                    foreach ($incidents as $incident) {
                        if (!in_array($incident['incident_id'], $uniqueIncidentIds)) {
                            $uniqueIncidentIds[] = $incident['incident_id'];
                        }
                    }
                    // Display the count of unique incidents.
                    echo count($uniqueIncidentIds);
                else: 
                    echo "No Incident Found.";
                    header("Location: index.php");
                    exit();
                endif; 
                ?>
                </p>
               
            </div>
        </div>


    </div>

<?php if (!empty($incidents)): ?>
    <?php foreach ($incidents as $incident): ?>
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <p class="card-title text-white"><strong>Date & Time: </strong>
                        <?php
                            $date = $incident['incident_date']; // The date from your data
                            $formattedDate = date("F j, Y", strtotime($date)); // Convert to 'October 7, 2024'
                            echo $formattedDate; // Output the formatted date
                        ?>
                        <?php
                            $time = $incident['incident_time']; // The date from your data
                            $formattedTime = date("g:i a", strtotime($time)); // Convert to '12:45 PM'
                            echo $formattedTime; // Output the formatted date
                        ?>
                    </p>
                </div>
                <div class="card-body row">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-subtitle mb-2 text-muted">Incident Type</h6>
                            <p class="card-text">
                                <strong>Type of Incident:</strong> <?= $incident['type_of_incident']; ?><br>
                                <strong>Description:</strong> <?= $incident['incident_description']; ?><br>
                                <strong>Complaint:</strong> <?= $incident['complaint']; ?><br>
                                <strong>Rescuer:</strong> <?= $incident['rescuer_team']; ?><br>
                                <strong>Referred Hospital:</strong> <?= $incident['referred_hospital']; ?> <br>
                                <strong>Patient Count:</strong> <?php echo count($incident['patients']); ?>
                            </p>

                            <?php if ($incident['isVehiclular'] == 1): ?>
                                <!-- Display Vehicular Incident Details If Applicable -->
                                <h6 class="card-subtitle mb-2 text-muted">Vehicular Incident Details</h6>
                                <p class="card-text">
                                    <strong>Patient Classification:</strong> <?= $incident['patient_classification']; ?><br>
                                    <strong>Vehicle Type:</strong> <?= $incident['vehicle_type']; ?><br>
                                    <strong>Intoxication:</strong> <?= $incident['intoxication']; ?><br>
                                    <strong>Helmet:</strong>  <?php if($incident['helmet'] == 1){
                                        echo "Yes";
                                    }else{
                                        echo "No";
                                    }; ?><br>
                                    <strong>Stray:</strong> 
                                    <?php if($incident['stray'] == 1){
                                        echo "Yes";
                                    }else{
                                        echo "No";
                                    }; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No Incident Found.</p>
    <?php 
        header("Location: index.php");
        exit();
    ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const incidentID = button.getAttribute('data-id'); // Extract info from data-* attributes
            const modalInput = deleteModal.querySelector('#incidentID');
            modalInput.value = incidentID; // Set the value of the hidden input
        });
    });
</script>

<!-- Bootstrap JS and Popper.js -->

<?php require_once('../../components/footer.php')?>
