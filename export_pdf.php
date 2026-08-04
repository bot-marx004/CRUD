<?php
require_once 'config/database.php';
require_once 'fpdf.php';

// Get search parameter if any
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch products
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM products 
                           WHERE name LIKE ? 
                           OR brand LIKE ? 
                           OR model LIKE ? 
                           ORDER BY created_at DESC");
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
}

$products = $stmt->fetchAll();

// Custom PDF class
class PDF extends FPDF {
    // Page header
    function Header() {
        // Dark header background
        $this->SetFillColor(15, 12, 41);
        $this->Rect(0, 0, 297, 42, 'F');
        
        // Title - moved up to avoid overlap
        $this->SetY(10);
        $this->SetFont('Arial', 'B', 24);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 12, ' Phone Store - Product List', 0, 1, 'C');
        
        // Subtitle with date - moved up
        $this->SetY(26);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(200, 200, 220);
        $this->Cell(0, 6, 'Generated: ' . date('F d, Y h:i A'), 0, 1, 'C');
        
        // Decorative line - moved down to avoid overlap
        $this->SetY(48);
        $this->SetDrawColor(102, 126, 234);
        $this->Line(10, 48, 287, 48);
        
        // Reset text color for body
        $this->SetTextColor(0, 0, 0);
    }
    
    // Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 170);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' | © Phone Store', 0, 0, 'C');
    }
}

// Create PDF (Landscape, A4)
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// ─── SUMMARY INFO ───
// Move content down to avoid overlapping the header line
$pdf->SetY(58);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(20, 20, 50);
$pdf->Cell(0, 10, 'Product Inventory Report', 0, 1, 'L');

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(80, 80, 100);
$pdf->Cell(0, 6, 'Total Products: ' . count($products) . ' | Filter: ' . (!empty($search) ? htmlspecialchars($search) : 'All Products'), 0, 1, 'L');
$pdf->Ln(4);

// ─── TABLE HEADER ───
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(12, 10, '#', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Product Name', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Brand', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Model', 1, 0, 'C', true);
$pdf->Cell(28, 10, 'Price', 1, 0, 'C', true);
$pdf->Cell(18, 10, 'Stock', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'RAM / Storage', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Color', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Description', 1, 1, 'C', true);

// ─── TABLE DATA ───
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

$totalStock = 0;
$totalValue = 0;
$fill = false;

foreach ($products as $index => $product) {
    // Alternate row colors
    if ($fill) {
        $pdf->SetFillColor(248, 249, 250);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }
    $fill = !$fill;
    
    // Row number
    $pdf->Cell(12, 8, $index + 1, 1, 0, 'C', true);
    
    // Product Name (with truncation)
    $name = $product['name'];
    if (strlen($name) > 20) $name = substr($name, 0, 18) . '...';
    $pdf->Cell(45, 8, $name, 1, 0, 'L', true);
    
    // Brand
    $pdf->Cell(30, 8, $product['brand'], 1, 0, 'L', true);
    
    // Model
    $pdf->Cell(25, 8, $product['model'], 1, 0, 'L', true);
    
    // Price (with $ and proper formatting)
    $pdf->Cell(28, 8, '$' . number_format($product['price'], 2), 1, 0, 'R', true);
    
    // Stock (with color indicator)
    $stockText = $product['stock'] > 0 ? $product['stock'] : 'OUT';
    $pdf->Cell(18, 8, $stockText, 1, 0, 'C', true);
    
    // Specs
    $specs = '';
    if ($product['ram'] && $product['storage']) {
        $specs = $product['ram'] . ' / ' . $product['storage'];
    } elseif ($product['ram']) {
        $specs = $product['ram'];
    } elseif ($product['storage']) {
        $specs = $product['storage'];
    } else {
        $specs = '—';
    }
    $pdf->Cell(40, 8, $specs, 1, 0, 'L', true);
    
    // Color
    $pdf->Cell(25, 8, $product['color'] ?? '—', 1, 0, 'L', true);
    
    // Description (truncated)
    $desc = $product['description'] ?? '';
    if (strlen($desc) > 40) {
        $desc = substr($desc, 0, 37) . '...';
    }
    $pdf->Cell(60, 8, $desc, 1, 1, 'L', true);
    
    $totalStock += $product['stock'];
    $totalValue += $product['price'] * $product['stock'];
}

// ─── SUMMARY SECTION ───
$pdf->Ln(8);
$pdf->SetFillColor(240, 244, 248);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(20, 20, 50);

$pdf->Cell(0, 10, ' Summary', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(60, 9, 'Total Products: ' . count($products), 0, 0, 'L');
$pdf->Cell(60, 9, 'Total Stock: ' . $totalStock, 0, 0, 'L');
$pdf->Cell(80, 9, 'Total Inventory Value: $' . number_format($totalValue, 2), 0, 1, 'L');

// ─── FOOTER MESSAGE ───
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetTextColor(150, 150, 170);
$pdf->Cell(0, 6, 'This report was generated automatically by Phone Store System.', 0, 1, 'C');
$pdf->Cell(0, 6, '@' . date('Y') . ' Phone Store. All rights reserved.', 0, 1, 'C');

// ─── OUTPUT PDF ───
$filename = 'Product_List_' . date('Y-m-d_H-i-s') . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

$pdf->Output($filename, 'D');
exit;
?>