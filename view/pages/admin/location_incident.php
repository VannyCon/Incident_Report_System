<?php 
    $title = "LocationIncident";
    include_once('../../../controller/AdminController.php');
    if (isset($_GET['locID']) && isset($_GET['lat']) && isset($_GET['long'])) {  // Change 'LocID' to 'locID'
        $LocID = $_GET['locID'];
        $lat = $_GET['lat'];
        $long = $_GET['long'];
        $incidents = $adminService->getAllIncidentById($LocID);
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
</head>
<body>
<div class="d-flex justify-content-between mx-5 mt-5">
    <a href="index.php" class="btn btn-outline-danger ">Back</a>
    <a href="create.php?<?php echo "locID=$LocID&lat=$lat&long=$long"; ?>" class="btn btn-warning ">Create</a>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this incident? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    <input type="hidden" name="incidentID" id="incidentID">
                    <input type="hidden" name="action" value="deleteIncident">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php if (!empty($incidents)): ?>
    <?php foreach ($incidents as $incident): ?>
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Incident Detail</h5>
                </div>
                <div class="card-body row">
                    <div class="row">
                        <div class="col col-md-6"> 
                            <!-- Display Incident Information -->
                            <h6 class="card-subtitle mb-2 text-muted">Patient Information</h6>
                            <p class="card-text">
                                <strong>Patient Name:</strong> <?php echo $incident['patient_name']; ?><br>
                                <strong>Age:</strong> <?php echo $incident['patient_age']; ?><br>
                                <strong>Sex:</strong> <?php echo $incident['patient_sex']; ?><br>
                                <strong>Address:</strong> <?php echo $incident['patient_address']; ?>
                            </p>
                        </div>
                        <div class="col col-md-6">
                            <h6 class="card-subtitle mb-2 text-muted">Patient Status</h6>
                            <p class="card-text">
                                <strong>Status Color:</strong> <?php echo $incident['patient_status_color']; ?><br>
                                <strong>Description:</strong> <?php echo $incident['patient_status_description']; ?>
                            </p>
                        </div>
                    </div>
                  
                   
                    <div class="row">
                        <div class="col-12">
                        <h6 class="card-subtitle mb-2 text-muted">Incident Type</h6>
                        <p class="card-text">
                            <strong>Type of Incident:</strong> <?php echo $incident['type_of_incident']; ?><br>
                            <strong>Description:</strong> <?php echo $incident['incident_description']; ?><br>
                            <strong>Complaint:</strong> <?php echo $incident['complaint']; ?><br>
                            <strong>Rescuer:</strong> <?php echo $incident['complaint']; ?><br>
                            <strong>Reffered Hospital:</strong> <?php echo $incident['complaint']; ?>
                        </p>

                        <?php if ($incident['isVehiclular'] == 1): ?>
                            <!-- Display Vehicular Incident Details If Applicable -->
                            <h6 class="card-subtitle mb-2 text-muted">Vehicular Incident Details</h6>
                            <p class="card-text">
                                <strong>Patient Classification:</strong> <?php echo $incident['patient_classification']; ?><br>
                                <strong>Vehicle Type:</strong> <?php echo $incident['vehicle_type']; ?><br>
                                <strong>Intoxication:</strong> <?php echo $incident['intoxication']; ?><br>
                                <strong>Helmet:</strong> <?php echo $incident['helmet']; ?><br>
                                <strong>Stray:</strong> <?php echo $incident['stray']; ?>
                            </p>
                        <?php endif; ?>

                        </div>
                       
                    </div>
                  

                   
                </div>
                <div class="card-footer text-muted">
                <p>Incident Date: <?php
                                        $date = $incident['incident_date']; // The date from your data (2024-10-07)
                                        $formattedDate = date("F j, Y", strtotime($date)); // Convert to 'October 7, 2024'
                                        echo $formattedDate; // Output the formatted date
                                    ?></p>

                <a href="update.php?PatientID=<?php echo $incident['patientID_fk']; ?>&locID=<?php echo $locID ?>&lat=<?php echo $lat?>&long=<?php echo $long?>" class="btn btn-info">Update</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $incident['incidentID_fk'] ?>">
                    Delete
                </button>
                </div>
            </div>
        </div>
        </div>
                  <?php endforeach; ?>
              <?php else: ?>
                  <p>No  Incident Found. </p>
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
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>