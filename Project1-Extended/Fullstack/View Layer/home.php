<?php
session_start();
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
            </nav>
        </div>
        <div class="name" style="margin-top: 25px;">
            <h1 style="margin: 0;">Popular Products</h1>
        </div>

        <div class="shopping-container">
            <div class="product-container">
                <div class="product" data-name="iPhone 15" draggable="true" data-price="1200" ondragstart="drag(event)">
                    <img  src="data:image/jpeg;base64,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">
                    <h3>iPhone 15</h3>
                    <p>$1,200.00</p>
                </div>  
                <div class="product"  data-name="MacBook Air" draggable="true" data-price="1300" ondragstart="drag(event)">
                    <img src="https://m.media-amazon.com/images/I/71nXzKOZRuL.jpg">
                    <h3>MacBook Air</h3>
                    <p>$1,300.00</p>
                </div>
                <div class="product"  data-name="Samsung Galaxy A06" draggable="true" data-price="240" ondragstart="drag(event)">
                    <img src="https://cellularsavings.ca/cdn/shop/files/Samsung-Galaxy-A06-Light-Blue_480x480.jpg?v=1727987813">
                    <h3>Samsung Galaxy A06</h3>
                    <p>$240.00</p>
                </div>
                <div class="product"  data-name="Apple Watch SE" draggable="true" data-price="330" ondragstart="drag(event)">
                    <img src="https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/MYJ33ref_VW_34FR+watch-case-40-aluminum-starlight-nc-se_VW_34FR+watch-face-40-aluminum-starlight-se_VW_34FR?wid=752&hei=720&bgc=fafafa&trim=1&fmt=p-jpg&qlt=80&.v=L1VPMlk5ZkpkOVFZR3Fud25vckh4RStGZUJWLzNFUFVydllxZFp0d1M4NktoaXQwYi9wRGFOV2FsZVA1S1dYc3U0MnNvUmFpbmpuWFJpcHZlcmRSWXdScEJ3QjIyVnl6dGRLV0ozWGQvU3RmSGlnNkpTM1NGVHN6YWcySEw0THd4cVNUNDJadDNVSmRncE9SalAvZ24zZmdHMUt6VFlqa3BpV2VBOUNycGdrcDIxSk5peW5HTWQ0c004MmJwMkNtdGl6SHg4ZE5NYmlWSVQ5akRTdGpCYXdFcFI4ZnVKTUUyODRESjZvdEp1NA">
                    <h3>Apple Watch SE</h3>
                    <p>$330.00</p>
                </div>
                <div class="product"  data-name="Apple iPad" draggable="true" data-price="440" ondragstart="drag(event)">
                    <img src="https://m.media-amazon.com/images/I/61uA2UVnYWL._AC_UF894,1000_QL80_.jpg">
                    <h3>Apple iPad</h3>
                    <p>$440.00</p>
                </div>
            </div>
            <div style="bottom: 8.5%; right: 20px;" id="cart-button" onclick="toggleCart()" class="<?php echo isset($_SESSION['user_id']) ? '' : 'disabled-cart'; ?>" >
                🛒 Cart
            </div>

            <div id="cart-container" style="max-height: 70%; overflow-y: auto; border: 1px solid #ccc;">
                <h3 id="cart-title">Shopping Cart</h3>
                <!-- Cart Table -->
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
