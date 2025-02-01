<?php
session_start();
include 'db.php'; // Database connection

// Initialize session storage for artwork records if it doesn't exist
if (!isset($_SESSION['artwork'])) {
    $_SESSION['artwork'] = [];
}

// Handle Save Record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $genre = $_POST['genre'] ?? "";
    $type = $_POST['type'] ?? "";
    $subject = $_POST['subject'] ?? "";
    $specification = $_POST['specification'] ?? "";
    $museum = $_POST['museum'] ?? "";
    $year = $_POST['year'] ?? "";

    // Validate required fields
    if (empty($genre) || empty($type) || empty($specification) || empty($museum) || empty($year)) {
        echo "<p style='color: red;'>Error: One or more fields are missing.</p>";
    } elseif ($type === "Painting" && empty($subject)) {
        echo "<p style='color: red;'>Error: Subject is required for paintings.</p>";
    } else {
        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO artwork (genre, type, subject, specification, museum, year) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $genre, $type, $subject, $specification, $museum, $year);

        // Execute the statement
        if ($stmt->execute()) {
            // Save to session as well
            $_SESSION['artwork'][] = [
                'genre' => $genre,
                'type' => $type,
                'subject' => $subject,
                'specification' => $specification,
                'museum' => $museum,
                'year' => $year
            ];
            echo "<p style='color: green;'>New artwork record saved successfully.</p>";
        } else {
            // If execution fails, print the error
            echo "<p style='color: red;'>SQL Error: " . $stmt->error . "</p>";
        }
        $stmt->close();  // Close the statement
    }
}


// Handle Clear Records (reset session array)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear'])) {
    $_SESSION['artwork'] = [];
    echo "<p style='color: blue;'>All records cleared.</p>";
}

// Retrieve a specific record by index
$recordToDisplay = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['index'])) {
    $index = (int) $_GET['index'];  // Ensure it's treated as an integer
    if ($index >= 0) {  // Ensure the index is valid
        // Query to fetch the record at the specific index
        $sql = "SELECT * FROM artwork LIMIT $index, 1";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $recordToDisplay = $result->fetch_assoc();
        } else {
            $recordToDisplay = "No record found at index $index.";
        }
    }
}

// Fetch all records from the database
$sql = "SELECT * FROM artwork";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Work Database</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Art Work Database</h1>
        <p>Our collection features over 500 pieces spanning various art movements, including Renaissance masterpieces, Baroque sculptures, Gothic religious works, and modern Abstract pieces. This collection showcases art works from different periods and provides insight into the evolution of artistic expression. The collection has continued to grow, and it includes diverse genres, types, and specifications.</p>
    </div>

    <div class="form-section">
        <div class="form-column">
            <form id="artForm" action="artwork.php" method="post">
                <h3>Genre:</h3>
                <select name="genre" required>
                    <option value="">Select Genre</option>
                    <option>Abstract</option>
                    <option>Baroque</option>
                    <option>Gothic</option>
                    <option>Renaissance</option>
                </select>

                <h3>Type:</h3>
                <select name="type" id="typeSelect" required>
                    <option value="">Select Type</option>
                    <option value="Painting">Painting</option>
                    <option value="Sculpture">Sculpture</option>
                </select>

                <div id="subjectGroup" style="display: none;">
                    <h3>Subject:</h3>
                    <select name="subject">
                        <option value="Landscape">Landscape</option>
                        <option value="Portrait">Portrait</option>
                    </select>
                </div>

                <h3>Specification:</h3>
                <select name="specification" required>
                    <option value="">Select Specification</option>
                    <option>Commercial</option>
                    <option>Non-commercial</option>
                    <option>Derivative Work</option>
                    <option>Non-Derivative Work</option>
                </select>

                <h3>Museum:</h3>
                <input type="text" name="museum" required>

                <h3>Year:</h3>
                <input type="number" name="year" min="1000" max="<?= date('Y') ?>" required>
                
                <button type="submit" name="save" value="1">Save Record</button>
                <button type="submit" name="clear">Clear Record</button>
            </form>
        </div>

        <div class="form-column">
            <h3>Current Art Work Record:</h3>
            <div id="recordDisplay">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
                    echo "<p><strong>Genre:</strong> $genre</p>";
                    echo "<p><strong>Type:</strong> $type</p>";
                    if ($type == "Painting") {
                        echo "<p><strong>Subject:</strong> $subject</p>";
                    }
                    echo "<p><strong>Specification:</strong> $specification</p>";
                    echo "<p><strong>Museum:</strong> $museum</p>";
                    echo "<p><strong>Year:</strong> $year</p>";
                }
                ?>
            </div>

            <h3>Retrieve a Record:</h3>
            <form method="get">
                <input type="number" name="index" placeholder="Enter index" required>
                <button type="submit">Display</button>
            </form>

            <?php if ($recordToDisplay !== null): ?>
                <h3>Record at index:</h3>
                <?php if (is_array($recordToDisplay)): ?>
                    <p><strong>Genre:</strong> <?= $recordToDisplay['genre'] ?></p>
                    <p><strong>Type:</strong> <?= $recordToDisplay['type'] ?></p>
                    <?php if ($recordToDisplay['type'] == "Painting"): ?>
                        <p><strong>Subject:</strong> <?= $recordToDisplay['subject'] ?></p>
                    <?php endif; ?>
                    <p><strong>Specification:</strong> <?= $recordToDisplay['specification'] ?></p>
                    <p><strong>Museum:</strong> <?= $recordToDisplay['museum'] ?></p>
                    <p><strong>Year:</strong> <?= $recordToDisplay['year'] ?></p>
                <?php else: ?>
                    <p><?= $recordToDisplay ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#subjectGroup').hide();
        $('#typeSelect').change(function(){
            if($(this).val() === "Painting"){
                $('#subjectGroup').show();
            } else {
                $('#subjectGroup').hide();
            }
        });
    });
</script>

</body>
</html>
