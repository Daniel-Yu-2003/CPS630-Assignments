<?php
session_start();
include '../Model/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: sign-in.php"); // Redirect if not logged in
    exit();
}

$userId = $_SESSION["user_id"];
$query = $conn->prepare("SELECT name, email, address, phone, balance, city_code FROM Users WHERE user_id = ?");
$query->bind_param("i", $userId);
$query->execute();
$query->bind_result($name, $email, $address, $phone, $balance, $cityCode);

if (!$query->fetch()) {
    echo "Error Retrieving Data";
    exit();
}

$query->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            background-color: #f8f9fa;
        }
        .container {
            flex: 1;
        }
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            margin-top: 30px;
            padding: 20px;
        }
        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 500px;
            padding: 40px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: scale(1.03);
        }
        .profile-card p {
            font-size: 18px;
            margin: 15px 0;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease-in-out;
        }
        .delete-button:hover {
            background-color: #b02a37;
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
            <a href="./home.php">Home</a>
            <a href="./about-us.php">About Us</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="active">Profile</a>
                <a href="./logout.php">Log Out</a>
            <?php else: ?>
                <a href="../Controller Layer/sign-in.php">Sign In</a>
                <a href="../Controller Layer/register.php">Sign Up</a>
            <?php endif; ?>
            <a href="./review.php">Reviews</a>
            <a href="#services">Services</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="../Controller Layer/CRUD.php">
                    <img style="width: 25px; vertical-align: middle;" src="../../Images/database_15458462.png" alt="Database Icon" />
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <h3>My Profile</h3>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Address:</strong> <?php echo $address; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Balance:</strong> $<?php echo number_format($balance, 2); ?></p>
            <p><strong>City Code:</strong> <?php echo $cityCode; ?></p> 
            <button class="delete-button" onclick="confirmDelete()">Delete My Account</button>
        </div>
    </div>

    <footer>
        <div id="browser-info"></div>    
    </footer>
    <script src="../../browserDetect.js"></script>
    <script>
        function confirmDelete() {
            let confirmation = confirm("Are you sure you want to delete your account? This action cannot be undone.");
            if (confirmation) {
                window.location.href = "../Controller Layer/delete_account.php";
            }
        }
    </script>
</body>
</html>
