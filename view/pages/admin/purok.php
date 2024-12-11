<?php
$title = "admin";

require_once('../../../controller/AdminController.php');
$baranggay_name = $_GET['baranggay'];
// Check if a form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Create Purok
    if (isset($_POST['purok_name'])) {
        $purok_name = $_POST['purok_name'];// Assuming Barangay is selected from the dropdown
        $adminService->createPurok($baranggay_name, $purok_name) ;
    }

    // Handle Update Purok
    if (isset($_POST['update_purok_id'])) {
        $id = $_POST['update_purok_id'];
        $purok_name = $_POST['update_purok_name'];
        $adminService->updatePurok($id, $purok_name);

    }

    // Handle Delete Purok
    if (isset($_POST['delete_purok_id'])) {
        $id = $_POST['delete_purok_id'];
        $adminService->deletePurok($id);
    }

    // Redirect to avoid form resubmission on page refresh
    header("Location: purok.php?baranggay=$baranggay_name");
    exit();
}
if(!isset($_GET['baranggay'])){
    header("Location: baranggay.php");
    exit();
}

// Get all Barangay and Purok data
$getAllPurok = $adminService->getAllPurokByID($baranggay_name);

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
    <!-- Create Purok Button -->
    <div class="card p-3">
        <div class="mb-3">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createPurokModal">
                Create Purok
            </button>
        </div>

        <table class="table table-bordered rounded">
            <thead class="table-primary">
                <tr class="rounded">
                    <th scope="col">Purok Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($getAllPurok as $purok): ?>
                <tr>
                    <td><?php echo $purok['purok_name']; ?></td>
                    <td>
                        <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updatePurokModal" onclick="openUpdateModal(<?php echo $purok['id']; ?>, '<?php echo $purok['purok_name']; ?>')">
                            Update
                        </button>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePurokModal" onclick="setDeleteId(<?php echo $purok['id']; ?>)">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Purok Modal -->
<div class="modal fade" id="createPurokModal" tabindex="-1" aria-labelledby="createPurokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPurokModalLabel">Create Purok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPurokForm" method="POST">
                    <div class="mb-3">
                        <label for="barangay_id" class="form-label">Baranggay Name: </label>
                       <h2><?php echo $baranggay_name?></h2>
                    </div>
                    <div class="mb-3">
                        <label for="purok_name" class="form-label">Purok Name</label>
                        <input type="text" class="form-control" id="purok_name" name="purok_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Purok Modal -->
<div class="modal fade" id="updatePurokModal" tabindex="-1" aria-labelledby="updatePurokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePurokModalLabel">Update Purok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePurokForm" method="POST">
                    <input type="hidden" id="update_purok_id" name="update_purok_id">
                    <div class="mb-3">
                        <label for="update_purok_name" class="form-label">Purok Name</label>
                        <input type="text" class="form-control" id="update_purok_name" name="update_purok_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Purok Confirmation Modal -->
<div class="modal fade" id="deletePurokModal" tabindex="-1" aria-labelledby="deletePurokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePurokModalLabel">Delete Purok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Purok?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST">
                    <input type="hidden" id="delete_purok_id" name="delete_purok_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../../components/footer.php'); ?>

<script>
    // Open Update Purok Modal
    function openUpdateModal(id, name) {
        document.getElementById('update_purok_id').value = id;
        document.getElementById('update_purok_name').value = name;
    }

    // Set Delete Purok ID
    function setDeleteId(id) {
        document.getElementById('delete_purok_id').value = id;
    }
</script>

<?php require_once('../../components/footer.php'); ?>
