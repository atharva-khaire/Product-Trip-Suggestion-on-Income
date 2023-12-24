<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taxcollection";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $useremail = $_POST["useremail"];
    $userpassword = $_POST["userpassword"];

    // Check for empty fields
    if (empty($useremail) || empty($userpassword)) {
        // Handle empty fields
        header("Location: loginfailed.html");
        exit;
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT userpassword FROM users WHERE useremail = ?");
    $stmt->bind_param("s", $useremail);
    
    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($userpassword, $hashed_password)) {
                // Password is correct, redirect to ePaytax.html
                header("Location: ePaytax.html");
                exit;
            } else {
                // Password is incorrect, redirect to loginfailed.html
                header("Location: loginfailed.html");
                exit;
            }
        } else {
            // User does not exist, redirect to loginfailed.html
            header("Location: loginfailed.html");
            exit;
        }
    } else {
        // Database error
        $response = ["success" => false, "message" => "Database Error"];
        echo json_encode($response);
    }

    $stmt->close();
}

$conn->close();
?>
