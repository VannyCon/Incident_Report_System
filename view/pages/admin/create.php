<?php
$title = 'Create';
require_once('../../../controller/AdminController.php'); ?>

<?php require_once('../../components/header.php')?>

  <div class="container mt-5">
    <a href="map.php" class="btn btn-outline-danger">Back</a>
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
      <?php 
        if(!isset($_GET['locID'])){
          echo " <div class='mb-3'>
                  <label for='incidentType' class='form-label'>Baranggay</label>
                  <select class='form-select' id='incidentType' name='location_name' aria-label='Location'>
                    <option value='Andres Bonifacio'>Andres Bonifacio</option>
                    <option value='Bato'>Bato</option>
                    <option value='Baviera'>Baviera</option>
                    <option value='Bulanon'>Bulanon</option>
                    <option value='Campo Himoga-an'>Campo Himoga-an</option>
                    <option value='Campo Santiago'>Campo Santiago</option>
                    <option value='Colonia Divina'>Colonia Divina</option>
                    <option value='Rafaela Barrera'>Rafaela Barrera</option>
                    <option value='Fabrica'>Fabrica</option>
                    <option value='General Luna'>General Luna</option>
                    <option value='Himoga-an Baybay'>Himoga-an Baybay</option>
                    <option value='Lopez Jaena'>Lopez Jaena</option>
                    <option value='Malubon'>Malubon</option>
                    <option value='Maquiling'>Maquiling</option>
                    <option value='Molocaboc'>Molocaboc</option>
                    <option value='Old Sagay'>Old Sagay</option>
                    <option value='Paraiso'>Paraiso</option>
                    <option value='Plaridel'>Plaridel</option>
                    <option value='Poblacion I (Barangay 1)'>Poblacion I (Barangay 1)</option>
                    <option value='Poblacion II (Barangay 2)'>Poblacion II (Barangay 2)</option>
                    <option value='Puey'>Puey</option>
                    <option value='Rizal'>Rizal</option>
                    <option value='Taba-ao'>Taba-ao</option>
                    <option value='Tadlong'>Tadlong</option>
                    <option value='Vito'>Vito</option>
                  </select>
                </div>
          ";
        }
      
      ?>
     
      <!-- Common Incident Form Fields -->

        <!-- PATIENT INFORMATION -->
        <div id="patients-container">
                <!-- Initial patient form -->
                <div class="patient-form card mb-3">
                    <div class="card-header">
                        <h4>1st Patient Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="patientName" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" name="patient_name[]" required>
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
                </div>
            </div>
            
            <!-- Button to add another patient section -->
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="addPatientForm()">Add Another Patient</button>
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
          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
      </div>



      


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
                <h4>${ordinal(patientCount)} Patient Information</h4>
                <button type="button" class="btn btn-danger btn-sm" onclick="removePatientForm('${formId}')">Delete</button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="patientName" class="form-label">Patient Name</label>
                    <input type="text" class="form-control" name="patient_name[]" required>
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
<?php require_once('../../components/footer.php')?>