<?php
    include 'db.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Prepare and execute the SQL query
        $sql = "SELECT email, request_type, created_at FROM service_requests_no_fk WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        // Bind variables to prepared statement
        $stmt->bind_result($email, $request_type, $created_at);

        // Fetch and display results
        echo '<div class="response-container">';
        while ($stmt->fetch()) {
            echo "<div class='response'>";
            echo "<p><strong>$created_at</strong></p>";
            echo "<p>Email: $email</p>";
            echo "<p>Request Type: $request_type</p>";
            echo "<hr>";
            echo "</div>";
        }
        echo '</div>';

        $stmt->close();
    } else {
        echo "______________________..You need to log in to see your service requests.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Responses</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/dffba75db4.js" crossorigin="anonymous"></script>

    <style>
           * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Open Sans', sans-serif;
}
body {
    height: 50vh;
    background-color: #000;
    background-image: url();
    background-size: cover;
    background-position: center;
}
li {
    list-style: none;
}
a {
    text-decoration: none;
    color: #fff;
    font-size: 1rem;
}
a:hover {
    color: orange;
}
header {
    position: relative;
    padding: 0 2rem;
}
.navbar {
    position: fixed; 
    top: 0; 
    width: 100%; 
    height: 60px;
    max-width: 1500px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: rgba(0, 0, 0, 0.8); 
    z-index: 1000; 
}
.navbar .logo a {
    font-size: 1.5rem;
    font-weight: bold;
}
.logo {
    margin-top: 20px;
}
.navbar .links {  
    display: flex;
    gap: 40px;
    padding-left: 600px;
    font-size: 45px;
}
.navbar .toggle_btn {
    color: #fff;
    font-size: 1.5rem;
    cursor: pointer;
    display: none;
}
#mainarea {
    display: block;
    padding: 15px;
    text-align: left;
}
.response-container {
    width: 75%;
    max-width: 800px; /* Add a max-width for better control */
    margin: 100px auto; /* Centering the container */
    background-color: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    
}
.response {
    margin-bottom: 20px;
}
.response p {
    margin: 5px 0;
}
.response hr {
    border: 1px solid #ddd;
}
.btn-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .btn {
      background-color: black;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 10px;
    }
    .btn:hover {
      background-color: #013220;
    }
    @import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);

@import url(https://fonts.googleapis.com/css?family=Titillium+Web:300);
.fa-2x {
    font-size: 2em;
}
.fa {
    position: relative;
    display: table-cell;
    width: 60px;
    height: 36px;
    text-align: center;
    vertical-align: middle;
    font-size: 20px;
}

.main-menu:hover, nav.main-menu.expanded {
    width: 250px;
    overflow: visible;
}

.main-menu {
    background: #212121;
    border-right: 1px solid #e5e5e5;
    position: absolute;
    top: 0;
    bottom: 0;
    height: 100%;
    left: 0;
    width: 60px;
    overflow: hidden;
    -webkit-transition: width .05s linear;
    transition: width .05s linear;
    -webkit-transform: translateZ(0) scale(1, 1);
    z-index: 1000;
}

.main-menu>ul {
    margin: 100px 0;
}
.main-menu>ul>li {
margin-bottom: 40px; /* Increase this value to add more space */
}


.main-menu li {
    position: relative;
    display: block;
    width: 250px;
}

.main-menu li>a {
    position: relative;
    display: table;
    border-collapse: collapse;
    border-spacing: 0;
    color: #999;
    font-family: arial;
    font-size: 18px;
    text-decoration: none;
    -webkit-transform: translateZ(0) scale(1, 1);
    -webkit-transition: all .1s linear;
    transition: all .1s linear;
}

.main-menu .nav-icon {
    position: relative;
    display: table-cell;
    width: 60px;
    height: 36px;
    text-align: center;
    vertical-align: middle;
    font-size: 30px;
}

.main-menu .nav-text {
    position: relative;
    display: table-cell;
    vertical-align: middle;
    width: 190px;
    font-family: 'Titillium Web', sans-serif;
}

.main-menu>ul.logout {
    position: absolute;
    left: 0;
    bottom: 0;
}

.no-touch .scrollable.hover {
    overflow-y: hidden;
}

.no-touch .scrollable.hover:hover {
    overflow-y: auto;
    overflow: visible;
}

a:hover, a:focus {
    text-decoration: none;
}

nav {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}

nav ul, nav li {
    outline: 0;
    margin: 0;
    padding: 0;
}

.main-menu li:hover>a, nav.main-menu li.active>a, .dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus, .dropdown-menu>.active>a, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>a:focus, .no-touch .dashboard-page nav.dashboard-menu ul li:hover a, .dashboard-page nav.dashboard-menu ul li.active a {
    color: #fff;
    background-color: #000000;
}

.area {
    float: left;
    background: #e2e2e2;
    width: 100%;
    height: 100%;
}

@font-face {
    font-family: 'Titillium Web';
    font-style: normal;
    font-weight: 300;
    src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff');
}
        /* Your existing styles */

        /* Footer styles */
        footer {
    background-color: #fff; /* White background for the footer */
    color: #000; /* Black text color */
    text-align: center;
    padding: 20px 0;
    margin-top: 70px;
    position: relative;
    width: 100%;
    bottom: 0;
}

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .footer-container .social-icons a {
    margin: 0 10px;
    color: #000; /* Black color for the icons */
    font-size: 24px;
}

        .footer-container .contact-info {
            margin-top: 20px;
        }

        .footer-container .contact-info p {
            margin: 5px 0;
        }
        .social-icons a {
    margin: 0 10px;
    color: #000; /* Change this to black or any other color */
    font-size: 24px;
}


        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-container .social-icons {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<div id="mainarea">
   <!-- Your existing content -->
</div>

<nav class="main-menu">
  <ul>
    <li>
        <a href="https://jbfarrow.com">
            <i class="fa fa-home fa-2x"></i>
            <span class="nav-text">Return Home</span>
        </a>
    </li>
    <li class="has-subnav">
        <a href="#">
            <i class="fa fa-globe fa-2x"></i>
            <span class="nav-text">About Page</span>
        </a>
    </li>
    <li class="has-subnav">
        <a href="#">
            <i class="fa fa-comments fa-2x"></i>
            <span class="nav-text">View Your Requests</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fa fa-phone fa-2x"></i>
            <span class="nav-text">Customer Service</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fa fa-star-o fa-2x"></i>
            <span class="nav-text">Service List</span>
        </a>
    </li>
    <li>
        <a href="#">
            <i class="fa fa-folder-open fa-2x"></i>
            <span class="nav-text">Back to login</span>
        </a>
    </li>
  </ul>
</nav>

<!-- Footer -->
<footer>
    <div class="footer-container">
        <div class="social-icons">
            <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="contact-info">
        <p><a href="">ssssss</a></p>
            <p>Kindly Drop A Review At -<a href=""><span style="color:black;">Glassdoor.com :/ </span></a></p>
            <p><a href="">sssss</a></p>
        </div>
    </div>
</footer>

</body>
</html>
