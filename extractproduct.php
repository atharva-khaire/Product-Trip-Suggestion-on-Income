<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        /* Your CSS styles here */
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4; /* Background color for the entire page */
            font-family: Arial, sans-serif;
        }
        
        .heading {
            text-align: center;
            font-size: 40px;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Text shadow for the heading */
            color: #333; /* Text color for the heading */
        }

        .full_page {
            display: flex;
            flex-direction: row;
            background-color: #fff; /* Background color for the left side */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Shadow for the left side */
        }

        .image-container {
            width: 65%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: #f9f9f9; /* Background color for the image container */
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .rest_page {
            display: flex;
            flex-direction: column;
            padding: 20px;
            background-color: #f9f9f9; /* Background color for the right side */
        }

        .description {
            margin-bottom: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Shadow for the description */
            padding: 20px;
            background-color: #fff; /* Background color for the description */
        }

        .buy-button {
            background-color: orange;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Shadow for the button */
            cursor: pointer; /* Add a pointer cursor to the button */
            transition: background-color 0.3s ease; /* Smooth background color transition on hover */
        }

        /* Add hover effect to the Buy button */
        .buy-button:hover {
            background-color: #ff6600; /* Darker orange on hover */
        }

    </style>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the values of usergender and totalincome from the form
        $usergender = $_POST["usergender"];
        $totalincome = $_POST["totalincome"];

        // Database connection setup
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "taxcollection";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Define variables to store the query range
        $startId = 1;
        $endId = 3;

        // Determine the query range based on totalincome
        if ($totalincome > 800000 && $totalincome <= 2000000) {
            $startId = 1;
            $endId = 3;
        } elseif ($totalincome > 2000000 && $totalincome <= 4000000) {
            $startId = 4;
            $endId = 6;
        } elseif ($totalincome > 4000000) {
            $startId = 7;
            $endId = 10;
        }
        if ($usergender == "Male") {
            $table = "menscollection";
        } else {
            $table = "womenscollection";
        }

        // Build and execute the SQL query with a random row within the specified range
        $sql = "SELECT imagename, image, description, link FROM $table WHERE id BETWEEN $startId AND $endId ORDER BY RAND() LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of the randomly selected row
            $row = $result->fetch_assoc();
    ?>
            <div class="heading"><b><?php echo $row["imagename"]; ?></b></div>
            <div class="full_page">
                <div class="image-container">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row["image"]); ?>" />
                </div>
                <div class="rest_page">
                    <div class="description">
                        <b>Description:</b><br>
                        <?php echo $row["description"]; ?>
                    </div>
                    <div>
                        <a class="buy-button" href="<?php echo $row["link"]; ?>">Buy Now</a>
                    </div>
                </div>
            </div>
    <?php
        } else {
            echo "No data found in the specified range.";
        }

        $conn->close();
    }
    ?>
</body>
</html>
