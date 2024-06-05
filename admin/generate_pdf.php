<?php
require_once('TCPDF/tcpdf.php');

// Get start date and end date from form input
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Establish database connection
$db = mysqli_connect("localhost", "root", "", "online_food_order");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from users_orders table based on selected date range
$sql = "SELECT * FROM users_orders WHERE date BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($db, $sql);

if ($result !== false && mysqli_num_rows($result) > 0) {
    // Initialize total variables
    $totalSales = 0;
    $totalQuantity = 0;

    // Create new PDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Sales Report');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 14);

    // Title
    $pdf->Cell(0, 10, 'Sales Report', 0, 1, 'C');

    // Set font for table header
    $pdf->SetFont('helvetica', 'B', 10);

    // Header
    $pdf->Cell(30, 10, 'Order ID', 1, 0, 'C');
    $pdf->Cell(30, 10, 'User ID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Item ID', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Quantity', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total Price', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Order Date', 1, 1, 'C');

    // Set font for table data
    $pdf->SetFont('helvetica', '', 10);

    // Add data from database to the table
    $fill = false;
    while ($row = mysqli_fetch_assoc($result)) {
        // Increment total sales and quantity
        $totalSales += $row['price'];
        $totalQuantity += $row['quantity'];

        // Set fill color for alternating rows
        $pdf->SetFillColor(230, 230, 230); // Gray color
        $pdf->Cell(30, 10, $row["o_id"], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row["u_id"], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row["title"], 1, 0, 'C', $fill);
        $pdf->Cell(20, 10, $row["quantity"], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row["price"], 1, 0, 'C', $fill);
        // Use MultiCell for Date column
        $pdf->MultiCell(30, 10, $row["date"], 1, 'C', $fill);
        $fill = !$fill; // Switch fill color for next row
    }

    // Add total sales and quantity to the table
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(120, 10, 'Total Sales:', 1, 0, 'R');
    $pdf->Cell(30, 10, 'Rp.' . number_format($totalSales, 2), 1, 1, 'C');
    $pdf->Cell(120, 10, 'Total Quantity:', 1, 0, 'R');
    $pdf->Cell(30, 10, $totalQuantity, 1, 1, 'C');

    // Output PDF
    $pdf->Output('sales_report.pdf', 'I');
} else {
    echo "No sales data available for selected date range";
}

// Close database connection
mysqli_close($db);
