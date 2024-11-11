<?php

require_once('../../../controller/AdminController.php');

$title = 'Update';

// Assuming IncidentID is passed as a GET parameter
if (isset($_GET['IncidentID'])) {
    $incidentID = $_GET['IncidentID'];
} else {
    header("Location: map.php");
    exit();
}

// Fetch existing incident data
$incidentData = $adminService->getIncidentById($incidentID);

// Check if data was retrieved
if (!$incidentData) {
    // Handle the case where no data was found
    $error_message = "No data found for Incident ID: " . htmlspecialchars($incidentID);
}

// Extract patient information into an array
$patients = [];
if (isset($incidentData['patients'])) {
    foreach ($incidentData['patients'] as $patient) {
        $patients[] = [
            'name' => $patient['name'],
            'patient_birthdate' => $patient['patient_birthdate'],
            'age' => $patient['age'],
            'sex' => $patient['sex'],
            'address' => $patient['address'],
            'statusID' => $patient['statusID'],
        ];
    }
}

?>

<?php require_once('../../components/header.php') ?>

<div class="container mt-5">
<a href="map.php" class="btn btn-outline-danger">Back</a>
    <h2>Update Incident Report Form</h2>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <a href="update_map.php?IncidentID=<?php echo htmlspecialchars($incidentID); ?>" class="btn btn-info text-white my-2">Change Location?</a>
        <!-- Select Incident Type -->
        <div class="mb-3">
            <label for="incidentType" class="form-label">Select Incident Type</label>
            <select class="form-select" id="incidentType" name="incident_type" aria-label="Incident Type" required>
                <option value="" disabled>Choose an incident type</option>
                <option value="isVehiclular" <?php echo (isset($incidentData['isVehiclular']) && $incidentData['isVehiclular'] == true) ? 'selected' : ''; ?>>Vehicular Incident</option>
                <option value="isOther" <?php echo (isset($incidentData['isVehiclular']) && $incidentData['isVehiclular'] == false) ? 'selected' : ''; ?>>Other Incident</option>
            </select>
        </div>
        <!-- <input type="text" name="lat" id="" value="<?php echo $_GET['lat']?>">
        <input type="text" name="long" id="" value="<?php echo $_GET['long']?>"> -->
        <input type="hidden" class="form-control" id="incidentID_fk" name="incidentID_fk" value="<?php echo htmlspecialchars($incidentData['incidentID_fk']); ?>" required>
        <?php
            // Define the ordinal function in PHP
            function ordinal($num) {
                return $num . (
                    ($num % 10 === 1 && $num % 100 !== 11) ? 'st' :
                    (($num % 10 === 2 && $num % 100 !== 12) ? 'nd' :
                    (($num % 10 === 3 && $num % 100 !== 13) ? 'rd' : 'th'))
                );
            }

            $patients = $adminService->getIncidentPatientsById($incidentID);
            if (!empty($patients)): ?>
               
                    <!-- PATIENT INFORMATION -->
                    <div id="patients-container">
                        <?php foreach ($patients as $index => $patient): // Include index for count ?>
                        <!-- Initial patient form -->
                        <div class="patient-form card mb-3">
                            <div class="card-header">
                                <h4><?php echo ordinal($index + 1); ?> Patient Information</h4>
                            </div>
                            <input type="hidden" class="form-control" name="patientID[]" value="<?php echo htmlspecialchars($patient['patientID']); ?>" required>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="patientName" class="form-label">Patient Name</label>
                                    <input type="text" class="form-control" name="patient_name[]" value="<?php echo htmlspecialchars($patient['patient_name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="patientbirthdate" class="form-label">Patient Birthdate</label>
                                    <input type="date" class="form-control" name="patient_birthdate[]" value="<?php echo htmlspecialchars($patient['patient_birthdate']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="patientAge" class="form-label">Patient Age</label>
                                    <input type="number" class="form-control" name="patient_age[]" value="<?php echo htmlspecialchars($patient['patient_age']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="patientSex" class="form-label">Patient Sex</label>
                                    <select class="form-select" name="patient_sex[]" required>
                                        <option value="Male" <?php echo ($patient['patient_sex'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($patient['patient_sex'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="patientAddress" class="form-label">Patient Address</label>
                                    <input type="text" class="form-control" name="patient_address[]" value="<?php echo htmlspecialchars($patient['patient_address']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="patient_status" class="form-label">Status</label>
                                    <select class="form-select" name="statusID[]" aria-label="Patient Status" required>
                                        <option value="" disabled>Choose a patient status</option>
                                        <option value="SID-001" <?php echo ($patient['statusID'] === 'SID-001') ? 'selected' : ''; ?>>Green</option>
                                        <option value="SID-002" <?php echo ($patient['statusID'] === 'SID-002') ? 'selected' : ''; ?>>Yellow</option>
                                        <option value="SID-003" <?php echo ($patient['statusID'] === 'SID-003') ? 'selected' : ''; ?>>Red</option>
                                        <option value="SID-004" <?php echo ($patient['statusID'] === 'SID-004') ? 'selected' : ''; ?>>Black</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

            <?php else: ?>
                <p>No patients found for this incident.</p>
            <?php endif; ?>


            <!-- Button to add another patient section -->
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="addPatientForm()">Add Another Patient</button>
            </div>


        <h4>Incident Details</h4>
        <div class="mb-3">
            <label for="complaint" class="form-label">Complaint</label>
            <input type="text" class="form-control" id="complaint" name="complaint" value="<?php echo htmlspecialchars($incidentData['complaint']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="rescuerTeam" class="form-label">Rescuer Team</label>
            <input type="text" class="form-control" id="rescuerTeam" name="rescuer_team" value="<?php echo htmlspecialchars($incidentData['rescuer_team']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="referredHospital" class="form-label">Referred Hospital</label>
            <input type="text" class="form-control" id="referredHospital" name="referred_hospital" value="<?php echo htmlspecialchars($incidentData['referred_hospital']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="incidentDate" class="form-label">Incident Date</label>
            <input type="date" class="form-control" id="incidentDate" name="incident_date" value="<?php echo htmlspecialchars($incidentData['incident_date']); ?>" required>
        </div>

        <!-- Vehicular Incident Form -->
        <div id="vehicular-form" class="<?php echo ($incidentData['isVehiclular']) ? '' : 'd-none'; ?>">
            <h4>Vehicular Incident Details</h4>
            <input type="hidden" class="form-control" id="typeOfIncident" name="va_type_of_incident" value="Vehiclular Accident">
            <div class="mb-3">
                <label for="patientClassification" class="form-label">Patient Classification</label>
                <input type="text" class="form-control" id="patientClassification" name="patient_classification" value="<?php echo htmlspecialchars($incidentData['patient_classification']); ?>">
            </div>
            <div class="mb-3">
                <label for="vehicleType" class="form-label">Vehicle Type</label>
                <input type="text" class="form-control" id="vehicleType" name="vehicle_type" value="<?php echo htmlspecialchars($incidentData['vehicle_type']); ?>">
            </div>
            <div class="mb-3">
                <label for="intoxication" class="form-label">Intoxication</label>
                <input type="text" class="form-control" id="intoxication" name="intoxication" value="<?php echo htmlspecialchars($incidentData['intoxication']); ?>">
            </div>
            <div class="mb-3">
                <label for="helmet" class="form-label">Helmet (Yes/No)</label>
                <select class="form-select" id="helmet" name="helmet">
                    <option value="1" <?php echo ($incidentData['helmet'] == '1') ? 'selected' : ''; ?>>Yes</option>
                    <option value="0" <?php echo ($incidentData['helmet'] == '0') ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="stray" class="form-label">Stray (Yes/No)</label>
                <select class="form-select" id="stray" name="stray">
                    <option value="1" <?php echo ($incidentData['stray'] == '1') ? 'selected' : ''; ?>>Yes</option>
                    <option value="0" <?php echo ($incidentData['stray'] == '0') ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="va_description" class="form-label">VA Description</label>
                <input type="text" class="form-control" id="va_description" name="va_description" value="<?php echo htmlspecialchars($incidentData['description']); ?>">
            </div>
        </div>

         <!-- Other Incident Form -->
         <div id="other-form" class="<?php echo (!$incidentData['isVehiclular']) ? '' : 'd-none'; ?>">
            <h4>Other Incident Details</h4>
            <input type="hidden" class="form-control" id="typeOfIncident" name="va_type_of_incident" value="Other Incident">
            <div class="mb-3">
                <label for="incidentTypeDetail" class="form-label">Incident Type Detail</label>
                <input type="text" class="form-control" id="incidentTypeDetail" name="type_of_incident" value="<?php echo htmlspecialchars($incidentData['type_of_incident']); ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($incidentData['description']); ?>">
            </div>
        </div>
        <input type="hidden" name="action" value="updateIncident">
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Incident Report</button>
        </div>
    </form>
</div>


<script>
    let patientCount = 1; // Initialize patient count

    function addPatientForm() {
        // Increment the patient count
        patientCount++;

        // Get the container where the new form fields will be added
        const patientsContainer = document.getElementById('patients-container');

        // Create a new patient form
        const newForm = document.createElement('div');
        newForm.classList.add('patient-form', 'card', 'mb-3');

        // Generate a unique ID for the form to be able to remove it later
        const formId = `patient-form-${patientCount}`;
        newForm.setAttribute('id', formId);

        // Add the new form fields with a delete button
        newForm.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Add Patient Information</h4>
                <button type="button" class="btn btn-danger btn-sm" onclick="removePatientForm('${formId}')">Delete</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="patientName" class="form-label">Patient Name</label>
                    <input type="text" class="form-control" name="patient_name[]" required>
                </div>
                <div class="mb-3">
                    <label for="patientbirthdate" class="form-label">Patient Birthdate</label>
                    <input type="date" class="form-control" name="patient_birthdate[]" required>
                </div>
                <div class="mb-3">
                    <label for="patientAge" class="form-label">Patient Age</label>
                    <input type="number" class="form-control" name="patient_age[]" required>
                </div>
                <div class="mb-3">
                    <label for="patientSex" class="form-label">Patient Sex</label>
                    <select class="form-select" name="patient_sex[]" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="patientAddress" class="form-label">Patient Address</label>
                    <input type="text" class="form-control" name="patient_address[]" required>
                </div>
                <div class="mb-3">
                    <label for="patient_status" class="form-label">Status</label>
                    <select class="form-select" name="statusID[]" aria-label="Patient Status" required>
                        <option value="" selected disabled>Choose a patient status</option>
                        <option value="SID-001">Green</option>
                        <option value="SID-002">Yellow</option>
                        <option value="SID-003">Red</option>
                        <option value="SID-004">Black</option>
                    </select>
                </div>
            </div>
        `;

        // Append the new form to the container
        patientsContainer.appendChild(newForm);
    }

    // Function to remove a patient form
    function removePatientForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.remove();
        }
    }

    // Function to convert number to ordinal (e.g., 1 to "First", 2 to "Second", etc.)
    function ordinal(n) {
        const suffixes = ["th", "st", "nd", "rd"];
        const value = n % 100;
        return n + (suffixes[(value - 20) % 10] || suffixes[value] || suffixes[0]);
    }

        document.getElementById('incidentType').addEventListener('change', function() {
            var incidentType = this.value;
            if (incidentType === 'isVehiclular') {
                document.getElementById('vehicular-form').classList.remove('d-none');
                document.getElementById('other-form').classList.add('d-none');
            } else if (incidentType === 'isOther') {
                document.getElementById('other-form').classList.remove('d-none');
                document.getElementById('vehicular-form').classList.add('d-none');
            } else {
                document.getElementById('vehicular-form').classList.add('d-none');
                document.getElementById('other-form').classList.add('d-none');
            }
        });
    </script>

<?php require_once('../../components/footer.php') ?>
