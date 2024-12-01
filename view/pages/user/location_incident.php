<?php 

// SHOW ALL THE INCIDENT TO USER WHICH LIMITED ONLY
    $title = "LocationIncident";
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


<?php if (!empty($incidents)): ?>
    <?php foreach ($incidents as $incident): ?>
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Incident Detail</h5>
                </div>
                <div class="card-body row">
                    <div class="col col-12 my-3">
                        
                        <!-- Loop through each patient info -->
                        <?php 
                        // Initialize a patient counter
                        $patientCounter = 1; 

                        // Assuming each incident can have multiple patients, looping through patient info
                        foreach ($incident['patients'] as $patient): ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="text-muted"><?= $patientCounter ?>st Patient Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-md-6"> 
                                            <!-- Display Patient Information -->
                                            <p class="card-text">
                                                <strong>Patient Name:</strong> <?= $patient['patient_name']; ?><br>
                                                <strong>Age:</strong> <?= $patient['patient_age']; ?><br>
                                                <strong>Sex:</strong> <?= $patient['patient_sex']; ?><br>
                                                <strong>Address:</strong> <?= $patient['patient_address']; ?>
                                            </p>
                                        </div>
                                        <div class="col col-md-6">
                                            <h6 class="card-subtitle mb-2 text-muted">Patient Status</h6>
                                            <p class="card-text">
                                                <strong>Status Color:</strong> <?= $patient['patient_status_color']; ?><br>
                                                <strong>Description:</strong> <?= $patient['patient_status_description']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            // Increment patient counter
                            $patientCounter++; 
                            ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-subtitle mb-2 text-muted">Incident Type</h6>
                            <p class="card-text">
                                <strong>Type of Incident:</strong> <?= $incident['type_of_incident']; ?><br>
                                <strong>Description:</strong> <?= $incident['incident_description']; ?><br>
                                <strong>Complaint:</strong> <?= $incident['complaint']; ?><br>
                                <strong>Rescuer:</strong> <?= $incident['rescuer_team']; ?><br>
                                <strong>Referred Hospital:</strong> <?= $incident['referred_hospital']; ?>
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
                    <p>Incident Date: 
                        <?php
                            $date = $incident['incident_date']; // The date from your data
                            $formattedDate = date("F j, Y", strtotime($date)); // Convert to 'October 7, 2024'
                            echo $formattedDate; // Output the formatted date
                        ?>
                    </p>
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
