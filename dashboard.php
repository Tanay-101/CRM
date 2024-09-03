<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'grand');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT email, request_type FROM service_requests_no_fk";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/dffba75db4.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #000;
            color: #fff;
        }
        a {
            text-decoration: none;
            color: #fff;
        }
        a:hover {
            color: orange;
        }
        .navbar {
            position: fixed; 
            top: 0; 
            width: 100%; 
            height: 60px;
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
        .navbar .links {  
            display: flex;
            gap: 40px;
        }
        .main-content {
            padding: 80px 20px 20px 20px; 
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            color: #000;
        }
        .table-container {
    width: 70%; /* Reduce the table size by 30% */
    margin: 0 auto;
}

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            font-size: 14px;
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
    </style>
</head>
<body>
<header>
    <div class="navbar">
        <div class="links">
            <!-- Add any additional links here -->
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <h2>Service Requests</h2>
        <br><br>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Request Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['request_type']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No results found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<html>
<head>
</head>
<body>
    <div class="area"></div>
    <nav class="main-menu">
        <ul>
            <li>
                <a href="home.html">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Return Home
                    </span>
                </a>
            </li>
            <li class="has-subnav">
                <a href="about.html">
                    <i class="fa fa-globe fa-2x"></i>
                    <span class="nav-text">
                        About Page
                    </span>
                </a>
            </li>
            <li class="has-subnav">
                <a href="dashboard.php">
                    <i class="fa fa-comments fa-2x"></i>
                    <span class="nav-text">
                        View Dashboard
                    </span>
                </a>
            </li>
           
            <li>
                <a href="switch.php">
                    <i class="fa fa-bar-chart-o fa-2x"></i>
                    <span class="nav-text">
                    View Graph Analytics
                    </span>
                </a>
            </li>
            <li>
                <a href="service.html">
                    <i class="fa fa-star-o fa-2x"></i>
                    <span class="nav-text">
                        Service List
                    </span>
                </a>
            </li>
            <li>
                <a href="login.php">
                    <i class="fa fa-folder-open fa-2x"></i>
                    <span class="nav-text">
                        Back to login
                    </span>
                </a>
            </li>
            

        
    </nav>
    
</body>
</html>

</body>
</html>
