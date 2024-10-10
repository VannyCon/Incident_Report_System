<?php 
    $title = "LocationIncident";
    include_once('../../../controller/AdminController.php');

    if (isset($_GET['locID']) && isset($_GET['lat']) && isset($_GET['long'])) {  // Change 'LocID' to 'locID'
        $LocID = $_GET['locID'];
        $lat = $_GET['lat'];
        $long = $_GET['long'];
        $incidents = $adminService->getAllIncidentByLocId($LocID);

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateLocName'){
            $location_name = isset($_POST['location_name']) ? $_POST['location_name'] : null;
            $status = $adminService->updateBrgyLocation($LocID, $location_name);
            if($status == true){
                header("Location: location_incident.php?locID=$locID&lat=$lat&long=$long");
                exit();
            }else{
                header("Location: index.php?error=1");
            }
        }
    }
?>

<?php require_once('../../components/header.php')?>
<div class="d-flex justify-content-between mx-5 mt-5">
    <a href="index.php" class="btn btn-outline-danger">Back</a>
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateLocationNameModal" data-id="<?= $incident['incidentID_fk'] ?>">
        Update Location Name
    </button>
    <a href="create.php?<?php echo "locID=$LocID&lat=$lat&long=$long"; ?>" class="btn btn-warning">Create</a>
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
                                <strong>Incident Location:</strong> <?= $incident['location_name']; ?><br>
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
                                    <strong>Helmet:</strong> <?= $incident['helmet']; ?><br>
                                    <strong>Stray:</strong> <?= $incident['stray']; ?>
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

                    <a href="update.php?IncidentID=<?= $incident['incidentID_fk']; ?>&locID=<?= $LocID ?>&lat=<?= $lat ?>&long=<?= $long ?>" class="btn btn-info">Update</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $incident['incidentID_fk'] ?>">
                        Delete
                    </button>
                </div>
            </div>
        </div>


        <!-- Update Location Name Modal -->
        <div class="modal fade" id="updateLocationNameModal" tabindex="-1" aria-labelledby="updateLocationNameModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateLocationNameModalLabel">Update Location Name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="mb-3 p-2">
                    <form id="updateLocationNameForm" method="POST" action="">
                        <label for="incidentType" class="form-label">Barangay</label>
                        <select class="form-select" id="incidentType" name="location_name" aria-label="Location">
                            <option value="Andres Bonifacio" <?= ($incident['location_name'] == 'Andres Bonifacio') ? 'selected' : '' ?>>Andres Bonifacio</option>
                            <option value="Bato" <?= ($incident['location_name'] == 'Bato') ? 'selected' : '' ?>>Bato</option>
                            <option value="Baviera" <?= ($incident['location_name'] == 'Baviera') ? 'selected' : '' ?>>Baviera</option>
                            <option value="Bulanon" <?= ($incident['location_name'] == 'Bulanon') ? 'selected' : '' ?>>Bulanon</option>
                            <option value="Campo Himoga-an" <?= ($incident['location_name'] == 'Campo Himoga-an') ? 'selected' : '' ?>>Campo Himoga-an</option>
                            <option value="Campo Santiago" <?= ($incident['location_name'] == 'Campo Santiago') ? 'selected' : '' ?>>Campo Santiago</option>
                            <option value="Colonia Divina" <?= ($incident['location_name'] == 'Colonia Divina') ? 'selected' : '' ?>>Colonia Divina</option>
                            <option value="Rafaela Barrera" <?= ($incident['location_name'] == 'Rafaela Barrera') ? 'selected' : '' ?>>Rafaela Barrera</option>
                            <option value="Fabrica" <?= ($incident['location_name'] == 'Fabrica') ? 'selected' : '' ?>>Fabrica</option>
                            <option value="General Luna" <?= ($incident['location_name'] == 'General Luna') ? 'selected' : '' ?>>General Luna</option>
                            <option value="Himoga-an Baybay" <?= ($incident['location_name'] == 'Himoga-an Baybay') ? 'selected' : '' ?>>Himoga-an Baybay</option>
                            <option value="Lopez Jaena" <?= ($incident['location_name'] == 'Lopez Jaena') ? 'selected' : '' ?>>Lopez Jaena</option>
                            <option value="Malubon" <?= ($incident['location_name'] == 'Malubon') ? 'selected' : '' ?>>Malubon</option>
                            <option value="Maquiling" <?= ($incident['location_name'] == 'Maquiling') ? 'selected' : '' ?>>Maquiling</option>
                            <option value="Molocaboc" <?= ($incident['location_name'] == 'Molocaboc') ? 'selected' : '' ?>>Molocaboc</option>
                            <option value="Old Sagay" <?= ($incident['location_name'] == 'Old Sagay') ? 'selected' : '' ?>>Old Sagay</option>
                            <option value="Paraiso" <?= ($incident['location_name'] == 'Paraiso') ? 'selected' : '' ?>>Paraiso</option>
                            <option value="Plaridel" <?= ($incident['location_name'] == 'Plaridel') ? 'selected' : '' ?>>Plaridel</option>
                            <option value="Poblacion I (Barangay 1)" <?= ($incident['location_name'] == 'Poblacion I (Barangay 1)') ? 'selected' : '' ?>>Poblacion I (Barangay 1)</option>
                            <option value="Poblacion II (Barangay 2)" <?= ($incident['location_name'] == 'Poblacion II (Barangay 2)') ? 'selected' : '' ?>>Poblacion II (Barangay 2)</option>
                            <option value="Puey" <?= ($incident['location_name'] == 'Puey') ? 'selected' : '' ?>>Puey</option>
                            <option value="Rizal" <?= ($incident['location_name'] == 'Rizal') ? 'selected' : '' ?>>Rizal</option>
                            <option value="Taba-ao" <?= ($incident['location_name'] == 'Taba-ao') ? 'selected' : '' ?>>Taba-ao</option>
                            <option value="Tadlong" <?= ($incident['location_name'] == 'Tadlong') ? 'selected' : '' ?>>Tadlong</option>
                            <option value="Vito" <?= ($incident['location_name'] == 'Vito') ? 'selected' : '' ?>>Vito</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                       
                            <input type="hidden" name="incidentID" id="incidentID">
                            <input type="hidden" name="action" value="updateLocName">
                            <button type="submit" class="btn btn-danger">Update</button>
                        </form>
                    </div>
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
