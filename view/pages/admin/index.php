<?php
$title = "admin";

require_once('../../../controller/AdminController.php'); 
// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../../../index.php");
    exit();
}
$dashboard = new DashboardServices();

$toalInjuries = $dashboard->totalInjuries();
$topInjuries= $dashboard->topThreeIncident();
$m = $dashboard->monthlyAnalytic();
// Initialize the monthly data with zero counts
$monthlyCounts = [
    'January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 
    'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 
    'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0
];
// Map the results from the database to the corresponding month
if (!empty($m)) {
    foreach ($m as $entry) {
        $monthlyCounts[$entry['month_name']] = $entry['incident_count'];
    }
}


$y = $dashboard->yearAnalytic();


require_once('../../components/header.php')?>
<style>
    .dashboard-text{
        font-size: 35px;
        font-weight: bold;
        color: #e00909;
    }
    .dashboard-subtext{
        font-size: 15px;
        font-weight: light;
    }

</style>
    <h3 class="ms-2"><strong>Dashboard</strong></h3>
    <div class="container-fluid mt-2">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card p-3" style="height: 100%;">
                    <div class="stat-label"><strong>Cases Every Year</strong></div>
                    <div style="width: 100%; margin: auto;" class="mt-2">
                        <canvas id="yearAnalytics"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="card p-3" style="height: 100%;">
                    <div class="stat-label"><strong>Cases Every Month</strong></div>
                    <div style="width: 100%; margin: auto;" class="mt-2">
                        <canvas id="monthAnalytics"></canvas>
                    </div>
                 </div>
            </div>
        </div>
        
        <div class="row mt-3">

            <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Type Of Incident</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Number of Cases</th>
                                <th>Type Of Incident</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($topInjuries)): ?>
                            <?php foreach ($topInjuries as $topInjurie): ?>
                            <tr>
                                <th><?php echo $topInjurie['total_cases']?></th>
                                <td><?php echo $topInjurie['type_of_incident']?></td>
                            </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No records found.</td>
                                </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


            <!-- Cards Column -->
        <div class="col-md-4 mt-2 mt-md-0">
            <div class="row h-100">
                <div class="col-md-6 mb-2 d-flex flex-column">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5 class="dashboard-subtext">Total Died</h5>
                            <p class="dashboard-text m-0 text-center"><?php echo $toalInjuries['died']?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2 d-flex flex-column">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5 class="dashboard-subtext">Total Fatal Injuries</h5>
                            <p class="dashboard-text m-0 text-center"><?php echo $toalInjuries['fatal']?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2 mb-md-0 d-flex flex-column">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5 class="dashboard-subtext">Total Major Injuries</h5>
                            <p class="dashboard-text m-0 text-center"><?php echo $toalInjuries['major']?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2 mb-md-0 d-flex flex-column">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h5 class="dashboard-subtext">Total Minor Injuries</h5>
                            <p class="dashboard-text m-0 text-center"><?php echo $toalInjuries['minor']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        </div>
    </div>
    <script>
        const Jan = <?php echo $monthlyCounts['January']; ?>;
        const Feb = <?php echo $monthlyCounts['February']; ?>;
        const Mar = <?php echo $monthlyCounts['March']; ?>;
        const Apr = <?php echo $monthlyCounts['April']; ?>;
        const May = <?php echo $monthlyCounts['May']; ?>;
        const Jun = <?php echo $monthlyCounts['June']; ?>;
        const Jul = <?php echo $monthlyCounts['July']; ?>;
        const Aug = <?php echo $monthlyCounts['August']; ?>;
        const Sep = <?php echo $monthlyCounts['September']; ?>;
        const Oct = <?php echo $monthlyCounts['October']; ?>;
        const Nov = <?php echo $monthlyCounts['November']; ?>;
        const Dec = <?php echo $monthlyCounts['December']; ?>;
        
        // Create the line chart
        const ctx = document.getElementById('monthAnalytics').getContext('2d');
        const monthAnalytics = new Chart(ctx, {
            type: 'line',  
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Nursery Plant Summary',
                    data: [Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec],
                    backgroundColor: 'rgba(224, 9, 9, 0.2)',  
                    borderColor: 'rgba(224, 9, 9, 1)',  
                    borderWidth: 2,
                    fill: true,  
                    tension: 0.3 
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });



        ////////YEAR ANALYTICS////////

        // Fetch data from your MySQL database for yearly incidents
        const yearLabels = <?php echo json_encode(array_column($y, 'incident_year')); ?>; // Extract years from the array
        const yearData = <?php echo json_encode(array_column($y, 'incident_count')); ?>;  // Extract counts

        // Create the bar chart for cases every year
        const ctx1 = document.getElementById('yearAnalytics').getContext('2d');
        const yearAnalytics = new Chart(ctx1, {
            type: 'bar',  // Bar chart for yearly data
            data: {
                labels: yearLabels,  // Dynamic year labels from the data
                datasets: [{
                    label: 'Cases Every Year',
                    data: yearData,  // Dynamic incident counts from the data
                    backgroundColor: 'rgba(224, 9, 9, 0.2)',  // Change color for bars
                    borderColor: 'rgba(224, 9, 9, 1)',  // Border color
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

   
<?php require_once('../../components/footer.php')?>
