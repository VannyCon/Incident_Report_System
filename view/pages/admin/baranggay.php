<?php
$title = "admin";

require_once('../../../controller/AdminController.php');

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../../index.php");
    exit();
}

// Get Barangay Data
$brgyData = $adminService->getAllBaranggayData();
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
    <h4>Barangay Incident Counts</h4>
    <div class="card p-3">
        <table class="table table-bordered rounded">
            <thead class="table-info">
                <tr class="rounded">
                    <th scope="col">Barangay Name</th>
                    <th scope="col">Incident Count</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($brgyData)): ?>
                    <?php foreach ($brgyData as $barangay): ?>
                        <tr class="rounded">
                            <td><?php echo htmlspecialchars($barangay['barangay_name']); ?></td>
                            <td><?php echo $barangay['incident_count']; ?></td>
                            <td><a href="baranggay_incident.php?baranggay=<?php echo htmlspecialchars($barangay['barangay_name']); ?>" class="btn btn-primary rounded">Check</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</div>


<?php require_once('../../components/footer.php'); ?>
