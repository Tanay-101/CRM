<?php
include 'db.php';
session_start();

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM customers WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id, $hashed_password);
            if ($stmt->fetch() && password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                echo "<script>
                        alert('Login successful!');
                        window.location.href='store_response.php';
                      </script>";
                exit(); // Ensure no further processing happens
            } else {
                $responseMessage = "Invalid username or password.";
            }
        } else {
            $responseMessage = "Error executing statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $responseMessage = "Error preparing statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            font-family: poppins;
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
    </style>
    <div class="form-box">
        <div class="wrapper">
            <div class="img-area">
                <img src="cover2.jpg" alt="Cover Image">
            </div>
            <div class="form-area">
                <h3>Login Again Please</h3>
                <form method="POST" action="login2.php">
                    <div class="single-form">
                        <input type="text" name="username" placeholder="Username" id="username" required>
                    </div>
                    <div class="single-form">
                        <input type="password" name="password" placeholder="Password" id="password" required>
                    </div>
                    <input type="submit" value="Login" class="btn" id="submit">
                </form>
                <p class="message"><?php echo $responseMessage; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
