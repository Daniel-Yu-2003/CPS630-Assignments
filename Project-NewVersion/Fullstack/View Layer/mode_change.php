<?php
session_start();
include '../Model/db.php';

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    $user_id = $_SESSION["user_id"];
    
    $sql = "UPDATE users SET mode = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $mode, $user_id);
    
    if ($stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating mode: " . $conn->error;
    }
}

$conn->close();
?>