<?php
session_start();
include '../Model/db.php';

// Handle Create Operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];
    $image = $_POST['item_image'];
    
    $stmt = $conn->prepare("INSERT INTO Items (item_name, item_price, item_image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $image);
    $stmt->execute();
    header("Location: CRUD.php?message=Item added successfully");
    exit();
}

// Handle Delete Operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Items WHERE item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: CRUD.php?message=Item deleted successfully");
    exit();
}

// Fetch Items
$result = $conn->query("SELECT * FROM Items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        .form-group {
            display: flex;
            align-items: center; 
            gap: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .form-group label {
            flex: 1; 
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: start;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 0;
        }

        .form-group input {
            flex: 3; 
            height: 40px;
            padding: 8px;
            border-radius: 5px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div id="nav-container">
        <h2 id="logo">Electro</h2>
        <nav>
            <a href="../View Layer/home.php">Home</a>
            <a href="../View Layer/about-us.php">About Us</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="../View Layer/profile.php">Profile</a>
                <a href="../View Layer/logout.php">Log Out</a>
            <?php else: ?>
                <a href="../Controller Layer/sign-in.php">Sign In</a>
                <a href="../Controller Layer/register.php">Sign Up</a>
            <?php endif; ?>
            <a href="../View Layer/review.php">Reviews</a>
            <a href="#services">Services</a>

            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="../Controller Layer/CRUD.php" class="active">
                    <img style="width: 25px; vertical-align: middle;" src="../../Images/database_15458462.png" alt="Database Icon" />
                </a>
            <?php endif; ?>
        </nav>
    </div>
    <div class="container mt-5">
        <h2 style="margin-bottom: 35px;">Manage Items</h2>
        
        <!-- Display Message -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"> <?php echo htmlspecialchars($_GET['message']); ?> </div>
        <?php endif; ?>
        
        <!-- Create Item Form -->
        <form method="POST">
            <div class="form-group">
                <label>Item Name:</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Item Price:</label>
                <input type="number" step="0.01" name="item_price" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Item Image URL:</label>
                <input type="text" name="item_image" class="form-control" required>
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
                <button type="submit" name="create" class="btn btn-primary">Add Item</button>
            </div>

        </form>
        
        <h3 class="mt-4" style="margin: 24px 0;">Item List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td>$<?php echo number_format($row['item_price'], 2); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['item_image']); ?>" width="50"></td>
                        <td>
                            <a href="CRUD.php?delete=<?php echo $row['item_id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <footer>
        <div id="browser-info">Electro Store - All Rights Reserved</div>    
    </footer>
</body>
<script src="../../browserDetect.js"></script>
</html>