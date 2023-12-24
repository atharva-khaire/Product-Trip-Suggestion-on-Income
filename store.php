<?php
// MySQL connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taxcollection"; // Updated database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a message variable
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $useremail = $_POST["useremail"];
    $userage = $_POST["userage"];
    $userpassword = $_POST["userpassword"];
    $usergender = $_POST["usergender"];
    $pannum = $_POST["pannum"];
    $sql = "INSERT INTO users (username, userage, usergender, useremail, userpassword, pannum)
            VALUES ('$username', '$userage', '$usergender', '$useremail', '$userpassword', '$pannum')";

    if ($conn->query($sql) === TRUE) {
        // Registration Successful message
        $message = "Registration Successful!";
        echo '<style>
                /* Your CSS styles here */
                body {
                    font-family: Arial, sans-serif;
                }
                .container {
                    max-width: 400px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                }
                .registration-message {
                    /* Your additional styles for the success message */
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: #4CAF50;
                    color: white;
                    text-align: center;
                    padding: 20px;
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                    z-index: 1000;
                }
                .tick-mark {
                    font-size: 40px;
                    margin-bottom: 10px;
                }
                @keyframes fadeOut {
                    0% {
                        opacity: 1;
                    }
                    100% {
                        opacity: 0;
                        display: none;
                    }
                }
            </style>';

        // Add the redirection code here
        $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'epaytax.html';
        header("Location: $redirect_url");
        exit;
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
