<?php
require_once('../../../vendor/autoload.php');
require_once('../../../controller/AdminController.php'); // Adjust the path as necessary// Instantiate your controller
$monthDatas = $adminService->reportForMonth(); // Call your method to fetch data

if ($monthDatas === null || empty($monthDatas)) {
    // Redirect if no data is found
    header("Location: index.php?error=noData"); // Modify the URL as needed
    exit;
}
$currentMonthName = date('F');

// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title - Incident Report
$pdf->SetFillColor(0, 0, 139); // Dark blue background
$pdf->SetTextColor(255, 255, 255); // White text
$pdf->SetFont('helvetica', 'B', 16); // Larger font size for the title
$pdf->Cell(0, 10, "Incident Report", 0, 1, 'C', true);

// Month
$pdf->SetFont('helvetica', 'B', 12); // Bold font for the month
$pdf->SetTextColor(0, 0, 0); // Black text for the month
$pdf->Cell(0, 10, "Month:".$currentMonthName, 0, 1, 'C');

// Add some space before the table
$pdf->Ln(10);

// Table Header
$pdf->SetFillColor(200, 220, 255); // Light blue background for the table header
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->SetFont('helvetica', 'B', 12); // Bold font for table header
$pdf->Cell(70, 10, "Barangay", 1, 0, 'C', true);
$pdf->Cell(70, 10, "Incident Count", 1, 0, 'C', true);
$pdf->Cell(0, 10, "Incident Types", 1, 1, 'C', true); // Last cell in the row

// Reset font and color for table body
$pdf->SetFont('helvetica', '', 12); // Regular font for table body
$pdf->SetTextColor(0, 0, 0); // Black text

// Add data rows
if (!empty($monthDatas)) {
    foreach ($monthDatas as $data) {
      
        // Determine the height based on the length of the incident types
        $incidentTypes = $data['incident_types'];
        $length = strlen($incidentTypes); // Get the length of the incident types
        // Set height based on the number of characters
        if ($length > 50) {
            $cellHeight = 25; // Height for more than 50 characters
        } elseif ($length > 25) {
            $cellHeight = 12; // Height for more than 25 characters
        } else {
            $cellHeight = 10; // Default height for 25 characters or fewer
        } 

        $pdf->Cell(70, $cellHeight, $data['barangay'], 1);
        $pdf->Cell(70, $cellHeight, $data['incident_count'], 1);
        // Create the MultiCell with the determined height
        $pdf->MultiCell(0, $cellHeight, $incidentTypes, 1, 'L', false);

    }
} else {
    $pdf->Cell(0, 10, "No incident data available", 1, 1);
}

// Output PDF
$pdf->Output('incident_report.pdf', 'D'); // 'D' forces download

?>
