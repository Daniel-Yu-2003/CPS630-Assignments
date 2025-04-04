<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../styles.css">

    <style>
        .about-container {
            display: flex;
            flex-direction: column; 
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
   
        }

        /* Team member cards */
        .team-member {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            min-height: 250px; 
            padding: 15px 20px; 
            text-align: center;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center;
            margin: 10px 0; 
        }

        .team-member:hover {
            transform: scale(1.05);
        }

        .team-member h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }

        .team-member p {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px; 
        }

        .team-member .contact {
            font-size: 14px;
            color: #f44336;
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <div id="nav-container">
        <h2 id="logo">Electro</h2>
        <nav>
            <a href="./home.php">Home</a>
            <a href="./about-us.php" class="active">About Us</a>
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
    <div class="about-container">
        <!-- Team Member 1 -->
        <div class="team-member">
            <h3>Phat Nguyen</h3>
            <p>Currently 4th-year student at TMU. Loving swimming and playing music instruments.</p>
            <p class="contact">Email: phat.nguyen@torontomu.ca</p> 
        </div>

        <!-- Team Member 2 -->
        <div class="team-member">
            <h3>Daniel Yu</h3>
            <p>A fourth year student and Toronto Metropolitan University.</p>
            <p class="contact">Email: member2@example.com</p>
        </div>

        <!-- Team Member 3 -->
        <div class="team-member">
            <h3>Jordan Nguyen</h3>
            <p>4th year student. Big Mario Fan.</p>
            <p class="contact">Email: member3@example.com</p>
        </div>
    </div>
    <footer style="background-color:#333; color:white; text-align:center; padding:30px; bottom:0; width:100%;">
        <div id="browser-info"></div>    
    </footer>
</body>
<script src="../../browserDetect.js"></script>
</html>
