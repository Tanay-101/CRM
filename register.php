<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO customers (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            // Successful registration, redirect to login page
            header("Location: login2.php?message=thanks for registering please login again");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: url(background2.jpg);
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        .form-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            width: 800px;
            height: 500px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }
        .img-area {
            flex: 1;
            padding: 20px;
            text-align: center;
        }
        .img-area img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .form-area {
            flex: 1;
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }
        .form-area h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .single-form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
                text-align: center;
                height: auto;
                width: auto;
            }
            .img-area, .form-area {
                flex: none;
            }
            .img-area {
                margin-bottom: 20px;
            }
        }
    </style>
    <div class="form-box">
        <div class="wrapper">
            <div class="img-area">
                <img src="cover2.jpg" alt="Image">
            </div>
            <div class="form-area">
                <h3>Register</h3>
                <form method="POST" action="register.php">
                    <div class="single-form">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="single-form">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="single-form">
                        <input type="submit" value="Register" class="btn" id="submit">
                    </div>
                </form>
                <a href="login2.php" class="btn-secondary" id="tap">Already a member? Login</a>
            </div>
        </div>
    </div>
</body>
</html>
