<?php
require 'vendor/autoload.php';
include 'db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Get transaction ID safely
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid transaction ID");
}

// Fetch transaction with prepared statement
$stmt = $conn->prepare("
    SELECT t.*, b.name, b.address, b.contact_number, b.email
    FROM transactions t
    JOIN buyers b ON t.buyer_id = b.buyer_id
    WHERE t.transaction_id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$transaction = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$transaction) {
    die("Transaction not found");
}

// Fetch items
$stmt = $conn->prepare("SELECT * FROM transaction_items WHERE transaction_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$items = $stmt->get_result();

// Build HTML with CSS
$subtotal = 0;
$html = "
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h2 { text-align: center; margin-bottom: 10px; }
    .details { margin-bottom: 15px; }
    table { border-collapse: collapse; width: 100%; }
    table, th, td { border: 1px solid #000; }
    th, td { padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .total { text-align: right; font-size: 14px; font-weight: bold; margin-top: 10px; }
</style>

<h2>LAMA GEMS</h2>

<div class='details'>
    <p>
        <b>Buyer:</b> {$transaction['name']}<br>
        <b>Address:</b> {$transaction['address']}<br>
        <b>Contact:</b> {$transaction['contact_number']}<br>
        <b>Email:</b> {$transaction['email']}
    </p>
    <p>
        <b>Transaction ID:</b> {$transaction['transaction_id']}<br>
        <b>Date:</b> {$transaction['purchase_date']}<br>
        <b>Payment:</b> {$transaction['payment_method']}
    </p>
</div>

<table>
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Unit Price (₹)</th>
        <th>Total (₹)</th>
    </tr>";

while ($row = $items->fetch_assoc()) {
    $total = $row['quantity'] * $row['unit_price'];
    $subtotal += $total;
    $html .= "
    <tr>
        <td>{$row['product_name']}</td>
        <td>{$row['quantity']}</td>
        <td>" . number_format($row['unit_price'], 2) . "</td>
        <td>" . number_format($total, 2) . "</td>
    </tr>";
}

$html .= "</table>
<p class='total'>Total Amount Due: ₹" . number_format($subtotal, 2) . "</p>
";

// Generate PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("bill-$id.pdf", ["Attachment" => 1]);
