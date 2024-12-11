<?php
$title = "admin";

require_once('../../../controller/AdminController.php');


// Check if a form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Create Incident Type
    if (isset($_POST['incident_value']) && isset($_POST['incident_name'])) {
        $incident_value = $_POST['incident_value'];
        $incident_name = $_POST['incident_name'];
        $adminService->createIncidentTypes($incident_value, $incident_name);
    }

    // Handle Update Incident Type
    if (isset($_POST['update_incident_id'])) {
        $id = $_POST['update_incident_id'];
        $incident_value = $_POST['update_incident_value'];
        $incident_name = $_POST['update_incident_name'];
        $adminService->updateIncidentType($id, $incident_value, $incident_name);
    }

    // Handle Delete Incident Type
    if (isset($_POST['delete_incident_id'])) {
        $id = $_POST['delete_incident_id'];
        $adminService->deleteIncidentType($id);
    }

    // Redirect to avoid form resubmission on page refresh
    header("Location: incident.php");
    exit();
}

// Get all Incident Types data
$getAllIncidentTypes = $adminService->getAllIncidentTypes();

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
    <a href="baranggay.php" class="btn btn-outline-danger mb-3">Back</a>
    <!-- Create Incident Type Button -->
    <div class="card p-3">
        <div class="mb-3">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createIncidentTypeModal">
                Create Incident Type
            </button>
        </div>

        <table class="table table-bordered rounded">
            <thead class="table-primary">
                <tr class="rounded">
                    <th scope="col">Incident Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($getAllIncidentTypes as $incident): ?>
                <tr>
                    <td><?php echo $incident['incident_name']; ?></td>
                    <td>
                        <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateIncidentTypeModal" onclick="openUpdateModal(<?php echo $incident['id']; ?>, '<?php echo $incident['value']; ?>', '<?php echo $incident['incident_name']; ?>')">
                            Update
                        </button>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteIncidentTypeModal" onclick="setDeleteId(<?php echo $incident['id']; ?>)">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Incident Type Modal -->
<div class="modal fade" id="createIncidentTypeModal" tabindex="-1" aria-labelledby="createIncidentTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createIncidentTypeModalLabel">Create Incident Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createIncidentTypeForm" method="POST">
                    <div class="mb-3">
                        <label for="incident_value" class="form-label">Incident Value</label>
                        <input type="text" class="form-control" id="incident_value" name="incident_value" required>
                    </div>
                    <div class="mb-3">
                        <label for="incident_name" class="form-label">Incident Name</label>
                        <input type="text" class="form-control" id="incident_name" name="incident_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Incident Type Modal -->
<div class="modal fade" id="updateIncidentTypeModal" tabindex="-1" aria-labelledby="updateIncidentTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateIncidentTypeModalLabel">Update Incident Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateIncidentTypeForm" method="POST">
                    <input type="hidden" id="update_incident_id" name="update_incident_id">
                    <div class="mb-3">
                        <label for="update_incident_value" class="form-label">Incident Value</label>
                        <input type="text" class="form-control" id="update_incident_value" name="update_incident_value" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_incident_name" class="form-label">Incident Name</label>
                        <input type="text" class="form-control" id="update_incident_name" name="update_incident_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Incident Type Confirmation Modal -->
<div class="modal fade" id="deleteIncidentTypeModal" tabindex="-1" aria-labelledby="deleteIncidentTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteIncidentTypeModalLabel">Delete Incident Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Incident Type?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST">
                    <input type="hidden" id="delete_incident_id" name="delete_incident_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../../components/footer.php'); ?>

<script>
    // Open Update Incident Type Modal
    function openUpdateModal(id, value, name) {
        document.getElementById('update_incident_id').value = id;
        document.getElementById('update_incident_value').value = value;
        document.getElementById('update_incident_name').value = name;
    }

    // Set Delete Incident Type ID
    function setDeleteId(id) {
        document.getElementById('delete_incident_id').value = id;
    }
</script>

<?php require_once('../../components/footer.php'); ?>
