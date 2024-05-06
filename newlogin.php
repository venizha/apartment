<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['user_name'];
  $password = $_POST['password'];

  $dbhost = 'localhost';
  $dbname = 'postgres';
  $dbuser = 'postgres';
  $dbpass = 'Keerthi23';

  // Connect to PostgreSQL database
  $conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
  if (!$conn) {
    die("Connection failed. Error: " . pg_last_error());
  }

  // Check if the user exists in tenants table
  $queryTenants = "SELECT user_name FROM tenants WHERE user_name = $1 AND password = $2";
  $resultTenants = pg_query_params($conn, $queryTenants, array($username, $password));

  if (!$resultTenants) {
    die("Query failed. Error: " . pg_last_error($conn));
  }

  // Check if the user exists in owners table
  $queryOwners = "SELECT user_name FROM owners WHERE user_name = $1 AND password = $2";
  $resultOwners = pg_query_params($conn, $queryOwners, array($username, $password));

  if (!$resultOwners) {
    die("Query failed. Error: " . pg_last_error($conn));
  }

  // Check if user credentials match tenants or owners
  if (pg_num_rows($resultTenants) > 0) {
    // User is a tenant
    $_SESSION['user_name'] = $username; // Store username for tenant details retrieval
    $_SESSION['password'] = $password;
    header("Location: tenant_details.php");
    exit();
  } elseif (pg_num_rows($resultOwners) > 0) {
    // User is an owner
    $_SESSION['user_name'] = $username; // Store username for owner details retrieval
    $_SESSION['password'] = $password;
    header("Location: owner.php");
    exit();
  } else {
    // Invalid credentials
    echo '<script>alert("Invalid credentials. Please try again."); window.location.href = "resident.php";</script>';
    exit();
  }

  // Close database connection
  pg_close($conn);
}
?>