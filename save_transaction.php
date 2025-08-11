<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Buyer details
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $payment = $_POST['payment_method'];

    // Save buyer
    $conn->query("INSERT INTO buyers (name, address, contact_number, email) VALUES ('$name','$address','$contact','$email')");
    $buyer_id = $conn->insert_id;

    // Save transaction
    $conn->query("INSERT INTO transactions (buyer_id, payment_method) VALUES ($buyer_id, '$payment')");
    $transaction_id = $conn->insert_id;

    // Save items
    foreach ($_POST['product_name'] as $i => $product) {
        $qty = $_POST['quantity'][$i];
        $price = $_POST['unit_price'][$i];
        $conn->query("INSERT INTO transaction_items (transaction_id, product_name, quantity, unit_price) 
                      VALUES ($transaction_id, '$product', $qty, $price)");
    }

    header("Location: bill.php?id=$transaction_id");
}
?>
