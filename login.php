<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }
        
        .login-form {
            width: 300px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            margin: 100px auto;
            padding: 20px;
            text-align: center;
        }
        
        .login-form h2 {
            margin-bottom: 20px;
        }
        
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }
        
        .login-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            cursor: pointer;
        }
        
        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .login-form .error-message {
            color: #ff0000;
            margin-bottom: 10px;
        }
        
        .success-message {
            margin-top: 20px;
        }
        
        .proceed-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }
        
        .proceed-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                // Validate username and password here...
                // Your authentication logic goes here...
                
                if ($username == "admin" && $password == "password") {
                    // Successful login
                    echo "<p class='success-message'>Login successful!</p>";
                    echo "<a href='records.php' class='proceed-button'>Click here to proceed</a>";
                    exit; // Stop further execution of the script
                } else {
                    // Invalid login
                    echo "<p class='error-message'>Invalid username or password.</p>";
                }
            } else {
                // Required fields are not filled
                echo "<p class='error-message'>Please fill in both username and password fields.</p>";
            }
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
