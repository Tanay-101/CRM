<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery with Dynamic Text</title>
    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        .container {
            padding: 75px 0;
            margin: 0 auto;
            width: 1140px;
        }
        
        h1 {
            margin-bottom: 45px;
            font-family: 'Oswald', sans-serif;
            font-size: 44px;
            text-transform: uppercase;
            color: #424242;
        }
        
        .gallery-wrap {
            display: flex;
            flex-direction: row;
            width: 100%;
            height: 70vh;
        }
        
        .item {
            flex: 1;
            height: 100%;
            background-position: center;
            background-size: cover;
            background-repeat: none;
            transition: flex 0.8s ease;
            position: relative;
        }
        
        .item:hover {
            flex: 7;
        }
        
        .overlay-text {
            color: white;
            font-family: Arial, sans-serif;
            font-size: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            text-align: center;
            pointer-events: none;
        }
        
        .item-1 { background-image: url('https://images.unsplash.com/photo-1499198116522-4a6235013d63?auto=format&fit=crop&w=1233&q=80'); }
        .item-2 { background-image: url('https://images.unsplash.com/photo-1492760864391-753aaae87234?auto=format&fit=crop&w=1336&q=80'); }
        .item-3 { background-image: url('https://images.unsplash.com/photo-1503631285924-e1544dce8b28?auto=format&fit=crop&w=1234&q=80'); }
        .item-4 { background-image: url('https://images.unsplash.com/photo-1510425463958-dcced28da480?auto=format&fit=crop&w=1352&q=80'); }
        .item-5 { background-image: url('https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=1234&q=80'); }
        .item-6 { background-image: url('https://images.unsplash.com/photo-1499198116522-4a6235013d63?auto=format&fit=crop&w=1233&q=80'); }
        .item-7 { background-image: url('https://images.unsplash.com/photo-1492760864391-753aaae87234?auto=format&fit=crop&w=1336&q=80'); }
        
        .social {
            position: absolute;
            right: 35px;
            bottom: 0;
        }
        
        .social img {
            display: block;
            width: 32px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gallery</h1>
        <div class="gallery-wrap">
            <div class="item item-1">
                <div class="overlay-text"></div>
            </div>
            <div class="item item-2">
                <div class="overlay-text"></div>
            </div>
            <div class="item item-3">
                <div class="overlay-text"></div>
            </div>
            <div class="item item-4">
                <div class="overlay-text"></div>
            </div>
            <div class="item item-5">
                <div class="overlay-text"></div>
            </div>
            <div class="item item-6">
                <div class="overlay-text"></div>
            </div>
            <div class="item item-7">
                <div class="overlay-text"></div>
            </div>
        </div>
    </div>

    <div class="social">
        <a href="https://twitter.com/StefCharle" target="_blank">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/149103/twitter.svg" alt="">
        </a>
    </div>

    <?php
    include 'db.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Prepare and execute the SQL query
        $sql = "SELECT request_type FROM service_requests_no_fk WHERE user_id = ? LIMIT 7";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        // Bind variables to prepared statement
        $stmt->bind_result($request_type);

        // Fetch and display results
        $services = [];
        while ($stmt->fetch()) {
            $services[] = $request_type;
            echo "<p>Fetched Service: " . htmlspecialchars($request_type) . "</p>";
        }

        // Insert the fetched service types into the overlay text divs
        for ($i = 0; $i < 7; $i++) {
            $serviceText = isset($services[$i]) ? htmlspecialchars($services[$i]) : "Service " . ($i + 1);
            echo "<script>
                document.querySelector('.item-" . ($i + 1) . " .overlay-text').innerText = '$serviceText';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<p>You need to log in to see your service requests.</p>";
    }
    ?>
</body>
</html>
