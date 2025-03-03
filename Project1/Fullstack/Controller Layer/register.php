<?php
include '../Model/db.php';

// Initialize error message variable
$error_message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST["password"];  
    $confirmPassword = $_POST['confirm-password'];

    // Check if the password and confirm password match
    if ($password === $confirmPassword) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username or email already exists in the database
        $stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ? OR name = ?");
        $stmt->bind_param("ss", $email, $username); // Check both email and username
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // If username or email already taken, set error message
            $error_message = "Username/Email already taken. Please choose another one.";
        } else {
            // Proceed with inserting the new user if no conflict
            $stmt = $conn->prepare("INSERT INTO Users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword); // Bind the hashed password

            if ($stmt->execute()) {
                echo "<script>
                        alert('User registration successful');
                        window.location.href = './sign-in.php';
                      </script>";
                exit();
            }
        }

        $stmt->close();
    } else {
        $error_message = "Passwords do not match.";
    }

    $conn->close();
}
?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../styles.css">
        <style>
            * {
                box-sizing: border-box;
            }

            .container {
                display: flex;
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
            }

            .form-container {
                background: rgba(255, 255, 255, 0.9); 
                padding: 30px;
                border-radius: 10px;
                width: 100%;
                max-width: 400px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .form-container h2 {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                color: #333;
            }

            .form-container input {
                width: 100%;
                padding: 12px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 16px;
                background-color: #f9f9f9;
                transition: all 0.3s ease;
            }

            .form-container input:focus {
                border-color: #f44336; 
                background-color: #fff;
            }

            .form-container button {
                width: 100%;
                padding: 12px;
                background-color: #f44336; 
                border: none;
                border-radius: 6px;
                color: white;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .form-container button:hover {
                background-color: #d32f2f; 
            }

            .form-container .footer {
                text-align: center;
                margin-top: 15px;
            }

            .form-container .footer a {
                text-decoration: none;
                color: #555;
                font-size: 14px;
                transition: color 0.3s ease;
            }

            .form-container .footer a:hover {
                color: #f44336; 
            }

            .form-container .error {
                color: #f44336;
                font-size: 14px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div id="nav-container">
            <h2 id="logo">Electro</h2>
            <nav>
                <a href="../View Layer/home.php">Home</a>
                <a href="../View Layer/about-us.php">About Us</a>
                <a href="./sign-in.php">Sign In</a>
                <a href="./register.php" class="active">Sign Up</a>
                <a href="../View Layer/review.php">Reviews</a>
                <a href="#services">Services</a>
            </nav>
        </div>
        <div class="container">
            <div class="form-container">
                <h2>Register</h2>
                <form action="./register.php" method="POST">
                    <input type="text" name="username" placeholder="Username *" required>
                    <input type="email" name="email" placeholder="Email Address *" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirm-password" placeholder="Confirm Password" required>
                    
                    <button type="submit">Register</button>

                    <?php if (!empty($error_message)): ?>
                        <div class="error" style="margin-top: 20px;">
                            <p><strong>Error:</strong> <?php echo $error_message; ?></p>
                        </div>
                    <?php endif; ?>
            
                    <div class="footer">
                        <a href="./sign-in.php">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
        <footer style="background-color:#333; color:white; text-align:center; padding:30px; bottom:0; width:100%;">
            <div id="browser-info"></div>    
        </footer>
    </body>
    <script src="../../browserDetect.js"></script>
</html>
