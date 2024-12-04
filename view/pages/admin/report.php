<?php
    $title = "admin";
    session_start();
    // Redirect to login if not logged in
    if (!isset($_SESSION['username'])) {
        header("Location: ../../../index.php");
        exit();
    }
    require_once('../../components/header.php')?>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<h3 class="ms-2"><strong>Report</strong></h3>
<div class="container p-2">
    <section class="vh-50">
        <div class="container py-2 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong text-center" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <!-- Big Circular Check Mark -->
                            <div class="circle-check mb-4" style="margin: 0 auto; width: 100px; height: 100px; border-radius: 50%; background-color: #28a745; display: flex; justify-content: center; align-items: center;">
                                <i class="fas fa-file" style="font-size: 48px; color: white;"></i>
                            </div>
                            <h5 class="mb-4">Report for the Year of <?php echo date('Y'); ?></h5>

                            <!-- Download Button -->
                             <!-- If you want to create Report you will redirect to Report_pdf.php -->
                            <a href="report_pdf.php" class="btn btn-primary w-100">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once('../../components/footer.php'); ?>
