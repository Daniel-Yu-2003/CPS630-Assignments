<?php

function generateRandomSalt(){
    return base64_encode(random_bytes(12));
}

// Insert the user with the password salt generated, stored, and
// password hashed
function insertUser($username,$password){
    $pdo = new PDO('mysql:host=localhost;dbname=lab8;charset=utf8', 'root', '');
    $salt = generateRandomSalt();
    $sql = "INSERT INTO Users(Username,Password,Salt)
                VALUES(?,?,?)";
    $smt = $pdo->prepare($sql);
    $smt->execute(array($username,md5($password.$salt),$salt));
}

function validateUser($username,$password){
    $pdo = new PDO('mysql:host=localhost;dbname=lab8;charset=utf8', 'root', '');
    $sql = "SELECT Password, Salt FROM Users WHERE Username=?";
    $smt = $pdo->prepare($sql);
    $smt->execute(array($username)); //execute the query
    if($smt->rowCount()){
        $user = $smt->fetch(PDO::FETCH_ASSOC);
        $checkedPassword = $user['Password'];
        $salt = $user['Salt'];

        if (md5($password.$salt) === $checkedPassword) {
            return true; //record found, return true.
        }
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