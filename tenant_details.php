<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: resident.php");
    exit();
}

$userName = $_SESSION['user_name'];

$dbhost = 'localhost';
$dbname = 'postgres';
$dbuser = 'postgres';
$dbpass = 'Keerthi23';


$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
    die("Connection failed. Error: " . pg_last_error());
}

$query = "SELECT user_name,tid, email, rent_amt, move_in_date, phone_no, flat_no FROM tenants WHERE user_name = $1";
$result = pg_query_params($conn, $query, array($userName));

if (!$result) {
    die("Query failed. Error: " . pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
         
        }
            
        
        table {
            width: 50%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: black;
        }
        .tenant-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .tenant-details h2 {
            margin-bottom: 16px;
        }
        .tenant-details table {
            width: 50%;
            margin-bottom: 20px;
        }
        .tenant-details th, .tenant-details td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
          
        }
        .tenant-details th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="tenant-details">
        <h2>Tenant Details</h2>
        <table>
            <tr>
                <th> Name</th>
                <td><?php echo $userName; ?></td>
            </tr>
            <?php
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<td>" . $row['tid'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Email</th>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Rent Amount</th>";
                echo "<td>Rs." . $row['rent_amt'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Move-in Date</th>";
                echo "<td>" . $row['move_in_date'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Phone Number</th>";
                echo "<td>" . $row['phone_no'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>Flat Number</th>";
                echo "<td>" . $row['flat_no'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
