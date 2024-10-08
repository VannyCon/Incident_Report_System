<?php
require_once('../../../controller/AdminController.php');
$title = 'Create';
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
    <h2>Incident Report Form</h2>
    <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

    <form action="" method="POST">
      <!-- Select Incident Type -->
      <div class="mb-3">
        <label for="incidentType" class="form-label">Select Incident Type</label>
        <select class="form-select" id="incidentType" name="incident_type" aria-label="Incident Type">
          <option value="" selected disabled>Choose an incident type</option>
          <option value="isVehiclular">Vehicular Incident</option>
          <option value="isOther">Other Incident</option>
        </select>
      </div>

      <!-- Common Incident Form Fields -->
      <div id="common-form">
        <h4>Patient Information</h4>
        <div class="mb-3">
          <label for="patientName" class="form-label">Patient Name</label>
          <input type="text" class="form-control" id="patientName" name="patient_name" required>
        </div>
        <div class="mb-3">
          <label for="patientAge" class="form-label">Patient Age</label>
          <input type="number" class="form-control" id="patientAge" name="patient_age" required>
        </div>
        <div class="mb-3">
          <label for="patientSex" class="form-label">Patient Sex</label>
          <select class="form-select" id="patientSex" name="patient_sex" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="patientAddress" class="form-label">Patient Address</label>
          <input type="text" class="form-control" id="patientAddress" name="patient_address" required>
        </div>

        <div class="mb-3">
        <label for="patient_status" class="form-label">Status</label>
        <select class="form-select" id="patient_status" name="statusID" aria-label="Patient Status" required>
          <option value="" selected disabled>Choose a patient status</option>
          <option value="SID-001">Green</option>
          <option value="SID-002">Yellow</option>
          <option value="SID-003">Red</option>
          <option value="SID-004">Black</option>
        </select>
      </div>

        <h4>Incident Details</h4>
        <div class="mb-3">
          <label for="complaint" class="form-label">Complaint</label>
          <input type="text" class="form-control" id="complaint" name="complaint" required>
        </div>
        <div class="mb-3">
          <label for="rescuerTeam" class="form-label">Rescuer Team</label>
          <input type="text" class="form-control" id="rescuerTeam" name="rescuer_team" required>
        </div>
        <div class="mb-3">
          <label for="referredHospital" class="form-label">Referred Hospital</label>
          <input type="text" class="form-control" id="referredHospital" name="referred_hospital" required>
        </div>
        <div class="mb-3">
          <label for="incidentDate" class="form-label">Incident Date</label>
          <input type="date" class="form-control" id="incidentDate" name="incident_date" required>
        </div>
      </div>



      <!-- Vehicular Incident Form -->
      <div id="vehicular-form" class="d-none">
        <h4>Vehicular Incident Details</h4>
        <input type="hidden" class="form-control" id="typeOfIncident" name="va_type_of_incident" value="Vehiclular Accident">
        <div class="mb-3">
          <label for="patientClassification" class="form-label">Patient Classification</label>
          <input type="text" class="form-control" id="patientClassification" name="patient_classification">
        </div>
        <div class="mb-3">
          <label for="vehicleType" class="form-label">Vehicle Type</label>
          <input type="text" class="form-control" id="vehicleType" name="vehicle_type">
        </div>
        <div class="mb-3">
          <label for="intoxication" class="form-label">Intoxication</label>
          <input type="text" class="form-control" id="intoxication" name="intoxication">
        </div>
        <div class="mb-3">
          <label for="helmet" class="form-label">Helmet (Yes/No)</label>
          <select class="form-select" id="helmet" name="helmet">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="stray" class="form-label">Stray (Yes/No)</label>
          <select class="form-select" id="stray" name="stray">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="va_description" class="form-label">VA Description</label>
          <textarea class="form-control" id="va_description" name="va_description"></textarea>
        </div>
      </div>

      <!-- Other Incident Form -->
      <div id="other-form" class="d-none">
        <h4>Other Incident Details</h4>
        <div class="mb-3">
          <label for="typeOfIncident" class="form-label">Type of Incident</label>
          <input type="text" class="form-control" id="typeOfIncident" name="type_of_incident">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description"></textarea>
        </div>
      </div>

      <input type="hidden" name="action" value="createIncident">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <script>
    $(document).ready(function () {
      $('#incidentType').change(function () {
        var incidentType = $(this).val();
        if (incidentType === 'isVehiclular') {
          $('#vehicular-form').removeClass('d-none');
          $('#other-form').addClass('d-none');
        } else if (incidentType === 'isOther') {
          $('#other-form').removeClass('d-none');
          $('#vehicular-form').addClass('d-none');
        } else {
          $('#vehicular-form').addClass('d-none');
          $('#other-form').addClass('d-none');
        }
      });
    });
  </script>

</body>
</html>
