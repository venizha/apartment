<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden; 
            background-size: cover;
        }

        #login-box {
            width:20%;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #login-box input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }

        #login-button, #signup-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; 
        }

        #login-button:hover, #signup-button:hover {
            background-color: #45a049;
        }
    </style>
    <title>Login and Signup Page</title>
</head>
<body>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['user_name'];
   
    $password = $_POST['password'];

  
    $databaseConnection = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=Keerthi23");

    if (!$databaseConnection) {
        die("Connection failed. Error: " . pg_last_error($databaseConnection));
    }

    if (isset($_POST['login'])) {
       
        $result = pg_query_params($databaseConnection, 'SELECT user_name, password FROM tenants WHERE user_name = $1 AND password = $2', array($name, $password));

        if (!$result) {
            die("Query failed. Error: " . pg_last_error($databaseConnection));
        }

        $numRows = pg_num_rows($result);

        if ($numRows > 0) {
            $_SESSION['password'] = $password;
            
            // Redirect based on the first character of the password
            $firstChar = substr($password, 0, 1);
            if ($firstChar === 't') {
                header("Location: tenant_details.html");
                exit();
            } elseif ($firstChar === 'o') {
                header("Location: owner.html");
                exit();
            } else {
                // Default redirect or error handling if needed
                header("Location: resident.php");
                exit();
            }
        } else {
            echo '<script>alert("Invalid. Please provide correct credentials."); window.location.href = "resident.php";</script>';
            exit();
        }
    } 

    pg_close($databaseConnection);
}
?>

    
    <img src="log1.jpg" alt="Background Image" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">

    <div id="login-box">
        <h2 id="form-title">Tenant-LOGIN</h2>
        <form action="newlogin1.php" method="post">
            <input type="text" name="name" placeholder="name" required><br><br>
            <input type="number" name="user_id" placeholder="user_id" required><br><br>
            <input type="text" name="password" placeholder="password" required><br><br>
            <input type="submit" name="login" value="Login"  id="login-button">
            
        </form>
        <button name="signup" value="Sign Up" id="signup-button" onclick="func_sign_in()">Sign Up</button>
    </div>
    <script>
    function func_sign_in(){  
        window.location.href = 'participatesigninpage.php';
    }  
    </script>
</body>
</html>
