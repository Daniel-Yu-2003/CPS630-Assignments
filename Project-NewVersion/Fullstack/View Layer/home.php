<?php
session_start();
include '../Model/db.php'; // Ensure this file contains database connection ($conn)

if (isset($_GET['message'])) {
    $redirect_url = "home.php";
    echo "<script>alert('" . $_GET['message'] . "'); window.location.href = '$redirect_url';</script>";
    exit();
}

$mode = "user";
if(isset($_SESSION['user_id'])){
    $userId = $_SESSION["user_id"];
    $query = $conn->prepare("SELECT mode FROM Users WHERE user_id = ?");
    $query->bind_param("i", $userId);
    $query->execute();
    $query->bind_result($mode);
    $query->fetch();
    $query->close();
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../styles.css">
        <style>
            .disabled-cart {
                pointer-events: none;
                opacity: 0.5;
            }
        </style>
    </head>
    <body style="min-height: 100vh; margin: 0; display: flex; justify-content: space-between; flex-direction: column;">
        <div id="nav-container">
            <h2 id="logo">Electro</h2>
            <nav>
                <a href="./home.php" class="active">Home</a>
                <a href="./about-us.php">About Us</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Profile</a>
                    <a href="./logout.php">Log Out</a>
                <?php else: ?>
                    <a href="../Controller Layer/sign-in.php">Sign In</a>
                    <a href="../Controller Layer/register.php">Sign Up</a>
                <?php endif; ?>
                <a href="./review.php">Reviews</a>
                <a href="#services">Services</a>

                <!-- Show CRUD link at the end only if user is logged in -->
                <?php if(isset($_SESSION['user_id']) && $mode === 'admin'):?>
                    <a href="../Controller Layer/CRUD.php">
                        <img style="width: 25px; vertical-align: middle;" src="../../Images/database_15458462.png" alt="Database Icon" />
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        <div class="name" style="margin-top: 25px;">
            <h1 style="margin: 0;">Popular Products</h1>
        </div>

        <div class="shopping-container">
            <div class="product-container">
                <?php 
                $sql = "SELECT * FROM Items";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product" data-name="' . htmlspecialchars($row["item_name"]) . '" draggable="true" data-price="' . $row["item_price"] . '" ondragstart="drag(event)">';
                        echo '<img src="' . htmlspecialchars($row["item_image"]) . '" alt="' . htmlspecialchars($row["item_name"]) . '">';
                        echo '<h3>' . htmlspecialchars($row["item_name"]) . '</h3>';
                        echo '<p>$' . number_format($row["item_price"], 2) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No products available.</p>';
                }
                ?>
            </div>
            <div style="bottom: 8.5%; right: 20px;" id="cart-button" onclick="toggleCart()" class="<?php echo isset($_SESSION['user_id']) ? '' : 'disabled-cart'; ?>" >
                🛒 Cart
            </div>

            <div id="cart-container" style="max-height: 70%; overflow-y: auto; border: 1px solid #ccc;">
                <h3 id="cart-title">Shopping Cart</h3>
                <table id="cartcontent" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items"></tbody>
                </table>
                
                <h4 id="subtotal">Subtotal: $0</h4>
                <button id="checkout-btn" onclick="toMap()">Proceed to Delivery</button>
                <h5>Click on an item to remove</h5>
                <div id="cart" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <p>Drop items here</p>
                </div> 
            </div>        
        </div>
        <footer style="position: relative; background-color:#333; color:white; text-align:center; padding:30px; bottom:0; width:100%;">
            <div id="browser-info"></div>    
        </footer>
    </body>
    <script src="../../script.js"></script>
    <script src="../../browserDetect.js"></script>
    <script>
        function toMap(){
            localStorage.setItem('cart', JSON.stringify(cart));
            window.location.replace("../../map.html")
        }
    </script>
</html>
