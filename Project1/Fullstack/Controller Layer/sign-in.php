<?php
session_start();

include '../Model/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to select the user by email
    $stmt = $conn->prepare("SELECT user_id, name, password FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_name, $db_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $db_password)) {
            // Store user info in session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $db_name;

            // Redirect to the home page or dashboard
            header('Location: ../View Layer/home.php'); // Redirect after successful login
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
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
        </style>
    </head>
    <body>
        <div id="nav-container">
            <h2 id="logo">Electro</h2>
            <nav>
                <a href="../View Layer/home.php">Home</a>
                <a href="../View Layer/about-us.php">About Us</a>
                <a href="./sign-in.php" class="active">Sign In</a>
                <a href="./register.php">Sign Up</a>
                <a href="../View Layer/review.php">Reviews</a>
                <a href="#services">Types of Services</a>
            </nav>
        </div>
        <div class="container">
            <div class="form-container">
                <h2>Sign In</h2>
                <!-- The form submits to the same page -->
                <form action="sign-in.php" method="POST" id="signIn">
                    <input type="email" id="email" name="email" placeholder="Email Address *" required>
                    <input type="password" id="password" name="password" placeholder="Password *" required>
                    
                    <button type="submit">Sign In</button>
            
                    <div class="footer">
                        <p>Don't have an account? <a href="sign-up.html">Sign Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
