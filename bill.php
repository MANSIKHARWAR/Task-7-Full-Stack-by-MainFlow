<?php
include 'db.php';
$id = $_GET['id'];

$sql = "SELECT t.*, b.name, b.address, b.contact_number, b.email
        FROM transactions t
        JOIN buyers b ON t.buyer_id = b.buyer_id
        WHERE t.transaction_id = $id";
$transaction = $conn->query($sql)->fetch_assoc();
$items = $conn->query("SELECT * FROM transaction_items WHERE transaction_id = $id");

$subtotal = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bill #<?php echo $id; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>LAMA GEMS</h1>
    <p>B 23 Jewelry Street, Delhi| Phone: +91-9923342343</p>
</header>

<div class="details">
    <p><b>Buyer:</b> <?php echo $transaction['name']; ?><br>
    <b>Address:</b> <?php echo $transaction['address']; ?><br>
    <b>Contact:</b> <?php echo $transaction['contact_number']; ?><br>
    <b>Email:</b> <?php echo $transaction['email']; ?></p>
</div>

<div class="details">
    <p><b>Transaction ID:</b> <?php echo $transaction['transaction_id']; ?><br>
    <b>Date:</b> <?php echo $transaction['purchase_date']; ?><br>
    <b>Payment:</b> <?php echo $transaction['payment_method']; ?></p>
</div>

<table>
    <tr>
        <th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Total</th>
    </tr>
    <?php while($row = $items->fetch_assoc()): 
        $total = $row['quantity'] * $row['unit_price'];
        $subtotal += $total;
    ?>
    <tr>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td>₹<?php echo number_format($row['unit_price'], 2); ?></td>
        <td>₹<?php echo number_format($total, 2); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<div class="summary">
    <b>Subtotal: ₹<?php echo number_format($subtotal, 2); ?></b><br>
    <b>Total Amount Due: ₹<?php echo number_format($subtotal, 2); ?></b>
</div>

<div class="buttons">
    <button onclick="window.print()">🖨 Print</button>
    <a class="button" href="pdf_bill.php?id=<?php echo $id; ?>">⬇ Download PDF</a>
    <button type="button" onclick="toggleDarkMode()">🌙 Toggle Dark Mode</button>

</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark');
    localStorage.setItem('darkMode', document.body.classList.contains('dark'));
}

// Load saved preference
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark');
}
</script>

</body>
</html>
