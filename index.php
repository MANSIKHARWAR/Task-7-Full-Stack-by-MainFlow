<!DOCTYPE html>
<html>
<head>
    <title>New Transaction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!DOCTYPE html>
<html>
<head>
    <title>New Transaction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>New Transaction</h1>
    <form action="save_transaction.php" method="POST">
        
        <h3>Buyer Details</h3>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="address" placeholder="Address">
        <input type="text" name="contact" placeholder="Contact">
        <input type="email" name="email" placeholder="Email">

        <label>Payment Method</label>
        <select name="payment_method">
            <option value="Cash">Cash</option>
            <option value="Card">Card</option>
            <option value="UPI">UPI</option>
        </select>

        <h3>Products</h3>
        <div id="items">
            <div class="item-row">
                <input type="text" name="product_name[]" placeholder="Product Name" required>
                <input type="number" name="quantity[]" placeholder="Qty" required>
                <input type="number" step="0.01" name="unit_price[]" placeholder="Price" required>
                <button type="button" class="remove-btn" onclick="removeItem(this)">❌</button>
            </div>
        </div>

        <button type="button" class="add-btn" onclick="addItem()">+ Add Item</button>

        <button type="submit" class="submit-btn">Save Transaction</button>
    </form>
</div>

<script>
function addItem() {
    let newItem = `
        <div class="item-row">
            <input type="text" name="product_name[]" placeholder="Product Name" required>
            <input type="number" name="quantity[]" placeholder="Qty" required>
            <input type="number" step="0.01" name="unit_price[]" placeholder="Price" required>
            <button type="button" class="remove-btn" onclick="removeItem(this)">❌</button>
        </div>`;
    document.getElementById('items').insertAdjacentHTML('beforeend', newItem);
}

function removeItem(button) {
    button.parentElement.remove();
}
</script>

</body>
</html>
