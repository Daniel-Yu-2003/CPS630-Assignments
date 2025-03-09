<?php
session_start();

include '../Model/db.php';

$userId = $_SESSION["user_id"];
$query = $conn->prepare("SELECT name, email, address, phone, city_code FROM Users WHERE user_id=$userId");
$query->execute();
$query->bind_result($name, $email, $address, $phone, $cityCode);

if ($query->fetch()) {
    //user data found
}

else {
    echo "Error Retrieving Data";
    exit();
}

$query->close();

$totalPrice = null;
$dateIssued = null;
$dateReceived = null;
$paymentCode = null;
$tripId = null;
$receiptId = null;

$query2 = $conn->prepare("INSERT INTO Orders (user_id, total_price, date_issued, date_received, payment_code, trip_id, receipt_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$query2->bind_param("idsssii", $userId, $totalPrice, $dateIssued, $dateReceived, $paymentCode, $tripId, $receiptId);
if ($query2->execute()) {
    $orderId = $conn->insert_id;
}

$query2->close();
$conn->close();
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../styles.css">
    </head>
    <body>
        <h1 style="margin-top:50px">Invoice Summary</h1>
        <div class="row justify-content-center">
            <div class="col-4" style="text-align:left">
                <h4>From</h4>
                <p>Electro</p>
                <p>Yonge Dundas Square</p>
            </div>
            <div class="col-4" style="text-align:right">     
                <h4>To</h4>
                <p> <?php echo $name; ?> </p>
                <p> <?php echo $email; ?> </p>
                <p id="address"></p>    
                <p> <?php echo $phone; ?> </p>
                <p> <?php echo $cityCode; ?> </p>   
            </div>
        </div>
        <br>
        <p>Order Number: #<?php echo $orderId?></p>
        <p>Date: 04 March 2025</p>

        <table class="table table-bordered" style="max-width:80%; margin: 0 auto; margin-top:50px">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="cart-items"></tbody>
        </table>
        
        <h3 id="subtotal-invoice" style="margin-top:50px"></h3>
        <h3 id="tax-invoice"></h3>
        <h3 id="total-invoice"></h3>
        
        <a href="../../checkout.html">Confirm Payment</a><br>
        <a href="../../payment.html">Return to payment</a><br>
        <a href="home.php">Return to home</a>
        <script src="script.js">
            displayInvoiceSummary();
        </script>
        <script>
            const address = localStorage.getItem('address');
            const cvv = localStorage.getItem('cvv')
            document.getElementById("address").innerHTML = address;

            function displayInvoiceSummary(){
                const cart = JSON.parse(localStorage.getItem('cart'));
                const cartSummary = document.getElementById('cart-items');
                let subtotal = 0;

                Object.keys(cart).forEach((itemName) => {
                    let item = cart[itemName];
                    subtotal += item.price * item.quantity;

                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${itemName}</td>
                        <td>${item.quantity}</td>
                        <td>$${item.price.toFixed(2)}</td>
                    `;
                    cartSummary.appendChild(row);
                });
                document.getElementById("subtotal-invoice").innerText = `Subtotal: $${subtotal.toFixed(2)}`;
                document.getElementById("tax-invoice").innerText = `Tax: $${(subtotal*0.13).toFixed(2)}`;
                document.getElementById("total-invoice").innerText = `Total: $${((subtotal*0.13)+subtotal).toFixed(2)}`;
            }

            displayInvoiceSummary();
        </script>
    </body>
</html>