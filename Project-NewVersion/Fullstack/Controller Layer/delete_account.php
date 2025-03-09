<?php
session_start();
include '../Model/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: sign-in.php");
    exit();
}

$userId = $_SESSION["user_id"];

// Start a transaction for safety
$conn->begin_transaction();

try {
    // Delete user account
    $deleteUser = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
    $deleteUser->bind_param("i", $userId);
    $deleteUser->execute();

    if ($deleteUser->affected_rows > 0) {
        // Commit the transaction
        $conn->commit();
        
        // Destroy session and log the user out
        session_destroy();

        // Redirect to the home page with a success message
        header("Location: ../View Layer/home.php?message=Account deleted successfully.");
        exit();
    } else {
        throw new Exception("Failed to delete account.");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
