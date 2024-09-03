<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dffba75db4.js" crossorigin="anonymous"></script>
  <title>Service Requests Chart</title>
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
      background-image: white; 
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
    .graph{
      margin-left:1000px;
    }
  </style>
</head>
<body>
<header>
  
</header>

<?php 
  // Database connection
  $con = new mysqli('localhost', 'root', '', 'grand');
  if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
  }

  // Fetch request types and their counts
  $query = $con->query("
    SELECT 
      request_type,
      COUNT(*) as count
    FROM service_requests_no_fk
    GROUP BY request_type
  ");

  // Check if the query was successful
  if (!$query) {
    die("Query Failed: " . $con->error);
  }

  $requestTypes = [];
  $requestCounts = [];
  foreach($query as $data)
  {
    $requestTypes[] = $data['request_type'];
    $requestCounts[] = $data['count'];
  }

  $con->close();
?>

<div style="width: 800px; height: 400px; margin: 0 auto; padding-top: 100px;   font-weight: bold;">
  <canvas id="myChart"></canvas>
</div>
 
<script class="graph">
  // Prepare data for the chart
  const labels = <?php echo json_encode($requestTypes) ?>;
  const data = {
    labels: labels,
    datasets: [{
      label: 'Number of Requests',
      data: <?php echo json_encode($requestCounts) ?>,
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

  // Configure the chart
  const config = {
    type: 'bar',
    data: data,
    options: {
      maintainAspectRatio: false, // Disable aspect ratio
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  // Render the chart
  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

</body>
</html>
