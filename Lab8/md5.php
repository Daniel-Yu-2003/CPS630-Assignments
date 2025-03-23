<?php

function insertUser($username,$password){
    $pdo = new PDO('mysql:host=localhost;dbname=lab8;charset=utf8', 'root', '');
    $sql = "INSERT INTO Users(Username,Password) 
            VALUES(?,?)";
    $smt = $pdo->prepare($sql);
    $smt->execute(array($username,md5($password))); //execute the query
}

function validateUser($username,$password){
    $pdo = new PDO('mysql:host=localhost;dbname=lab8;charset=utf8', 'root', '');
    $sql = "SELECT UserID FROM Users WHERE Username=? AND
          Password=?";
    $smt = $pdo->prepare($sql);
    $smt->execute(array($username, md5($password))); //execute the query
    if($smt->rowCount()){
      return true; //record found, return true.
    }
    return false; //record not found matching credentials, return false
  }

if (isset($_POST['logout'])) {
    session_destroy();
    echo "Logged Out";
}

else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($_POST["submit"])) {
        insertUser($username, $password);
    }

    else {
        if (validateUser($username, $password)) {
            $_SESSION['user'] = $username;
            echo "Logged In";
        }

        else {
            echo "Wrong Username or Password";
        }
    }
}



?>

<!DOCTYPE html>

<html>
    <body>
        <header>Add Account</header>
        <form method="post">
            <input type="text" name="username" placeholder="Username Here">
            <input type="text" name="password" placeholder="Password Here">
            <button type="submit" name="submit">Submit</button>
        </form>

        <br><br><br>

        <header>Login</header>
        <form method="post">
            <input type="text" name="username" placeholder="Username Here">
            <input type="text" name="password" placeholder="Password Here">
            <button type="submit" name="login">Login</button>
        </form>

        <br><br><br>

        <header>Logout</header>
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>

    </body>
</html>