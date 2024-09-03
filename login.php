<?php
include 'db.php';
session_start();

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id, $stored_password);
            if ($stmt->fetch() && $password === $stored_password) {
                $_SESSION['user_id'] = $user_id;
                echo "<script>
                alert('Login successful!');
                window.location.href='trade.php';
              </script>";
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
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }
        body {
            font-family: poppins;
            background: url(background3.jpg);
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
</head>
<body>
    <div class="form-box">
        <div class="wrapper">
        <div class="img-area">
                <img src="cover3.jpg" alt="Cover Image">
            </div>
            <?php if ($responseMessage): ?>
                <div class="form-area">
                    <h3><?php echo $responseMessage; ?></h3>
                    <?php if (isset($continueSurfing) && $continueSurfing): ?>
                        <div class="continue-surfing">
                            <h3>Welcome!!</h3>
                            <a href="dashboard.php" style="color: white; font-size: 20px;">View Dashboard</a>
                            <a href="chart.php" style="color: white; font-size: 20px;">View Service Charts</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="form-area">
                    <h3>Login</h3>
                    <form method="POST" action="login.php">
                        <div class="single-form">
                            <label for="username"></label>
                            <input type="text" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="single-form">
                            <label for="password"></label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="single-form">
                            <input type="submit" value="Login">
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
