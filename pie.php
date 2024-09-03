<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dffba75db4.js" crossorigin="anonymous"></script>
  <title>Service Requests by Time Intervals</title>
  <style>
    /* Add your CSS styling here */
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
    .graph {
      margin-left: 1000px;
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

  // Fetch the counts for service requests made in different time intervals
  $query = $con->query("
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
  if (!$query) {
    die("Query Failed: " . $con->error);
  }

  $data = $query->fetch_assoc();
  $time_0_4 = $data['time_0_4'];
  $time_4_8 = $data['time_4_8'];
  $time_8_12 = $data['time_8_12'];
  $time_12_16 = $data['time_12_16'];
  $time_16_20 = $data['time_16_20'];
  $time_20_24 = $data['time_20_24'];
  $con->close();
?>

<div style="width: 800px; height: 400px; margin: 0 auto; padding-top: 100px; font-weight: bold;">
  <canvas id="myChart"></canvas>
</div>

<script class="graph">
  // Prepare data for the chart
  const data = {
    labels: ['12 AM - 4 AM', '4 AM - 8 AM', '8 AM - 12 PM', '12 PM - 4 PM', '4 PM - 8 PM', '8 PM - 12 AM'],
    datasets: [{
      label: 'Service Requests by Time Intervals',
      data: [
        <?php echo $time_0_4; ?>, 
        <?php echo $time_4_8; ?>, 
        <?php echo $time_8_12; ?>, 
        <?php echo $time_12_16; ?>, 
        <?php echo $time_16_20; ?>, 
        <?php echo $time_20_24; ?>
      ],
      backgroundColor: [
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)'
      ],
      borderColor: [
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(255, 206, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(255, 206, 86)'
      ],
      borderWidth: 1
    }]
  };

  // Configure the chart
  const config = {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Service Requests by Time Intervals'
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
