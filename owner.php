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

// Connect to PostgreSQL database
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
if (!$conn) {
  die("Connection failed. Error: " . pg_last_error());
}

// Perform query to fetch owner details based on username
$query = "SELECT user_name, oid,email,phone_no,move_in_date,flat_no FROM owners WHERE user_name = $1";
$result = pg_query_params($conn, $query, array($userName));

if (!$result) {
  die("Query failed. Error: " . pg_last_error($conn));
}

$ownerDetails = pg_fetch_assoc($result); // Assuming there's only one owner with the username

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Details</title>
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
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="owner-details">
    <h2>Owner Details</h2>
    <table>
      <tr>
        <th>Name</th>
        <td><?php echo $ownerDetails['user_name']; ?></td>
      </tr>
      <tr>
        <th>ID</th>
        <td><?php echo $ownerDetails['oid']; ?></td>
      </tr>
      <tr>
        <th>Flat Number</th>
        <td><?php echo $ownerDetails['flat_no']; ?></td>
      </tr>
      <tr>
        <th>Phone number</th>
        <td><?php echo $ownerDetails['phone_no']; ?></td>
      </tr>
      <tr>
        <th>Move_in_date</th>
        <td><?php echo $ownerDetails['move_in_date']; ?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo $ownerDetails['email']; ?></td>
      </tr>
      
    </table>
  </div>
</body>
</html>