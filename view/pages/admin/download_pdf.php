<?php
require_once('../../../vendor/autoload.php');
require_once('../../../services/TimelineService.php');
require_once('../../../services/PlantInfoService.php');

$plantID = $_GET['plantID'];

// Fetch data
$timeline = new Timeline();
$plant = new PlantInfo();
$plantData = $plant->getPlantDataByID($plantID);
$timelines = $timeline->getTimelineById($plantID);

// Calculate Plant Age
$plantedDate = $plantData['planted_date']; // Format: YYYY-MM-DD
$plantedDateObj = new DateTime($plantedDate);
$currentDate = new DateTime();
$interval = $plantedDateObj->diff($currentDate);

if ($interval->y > 0) {
    $age = $interval->y . ' years old';
} elseif ($interval->m > 0) {
    $age = $interval->m . ' months old';
} else {
    $age = $interval->d . ' days old';
}

if (!isset($plantID)) {
    // Redirect to plant info page if no data is found
    header("Location: index.php?plantID=$plantID");
    exit;
}

// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->SetFillColor(30, 144, 255); // Blue background
$pdf->SetTextColor(255, 255, 255); // White text
$pdf->Cell(0, 10, "Plant Information", 0, 1, 'C', true);

// Plant Details
$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(45, 10, "Nursery Owner", 0, 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $plantData['nursery_owner_fullname'], 0, 1);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(45, 10, "Type:", 0, 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $plantData['plant_type'], 0, 1);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(45, 10, "Variety:", 0, 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $plantData['plant_variety'], 0, 1);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(45, 10, "Age:", 0, 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $age, 0, 1);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(45, 10, "Planted Date:", 0, 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $plantData['planted_date'], 0, 1);

$pdf->Ln(10);

// Timeline Section Title
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, "Timeline", 0, 1, 'L', true);

foreach ($timelines as $timelineItem) {
    // Timeline title and date
    $pdf->SetFillColor(255, 250, 205); // Light yellow background
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(95, 10, $timelineItem['timeline_title'], 1, 0, 'L', true);
    $pdf->Cell(0, 10, DateTime::createFromFormat('Y-m-d', $timelineItem['history_date'])->format('F j, Y'), 1, 1, 'L', true);

    // Content Section Title
    $pdf->SetFillColor(144, 238, 144); // Light green background
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(95, 10, "Content", 1, 0, 'L', true);
    $pdf->Cell(0, 10, "Activity time", 1, 1, 'L', true);

    // Timeline Content and Time
    $contents = $timeline->getContentByTimelineId($timelineItem['content_id']);
    if (!empty($contents)) {
        foreach ($contents as $content) {
            $historyTime = htmlspecialchars($content['history_time']); // Access from $content
            $timeObject = DateTime::createFromFormat('H:i:s.u', $historyTime);
            $formattedTime = $timeObject->format('h:i A'); // 12:27 PM

            $pdf->Cell(95, 10, $content['content'], 1, 0);
            $pdf->Cell(0, 10, $formattedTime, 1, 1);
        }
    } else {
        $pdf->Cell(0, 10, "No content available", 1, 1);
    }

    // Add some space between timeline entries
    $pdf->Ln(5);
}

// Output PDF
$pdf->Output('timeline.pdf', 'D'); // 'D' forces download

?>
