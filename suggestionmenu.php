<!DOCTYPE html>
<html>
<head>
    <title>Menu Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Welcome to Menu Page</h1>
    <p>Choose an option:</p>
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

        $conn->close();
    }
    ?>
    <form method="post" action="http://localhost/extractproduct.php">
        <!-- Hidden input fields to pass usergender and totalincome to extract.php -->
        <input type="hidden" name="usergender" value="<?php echo $usergender; ?>">
        <input type="hidden" name="totalincome" value="<?php echo $totalincome; ?>">

        <input type="submit" name="choice" value="Product Suggestion">
    </form>
    <form method="post" action="http://localhost/extracttrip.php">
        <!-- Hidden input fields to pass usergender and totalincome to extracttrip.php -->
        <input type="hidden" name="usergender" value="<?php echo $usergender; ?>">
        <input type="hidden" name="totalincome" value="<?php echo $totalincome; ?>">

        <input type="submit" name="choice" value="Plan a Trip">
    </form>

    <!-- Section to display input data -->
    <h2>Information Provided:</h2>
    <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?></td>
        </tr>
        <tr>
            <td>Source of Income</td>
            <td><?php echo isset($_POST['sourceincome']) ? $_POST['sourceincome'] : ''; ?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?php echo isset($_POST['usergender']) ? $_POST['usergender'] : ''; ?></td>
        </tr>
        <tr>
            <td>Total Income</td>
            <td id="totalincome"><?php echo isset($_POST['totalincome']) ? $_POST['totalincome'] : ''; ?></td>
        </tr>
        <tr>
            <td>Payment Type</td>
            <td><?php echo isset($_POST['paytype']) ? $_POST['paytype'] : ''; ?></td>
        </tr>
        <tr>
            <td>Deducted Tax</td>
            <td id="taxAmount">Calculate Tax</td>
        </tr>
    </table>

    <!-- Script to calculate tax -->
    <script>
        function calculateTax() {
            const income = parseFloat(document.getElementById("totalincome").textContent);
            let tax = 0;

            if (income <= 250000) {
                tax = 0;
            } else if (income > 250000 && income <= 300000) {
                tax = (income - 250000) * 0.05;
            } else if (income > 300000 && income <= 500000) {
                tax = (300000 - 250000) * 0.05 + (income - 300000) * 0.1;
            } else if (income > 500000 && income <= 600000) {
                tax = (300000 - 250000) * 0.05 + (600000 - 500000) * 0.1;
            } else if (income > 600000 && income <= 900000) {
                tax = (300000 - 250000) * 0.05 + (600000 - 500000) * 0.1 + (income - 600000) * 0.15;
            } else if (income > 900000 && income <= 1000000) {
                tax = (300000 - 250000) * 0.05 + (600000 - 500000) * 0.1 + (1000000 - 900000) * 0.15;
            } else if (income > 1000000 && income <= 1200000) {
                tax = (300000 - 250000) * 0.05 + (600000 - 500000) * 0.1 + (1200000 - 1000000) * 0.15;
            } else if (income > 1200000 && income <= 1500000) {
                tax = (300000 - 250000) * 0.05 + (600000 - 500000) * 0.1 + (1500000 - 1200000) * 0.2;
            } else {
                tax = (300000 - 250000) * 0.05 + (600000 - 500000) * 0.1 + (1500000 - 1200000) * 0.2 + (income - 1500000) * 0.3;
            }

            document.getElementById("taxAmount").textContent = "Rs. " + tax.toFixed(2);
        }

        calculateTax(); // Calculate tax when the page loads
    </script>
</body>
</html>
