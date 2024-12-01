<?php 
    $title = "LocationIncident";
    include_once('../../../controller/AdminController.php');


    //YOU WILL FIND HERE THE INFORMATION OF THE LOCATION INCIDENT IF HOW MANY ACCESS ON THE SPECIFC AREA
    if (isset($_GET['locID']) && isset($_GET['lat']) && isset($_GET['long'])) {  // Change 'LocID' to 'locID'
        $LocID = $_GET['locID'];
        $lat = $_GET['lat'];
        $long = $_GET['long'];
        $incidents = $adminService->getAllIncidentByLocId($LocID);

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateLocName'){
            $location_name = isset($_POST['location_name']) ? $_POST['location_name'] : null;
            $location_purok = isset($_POST['location_purok']) ? $_POST['location_purok'] : null;
            $status = $adminService->updateBrgyLocation($LocID, $location_name, $location_purok);
            if($status == true){
                header("Location: location_incident.php?locID=$locID&lat=$lat&long=$long&locName=$location_name&locPurok=$location_purok");
                exit();
            }else{
                header("Location: index.php?error=1");
            }
        }
    }
?>

<?php require_once('../../components/header.php')?>
<div class="d-flex justify-content-between mx-5 mt-5">
    <a href="map.php" class="btn btn-outline-danger">Back</a>
    <button type="button" class="btn btn-info" 
            data-bs-toggle="modal" 
            data-bs-target="#updateLocationNameModal" 
            data-location-name="<?= $_GET['locName'] ?>" 
            data-location-purok="<?= $_GET['locPurok'] ?>">
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
    <div class="container mt-4">

        <div class="card">
            <div class="card-header bg-success">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title text-white"><?php echo htmlspecialchars($_GET['locName']); ?></h5>
                    <a href="baranggay_incident.php?baranggay=<?php echo htmlspecialchars($_GET['locName']); ?>" class="btn btn-primary">Check</a>
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
                    <small>Incident Details</small>
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
                                                <strong>Birthdate:</strong> <?= $patient['patient_birthdate']; ?><br>
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
                                    <strong>Helmet:</strong> 
                                    <?php if($incident['helmet'] == 1){
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
                   
                    <a href="update.php?IncidentID=<?= $incident['incidentID_fk']; ?>&locID=<?= $LocID ?>&lat=<?= $lat ?>&long=<?= $long ?>&locName=<?=$_GET['locName'] ?>&locPurok=<?=$_GET['locPurok'] ?>" class="btn btn-info">Update</a>
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
                                <div class="mb-3">
                                    <label for="barangay" class="form-label">Barangay</label>
                                    <select class="form-select" id="barangay" name="location_name" aria-label="Barangay">
                                        <option value="" selected disabled>Choose a Barangay</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="purok" class="form-label">Purok</label>
                                    <select class="form-select" id="purok" name="location_purok" aria-label="Purok" disabled>
                                        <option value="" selected disabled>Choose a Purok</option>
                                    </select>
                                </div>
                                <input type="hidden" name="incidentID" id="incidentID">
                                <input type="hidden" name="action" value="updateLocName">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
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

document.addEventListener('DOMContentLoaded', () => {
    const updateLocationNameModal = document.getElementById('updateLocationNameModal');

    // Handle modal show event
    updateLocationNameModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget; // Button that triggered the modal
        const incidentID = button.getAttribute('data-id');
        const locationName = button.getAttribute('data-location-name');
        const locationPurok = button.getAttribute('data-location-purok');

        const barangaySelect = updateLocationNameModal.querySelector('#barangay');
        const purokSelect = updateLocationNameModal.querySelector('#purok');
        const incidentIDInput = updateLocationNameModal.querySelector('#incidentID');

        // Set the hidden input for incident ID
        incidentIDInput.value = incidentID;

        // Preselect the Barangay
        barangaySelect.value = locationName;

        // Fetch the JSON file for barangays and puroks
        fetch('barangay_purok.json')
            .then(response => response.json())
            .then(data => {
                // Populate Barangay dropdown
                barangaySelect.innerHTML = '<option value="" selected disabled>Choose a Barangay</option>';
                for (const barangay in data) {
                    const option = document.createElement('option');
                    option.value = barangay;
                    option.textContent = barangay;
                    barangaySelect.appendChild(option);
                }

                // Set the selected Barangay and populate the Purok dropdown
                barangaySelect.value = locationName;

                if (data[locationName]) {
                    purokSelect.innerHTML = '<option value="" selected disabled>Choose a Purok</option>';
                    data[locationName].forEach(purok => {
                        const option = document.createElement('option');
                        option.value = purok;
                        option.textContent = purok;
                        purokSelect.appendChild(option);
                    });
                    purokSelect.value = locationPurok; // Preselect the Purok
                    purokSelect.disabled = false;
                } else {
                    purokSelect.innerHTML = '<option value="" selected disabled>No Purok Available</option>';
                    purokSelect.disabled = true;
                }
            })
            .catch(error => console.error('Error loading barangay_purok.json:', error));
    });

    // Handle Barangay selection change
    const barangaySelect = document.getElementById('barangay');
    const purokSelect = document.getElementById('purok');

    barangaySelect.addEventListener('change', () => {
        const selectedBarangay = barangaySelect.value;

        // Clear existing Purok options
        purokSelect.innerHTML = '<option value="" selected disabled>Choose a Purok</option>';

        // Fetch the JSON file again to repopulate based on selection
        fetch('barangay_purok.json')
            .then(response => response.json())
            .then(data => {
                if (data[selectedBarangay]) {
                    data[selectedBarangay].forEach(purok => {
                        const option = document.createElement('option');
                        option.value = purok;
                        option.textContent = purok;
                        purokSelect.appendChild(option);
                    });
                    purokSelect.disabled = false;
                } else {
                    purokSelect.innerHTML = '<option value="" selected disabled>No Purok Available</option>';
                    purokSelect.disabled = true;
                }
            })
            .catch(error => console.error('Error loading barangay_purok.json:', error));
    });
});


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
