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
           
        }

        #background-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
         
            z-index: -1; 
        }

        #login-box {
            background: rgba(255, 255, 255, 0.8);
            width: 30%;
            height: 30%;
            padding: 80px 50px;
            padding-top:40px;
            border-radius: 10px;
            text-align: center;
            z-index: 1; 
        }

        #login-box select, #login-box input {
            width: 50%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }

        #login-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <title>Login Page</title>
</head>
<body>

    <img id="background-img" src="loginpage.jpg" alt="Background Image">

    <div id="login-box">
        <h2>Login</h2>
        <form id="login-form">
         
            <input type="email" id="email" placeholder="ENTER YOUR EMAIL" required>
            <select id="user-type" name="userType" required>
                <option value="" disabled selected>SELECT USER TYPE</option>
                <option value="admin">ADMIN</option>
                <option value="resident">RESIDENT</option>
                <option value="staff">STAFF</option>
              
            </select>
            <br>
            <input type="submit" id="login-button" value="Login">
        </form>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault(); 
            var userType = document.getElementById('user-type').value;
            if (userType === 'admin') {
                window.location.href = 'newlogin1.php'; 
            } else if (userType === 'resident') {
                window.location.href = 'resident.php'; 
            } else if (userType === 'staff') {
                window.location.href = 'newlogin3.php'; 
            }
           
        });
    </script>

</body>
</html>