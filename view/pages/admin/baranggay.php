<?php
$title = "admin";

require_once('../../../controller/AdminController.php');

// Check if a form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Create Barangay
    if (isset($_POST['baranggay_name'])) {
        $baranggay_name = $_POST['baranggay_name'];
        $adminService->createBaranggay($baranggay_name);
    }

    // Handle Update Barangay
    if (isset($_POST['update_baranggay_id'])) {
        $id = $_POST['update_baranggay_id'];
        $baranggay_name = $_POST['update_baranggay_name'];
        $adminService->updateBaranggay($id, $baranggay_name);
    }

    // Handle Delete Barangay
    if (isset($_POST['delete_baranggay_id'])) {
        $id = $_POST['delete_baranggay_id'];
        $adminService->deleteBaranggay($id);
    }

    // Redirect to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get all Barangay data
$getAllBaranggay = $adminService->getAllBaranggay();

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
    <a href="baranggay_data.php" class="btn btn-outline-danger mb-3">Back</a>
    <!-- Create Barangay Button -->


    <div class="card p-3">
        <div class="mb-3">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createBaranggayModal">
                Create Barangay
            </button>
        </div>
        
        <table class="table table-bordered rounded">
            <thead class="table-primary">
                <tr class="rounded">
                    <th scope="col">Barangay Name</th>
                    <th scope="col">Puroks</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($getAllBaranggay as $barangay): ?>
                <tr>
                    <td><?php echo $barangay['baranggay_name']; ?></td>
                    <td><a href="purok.php?baranggay=<?php echo $barangay['baranggay_name']; ?>" class="btn btn-info">Check</a></td>
                    <td>
                        <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateBaranggayModal" onclick="openUpdateModal(<?php echo $barangay['id']; ?>, '<?php echo $barangay['baranggay_name']; ?>')">
                            Update
                        </button>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBaranggayModal" onclick="setDeleteId(<?php echo $barangay['id']; ?>)">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Create Barangay Modal -->
<div class="modal fade" id="createBaranggayModal" tabindex="-1" aria-labelledby="createBaranggayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBaranggayModalLabel">Create Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createBaranggayForm" method="POST">
                    <div class="mb-3">
                        <label for="baranggay_name" class="form-label">Barangay Name</label>
                        <input type="text" class="form-control" id="baranggay_name" name="baranggay_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Barangay Modal -->
<div class="modal fade" id="updateBaranggayModal" tabindex="-1" aria-labelledby="updateBaranggayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBaranggayModalLabel">Update Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateBaranggayForm" method="POST">
                    <input type="hidden" id="update_baranggay_id" name="update_baranggay_id">
                    <div class="mb-3">
                        <label for="update_baranggay_name" class="form-label">Barangay Name</label>
                        <input type="text" class="form-control" id="update_baranggay_name" name="update_baranggay_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Barangay Confirmation Modal -->
<div class="modal fade" id="deleteBaranggayModal" tabindex="-1" aria-labelledby="deleteBaranggayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBaranggayModalLabel">Delete Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Barangay?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST">
                    <input type="hidden" id="delete_baranggay_id" name="delete_baranggay_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../../components/footer.php'); ?>

<script>
    // Open Update Barangay Modal
    function openUpdateModal(id, name) {
        document.getElementById('update_baranggay_id').value = id;
        document.getElementById('update_baranggay_name').value = name;
    }

    // Set Delete Barangay ID
    function setDeleteId(id) {
        document.getElementById('delete_baranggay_id').value = id;
    }
</script>


<?php require_once('../../components/footer.php'); ?>
