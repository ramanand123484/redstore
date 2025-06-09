<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "redstore"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Prepare the SQL query with placeholders
    $sql = "INSERT INTO user (username, email, phone, password, address) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters (sssss means 5 string values)
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $password, $address);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to login page
            header("Location: products.html");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);

?>
