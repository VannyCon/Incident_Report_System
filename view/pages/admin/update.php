<?php
require_once('../../../controller/AdminController.php');

$title = 'Update';
// Assuming PatientID is passed as a GET parameter
if (isset($_GET['PatientID'])) {
    $PatientID = $_GET['PatientID'];
}else{
    header("Location: index.php");
    exit();
}
// Fetch existing data
$incidentData = $adminService->getPatientIncidentById($PatientID);

// Check if data was retrieved
if (!$incidentData) {
    // Handle the case where no data was found
    $error_message = "No data found for Patient ID: " . htmlspecialchars($PatientID);
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Incident Report</a>
    </div>
</nav>

<div class="container mt-5">
    <h2>Update Incident Report Form</h2>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <a href="update_map.php?PatientID=<?php echo $PatientID ?>" class="btn btn-info text-white my-2">Chane Location?</a>
        <!-- Select Incident Type -->
        <div class="mb-3">
            <label for="incidentType" class="form-label">Select Incident Type</label>
            <select class="form-select" id="incidentType" name="incident_type" aria-label="Incident Type" required>
                <option value="" disabled>Choose an incident type</option>
                <option value="isVehiclular" <?php echo (isset($incidentData['isVehiclular']) && $incidentData['isVehiclular'] == true) ? 'selected' : ''; ?>>Vehicular Incident</option>
                <option value="isOther" <?php echo (isset($incidentData['isVehiclular']) && $incidentData['isVehiclular'] == false) ? 'selected' : ''; ?>>Other Incident</option>
            </select>
        </div>
        <input type="hidden" class="form-control" id="patiendID" name="patiendID" value="<?php echo $PatientID ?>" required>
        <input type="hidden" class="form-control" id="incidentID_fk" name="incidentID_fk" value="<?php echo htmlspecialchars($incidentData['incidentID_fk']); ?>" required>
        <!-- Common Incident Form Fields -->
        <div id="common-form">
            <h4>Patient Information</h4>
            <div class="mb-3">
                <label for="patientName" class="form-label">Patient Name</label>
                <input type="text" class="form-control" id="patientName" name="patient_name" value="<?php echo htmlspecialchars($incidentData['patient_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="patientAge" class="form-label">Patient Age</label>
                <input type="number" class="form-control" id="patientAge" name="patient_age" value="<?php echo htmlspecialchars($incidentData['patient_age']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="patientSex" class="form-label">Patient Sex</label>
                <select class="form-select" id="patientSex" name="patient_sex" required>
                    <option value="Male" <?php echo ($incidentData['patient_sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($incidentData['patient_sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="patientAddress" class="form-label">Patient Address</label>
                <input type="text" class="form-control" id="patientAddress" name="patient_address" value="<?php echo htmlspecialchars($incidentData['patient_address']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="patient_status" class="form-label">Status</label>
                <select class="form-select" id="patient_status" name="statusID" aria-label="Patient Status" required>
                    <option value="" selected disabled>Choose a patient status</option>
                    <option value="SID-001" <?php echo ($incidentData['statusID_fk'] == 'SID-001') ? 'selected' : ''; ?>>Green</option>
                    <option value="SID-002" <?php echo ($incidentData['statusID_fk'] == 'SID-002') ? 'selected' : ''; ?>>Yellow</option>
                    <option value="SID-003" <?php echo ($incidentData['statusID_fk'] == 'SID-003') ? 'selected' : ''; ?>>Red</option>
                    <option value="SID-004" <?php echo ($incidentData['statusID_fk'] == 'SID-004') ? 'selected' : ''; ?>>Black</option>
                </select>
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
        <button type="submit" class="btn btn-primary">Update Incident</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#incidentType').change(function() {
        var selectedType = $(this).val();
        
        if (selectedType === 'isVehiclular') {
            $('#vehicular-form').removeClass('d-none');
            $('#other-form').addClass('d-none');
        } else if (selectedType === 'isOther') {
            $('#other-form').removeClass('d-none');
            $('#vehicular-form').addClass('d-none');
        } else {
            $('#vehicular-form').addClass('d-none');
            $('#other-form').addClass('d-none');
        }
    });

    // Trigger change event on page load to set the correct form based on the existing data
    $('#incidentType').trigger('change');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
