<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dffba75db4.js" crossorigin="anonymous"></script>
  <title>Service Requests Data</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Open Sans', sans-serif;
    }
    body {
      height: 100vh;
      background-color: white;
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
    .message {
      color: blue;
      font-size: 20px;
      font-weight: bold;
    }
    .navbar {
      position: fixed;
      top: 0;
      width: 200%;
      height: 60px;
      max-width: 2000px;
      margin-right:200px
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
      padding-left: 500px;
      padding-right: 200px;
      font-size: 45px;
    }
    .navbar .toggle_btn {
      color: #fff;
      font-size: 1.5rem;
      cursor: pointer;
      display: none;
    }
    .graph {
      margin: 0 auto;
    }
    .chart-container {
      width: 800px;
      height: 400px;
      margin: 0 auto;
      padding-top: 100px;
      font-weight: bold;
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
      <button class="btn" onclick="switchToServiceData()">Switch to Service Data</button>
      <button class="btn" onclick="switchToTimeData()">Switch to Time Interval Data</button>
    </div>
  </div>
</header>

<?php 
  // Database connection
  $con = new mysqli('localhost', 'root', '', 'grand');
  if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
  }

  // Fetch request types and their counts
  $query1 = $con->query("
    SELECT 
      request_type,
      COUNT(*) as count
    FROM service_requests_no_fk
    GROUP BY request_type
  ");

  // Check if the query was successful
  if (!$query1) {
    die("Query Failed: " . $con->error);
  }

  $requestTypes = [];
  $requestCounts = [];
  foreach($query1 as $data)
  {
    $requestTypes[] = $data['request_type'];
    $requestCounts[] = $data['count'];
  }

  // Fetch the counts for service requests made in different time intervals
  $query2 = $con->query("
    SELECT 
        SUM(CASE WHEN HOUR(created_at) >= 0 AND HOUR(created_at) < 4 THEN 1 ELSE 0 END) AS time_0_4,
        SUM(CASE WHEN HOUR(created_at) >= 4 AND HOUR(created_at) < 8 THEN 1 ELSE 0 END) AS time_4_8,
        SUM(CASE WHEN HOUR(created_at) >= 8 AND HOUR(created_at) < 12 THEN 1 ELSE 0 END) AS time_8_12,
        SUM(CASE WHEN HOUR(created_at) >= 12 AND HOUR(created_at) < 16 THEN 1 ELSE 0 END) AS time_12_16,
        SUM(CASE WHEN HOUR(created_at) >= 16 AND HOUR(created_at) < 20 THEN 1 ELSE 0 END) AS time_16_20,
        SUM(CASE WHEN HOUR(created_at) >= 20 AND HOUR(created_at) < 24 THEN 1 ELSE 0 END) AS time_20_24
    FROM service_requests_no_fk
  ");

  // Check if the query was successful
  if (!$query2) {
    die("Query Failed: " . $con->error);
  }

  $timeData = $query2->fetch_assoc();
  $time_0_4 = $timeData['time_0_4'];
  $time_4_8 = $timeData['time_4_8'];
  $time_8_12 = $timeData['time_8_12'];
  $time_12_16 = $timeData['time_12_16'];
  $time_16_20 = $timeData['time_16_20'];
  $time_20_24 = $timeData['time_20_24'];

  $con->close();
?>

<div class="chart-container">
  <canvas id="myChart"></canvas>
</div>

<body><nav class="main-menu">
<ul>
            <li>
                <a href="index.html">
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
<script class="graph">
  const serviceLabels = <?php echo json_encode($requestTypes) ?>;
  const serviceData = <?php echo json_encode($requestCounts) ?>;
  const timeLabels = ['12 AM - 4 AM', '4 AM - 8 AM', '8 AM - 12 PM', '12 PM - 4 PM', '4 PM - 8 PM', '8 PM - 12 AM'];
  const timeData = [
    <?php echo $time_0_4; ?>, 
    <?php echo $time_4_8; ?>, 
    <?php echo $time_8_12; ?>, 
    <?php echo $time_12_16; ?>, 
    <?php echo $time_16_20; ?>, 
    <?php echo $time_20_24; ?>
  ];

  const data = {
    labels: serviceLabels,
    datasets: [{
      label: 'Number of Requests',
      data: serviceData,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'bar',
    data: data,
    options: {
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

  function switchToServiceData() {
    myChart.data.labels = serviceLabels;
    myChart.data.datasets[0].data = serviceData;
    myChart.data.datasets[0].label = 'Number of Requests by Service';
    myChart.update();
  }

  function switchToTimeData() {
    myChart.data.labels = timeLabels;
    myChart.data.datasets[0].data = timeData;
    myChart.data.datasets[0].label = 'Number of Requests by Time Interval';
    myChart.update();
  }
</script>

</body>
</html>
