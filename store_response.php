<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $email = $_POST['email'];
    $request_type = $_POST['requesttype'];

    // Proceed with the insert
    $sql = "INSERT INTO service_requests_no_fk (user_id, email, request_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iss", $user_id, $email, $request_type);

        if ($stmt->execute()) {
            // Redirect to thankyou.html after successful insertion
            header("Location: thankyou.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo '<div class="smessage">You need to login first to store your service requests.</div>';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Request</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dffba75db4.js" crossorigin="anonymous"></script>
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
        input[type="email"], select {
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
        input[type="submit"]:hover {
            background-color: #013220;
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
            <img src="cover2.jpg" alt="Image">
        </div>
        <div class="form-area">
            <h3>Service Request</h3>
            <form action="store_response.php" method="post">
                <div class="single-form">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="single-form">
                    <select id="requesttype" name="requesttype" required>
                        <option value="video-editing">Video Editing</option>
                        <option value="web-software">Web-based Software</option>
                        <option value="graphic-designing">Graphic Designing</option>
                        <option value="content-writing">Content Writing</option>
                        <option value="data-entry">Data Entry</option>
                        <option value="data-cleaning">Data Cleaning</option>
                        <option value="sales-services">Sales Services</option>
                    </select>
                </div>
                <input type="submit" value="Submit Request" class="btn" id="submit">
                <br><br>
                <a href="http://localhost/crm/index.html#design" class="btn-secondary" id="tap" style="color:white; text-decoration: underline;text-decoration-color: white;">Want to know more? Check our services out!</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
