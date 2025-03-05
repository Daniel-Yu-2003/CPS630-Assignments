<?php
include './Model/db.php';
// Drop existing tables to avoid "already exists" errors
$sql = "DROP TABLE IF EXISTS Users, Items, Trips, Trucks, Orders, Shopping";
if ($conn->query($sql)) {
    echo "Existing tables dropped successfully<br>";
} else {
    echo "Error dropping tables: " . $conn->error . "<br>";
}

// Creating Trucks Table (this is referenced in Trips)
$sql = "CREATE TABLE Trucks (
    truck_id INT AUTO_INCREMENT PRIMARY KEY,
    truck_code VARCHAR(50),
    availability_code INT
)";
if ($conn->query($sql)) {
    echo "Trucks Table created successfully<br>";
} else {
    echo "Error creating Trucks Table: " . $conn->error . "<br>";
}

// Creating Shopping Table (this is referenced in Orders)
$sql = "CREATE TABLE Shopping (
    receipt_id INT AUTO_INCREMENT PRIMARY KEY,
    store_code INT,
    total_price DECIMAL(10, 2)
)";
if ($conn->query($sql)) {
    echo "Shopping Table created successfully<br>";
} else {
    echo "Error creating Shopping Table: " . $conn->error . "<br>";
}

// Creating Users Table
$sql = "CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    address TEXT,
    phone VARCHAR(15),
    balance DECIMAL(10, 2) DEFAULT 0.00,
    city_code INT
)";
if ($conn->query($sql)) {
    echo "Users Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Creating Items Table
$sql = "CREATE TABLE Items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255),
    price DECIMAL(10, 2),
    made_in VARCHAR(100),
    department_code INT
)";
if ($conn->query($sql)) {
    echo "Items Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Creating Trips Table (this references Trucks table)
$sql = "CREATE TABLE Trips (
    trip_id INT AUTO_INCREMENT PRIMARY KEY,
    source_code INT,
    destination_code INT,
    distance_km DECIMAL(10, 2),
    truck_id INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (truck_id) REFERENCES Trucks(truck_id)
)";
if ($conn->query($sql)) {
    echo "Trips Table created successfully<br>";
} else {
    echo "Error creating Trips Table: " . $conn->error . "<br>";
}

// Creating Orders Table (this references Users, Trips, and Shopping tables)
$sql = "CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10, 2),
    date_issued DATETIME,
    date_received DATETIME,
    payment_code VARCHAR(50),
    trip_id INT,
    receipt_id INT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (trip_id) REFERENCES Trips(trip_id),
    FOREIGN KEY (receipt_id) REFERENCES Shopping(receipt_id)
)";
if ($conn->query($sql)) {
    echo "Orders Table created successfully<br>";
} else {
    echo "Error creating Orders Table: " . $conn->error . "<br>";
}

// Closing connection
$conn->close();
?>
