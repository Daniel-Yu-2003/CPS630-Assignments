<html>
    <body>
    <?php echo '<p>Hello World</p>';?>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testnew";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully<br>";
        
        //sql to create table
        $sql = "CREATE TABLE StRec (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            reg_date TIMESTAMP
            )";
        
        if ($conn->query($sql) === TRUE) {
            echo "Table Student Records created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        $sql = "INSERT INTO StRec(firstname, lastname, email, reg_date) VALUES ('John', 'Cook', 'johncook@school.ca', '2004-02-08')";

        if ($conn->query($sql) === TRUE) {
            echo "Records added successfully<br>";
        } else {
            echo "Error adding record: " . $conn->error;
        }

        $sql = "SELECT * FROM StRec";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<br> id Name email reg date";
            while($row = $result->fetch_assoc()) {
                echo "<br>".$row["id"]. " ". $row["firstname"]. " " . $row["lastname"] . "  ". $row["email"] . "  ". $row["reg_date"];
            }
        } else {
            echo "No results ";
        }

        $sql = "DROP TABLE StREC";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Table dropped successfully<br>";
        } else {
            echo "Error dropping table: " . $conn->error;
        }

    ?> 
    </body>
</html>