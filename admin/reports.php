<!DOCTYPE html>
<html lang="en">
<?php
// Initialize $result variable
$result = null;

// Check if form is submitted
if (isset($_POST['filter'])) {
    // Establish database connection
    $db = mysqli_connect("localhost", "root", "", "online_food_order");
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get start date and end date from form input
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch data from users_orders table based on selected date range
    $sql = "SELECT * FROM users_orders WHERE date BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($db, $sql);

    // Close database connection
    mysqli_close($db);
}
?>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-JzWNRpU8jw2rZ5IXuZN0s3bDQMbLBbm5+khT0BYTl7MyBjCcoYK3GPG2H6XcgwYr" crossorigin="anonymous">
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container label {
            font-weight: bold;
            margin-right: 10px;
        }

        .form-container input[type="date"] {
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        .form-container button {
            padding: 8px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .no-data {
            text-align: center;
            color: #888;
        }

        .download-button {
            text-align: center;
            margin-top: 20px;
        }

        .download-button button {
            padding: 10px 20px;
            background-color: #2196f3;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .download-button button:hover {
            background-color: #0b7dda;
        }

        .back-button {
            background-color: #4caf50;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <a href="dashboard.php" class="back-button">
        <i class="fas fa-arrow-left">Back</i>
    </a>

    <h1>Sales Report</h1>

    <div class="form-container">
        <form method="post">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
            <button type="submit" name="filter">Filter</button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['filter'])) {
                // Establish database connection
                $db = mysqli_connect("localhost", "root", "", "online_food_order");
                if (!$db) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Get start date and end date from form input
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                // Fetch data from users_orders table based on selected date range
                $sql = "SELECT * FROM users_orders WHERE date BETWEEN '$start_date' AND '$end_date'";
                $result = mysqli_query($db, $sql);

                $total_quantity = 0;
                $total_price = 0;

                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        $row_total_price = $row["price"] * $row["quantity"];
                        $total_quantity += $row["quantity"];
                        $total_price += $row_total_price;
                        echo "<tr>
                <td>" . $row["o_id"] . "</td>
                <td>" . $row["u_id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>" . $row["quantity"] . "</td>
                <td>Rp. " . number_format($row_total_price, 0, ',', '.') . "</td>
                <td>" . $row["date"] . "</td>
              </tr>";
                    }

                    // Output total quantity and total price
                    echo "<tr>
            <td colspan='3'><strong>Total</strong></td>
            <td><strong>" . $total_quantity . "</strong></td>
            <td><strong>Rp. " . number_format($total_price, 0, ',', '.') . "</strong></td>
            <td></td>
          </tr>";
                } else {
                    echo "<tr><td colspan='6'>No sales data available for selected date range</td></tr>";
                }

                // Close database connection
                mysqli_close($db);
            }
            ?>



        </tbody>
    </table>
    <?php if (isset($_POST['filter']) && mysqli_num_rows($result) > 0) : ?>
        <div class="download-button">
            <form method="post" action="generate_pdf.php" target="_blank">
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
                <button type="submit">Download PDF</button>
            </form>
        </div>
    <?php endif; ?>
</body>

</html>