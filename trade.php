<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'grand');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch data for the main table
$sql = "SELECT email, request_type FROM service_requests_no_fk";
$result = $conn->query($sql);

$data = [];
$request_counts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
        // Count occurrences of each request_type
        if (isset($request_counts[$row['request_type']])) {
            $request_counts[$row['request_type']]++;
        } else {
            $request_counts[$row['request_type']] = 1;
        }
    }
} else {
    echo "0 results";
}

// Fetch the counts for service requests made in different time intervals
$query = $conn->query("
    SELECT 
        SUM(CASE WHEN HOUR(created_at) >= 0 AND HOUR(created_at) < 4 THEN 1 ELSE 0 END) AS time_0_4,
        SUM(CASE WHEN HOUR(created_at) >= 4 AND HOUR(created_at) < 8 THEN 1 ELSE 0 END) AS time_4_8,
        SUM(CASE WHEN HOUR(created_at) >= 8 AND HOUR(created_at) < 12 THEN 1 ELSE 0 END) AS time_8_12,
        SUM(CASE WHEN HOUR(created_at) >= 12 AND HOUR(created_at) < 16 THEN 1 ELSE 0 END) AS time_12_16,
        SUM(CASE WHEN HOUR(created_at) >= 16 AND HOUR(created_at) < 20 THEN 1 ELSE 0 END) AS time_16_20,
        SUM(CASE WHEN HOUR(created_at) >= 20 AND HOUR(created_at) < 24 THEN 1 ELSE 0 END) AS time_20_24
    FROM service_requests_no_fk
");

if (!$query) {
    die("Query Failed: " . $conn->error);
}

$time_data = $query->fetch_assoc();
$time_0_4 = $time_data['time_0_4'];
$time_4_8 = $time_data['time_4_8'];
$time_8_12 = $time_data['time_8_12'];
$time_12_16 = $time_data['time_12_16'];
$time_16_20 = $time_data['time_16_20'];
$time_20_24 = $time_data['time_20_24'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dashboard for CRM</title>
    <!-- MATERIAL ICONS-->
    <link href='https://fonts.googleapis.com/css?family=Material+Icons+Sharp' rel='stylesheet'>
    <!--STYLESHEET-->
    <script src="index.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <style>
        /* Your existing CSS here... */
        /* Root Variable */
         /* Root Variable */
         :root {
            --color-primary: #7380ec;
            --color-danger: #ff7782;
            --color-success: #41f1b6;
            --color-warning: #ffbb55;
            --color-white: #fff;
            --color-info-dark: #7d8da1;
            --color-info-light: #dce1eb;
            --color-dark: #363949;
            --color-light: rgba(132, 139, 200, 0.18);
            --color-primary-variant: #111e88;
            --color-dark-variant: #677483;
            --color-background: #f6f6f9;

            --card-border-radius: 2rem;
            --border-radius-1: 0.4rem;
            --border-radius-2: 0.8rem;
            --border-radius-3: 1.2rem;

            --card-padding: 1.8rem;
            --padding-1: 1.2rem;

            --box-shadow: 0 2rem 3rem var(--color-light);
        }

        * {
            margin: 0;
            padding: 0;
            outline: 0;
            appearance: none;
            border: 0;
            text-decoration: none;
            list-style: none;
            box-sizing: border-box;
        }

        html {
            font-size: 14px;
        }

        body {
            width: 100vw;
            height: 100vh;
            font-family: Poppins, sans-serif;
            font-size: 0.88rem;
            background: var(--color-background);
            user-select: none;
            overflow-x: hidden;
            color: var(--color-dark);
        }

        .container {
            display: grid;
            width: 96%;
            margin: 0 auto;
            gap: 1.8rem;
            grid-template-columns: 14rem auto 23rem;
        }

        a {
            color: var(--color-dark);
        }

        img {
            display: block;
            width: 100%;
        }

        h1 {
            font-weight: 800;
            font-size: 1.8rem;
        }

        h2 {
            font-size: 1.4rem;
        }

        h3 {
            font-size: 0.87rem;
        }

        h4 {
            font-size: 0.8rem;
        }

        h5 {
            font-size: 0.77rem;
        }

        small {
            font-size: 0.75rem;
        }

        .profile-photo {
            width: 2.8rem;
            height: 2.8rem;
            border-radius: 50%;
            overflow: hidden;
        }

        .text-muted {
            color: var(--color-info-dark);
        }

        p {
            color: var(--color-dark-variant);
        }

        b {
            color: var(--color-dark);
        }

        .primary {
            color: var(--color-primary);
        }

        .danger {
            color: var(--color-danger);
        }

        .success {
            color: var(--color-success);
        }

        .warning {
            color: var(--color-warning);
        }

        aside {
            height: 100vh;
        }

        aside .top {
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.4rem;
        }

        aside .logo {
            display: flex;
            gap: 0.8rem;
        }

        aside .logo img {
            width: 4rem;
            height: 3rem;
        }

        aside .close {
            display: none;
        }

        /* ************** SIDEBAR ************* */
        aside .sidebar {
            display: flex;
            flex-direction: column;
            height: 86vh;
            position: relative;
            top: 3rem;
        }

        aside h3 {
            font-weight: 500;
        }

        aside .sidebar a {
            display: flex;
            color: var(--color-info-dark);
            margin-left: 2rem;
            gap: 1rem;
            align-items: center;
            position: relative;
            height: 3.7rem;
            transition: all 300ms ease;
        }

        aside .sidebar a span {
            font-size: 1.6rem;
            transition: all 300ms ease;
        }

        aside .sidebar a:last-child {
            position: absolute;
            bottom: 2rem;
            width: 100%;
        }

        aside .sidebar a.active {
            background: var(--color-light);
            color: var(--color-primary);
            margin-left: 0;
        }

        aside .sidebar a.active:before {
            content: "";
            width: 6px;
            height: 100%;
            background: var(--color-primary);
        }

        aside .sidebar a.active span {
            color: var(--color-primary);
            margin-left: calc(1rem - 3px);
        }

        aside .sidebar a:hover {
            color: var(--color-primary);
        }

        aside .sidebar a:hover span {
            margin-left: 1rem;
        }

        /* ************************ MAIN ********************* */
        main {
            margin-top: 1.4rem;
        }

        /* ************ ADDING TABLE CSS ************* */
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--color-white);
            border-radius: var(--card-border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: var(--color-info-light);
            font-weight: 600;
            color: var(--color-dark);
        }

        td {
            font-size: 14px;
            color: var(--color-dark-variant);
        }

        /* ********* ADDING CSS TO RIGHT TOP ************ */
        .right {
            margin-top: 1.4rem;
        }

        .right .top {
            display: flex;
            justify-content: end;
            gap: 2rem;
        }

        .right .top button {
            display: none;
        }

        /* Style for the Analytics buttons */
        .analytics-buttons {
            display: none;
            justify-content: center;
            margin-top: 20px;
            gap: 20px;
        }

        .btn {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: var(--color-primary-variant);
        } background-color: var(--color-primary-variant);
        
    </style>

    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <h2>CRM</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="#" class="active" onclick="showDashboard()">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="#" onclick="showAnalytics()">
                    <span class="material-icons-sharp">trending_up</span>
                    <h3>Analytics</h3>
                </a>
                <a href="http://localhost/crm/index.html#blog">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Home</h3>
                </a>
            </div>
        </aside>
        <!----------------------- END OF ASIDE -------------------->
        <main>
            <h1>Dashboard</h1>

            <!---------------------- STARTING THE TABLE --------------->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Request Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)) : ?>
                        <?php foreach ($data as $row) : ?>
                        <tr>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['request_type']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="2">No data available</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!------------------- ADDING BUTTONS FOR ANALYTICS CHARTS ----------------->
            <div class="analytics-buttons">
                <button class="btn" onclick="showChart('bar')">Show Requests</button>
                <button class="btn" onclick="showChart('pie')">Show Timebased Analytics</button>
            </div>

            <!-- Canvas elements for charts -->
            <canvas id="barChart" style="max-width: 600px; margin-top: 20px;"></canvas>
            <canvas id="pieChart" style="max-width: 600px; margin-top: 20px;"></canvas>
            <canvas id="timeChart" style="max-width: 600px; margin-top: 20px;"></canvas>

        </main>

    </div>

    <script>
        // Function to switch between dashboard and analytics
        function showDashboard() {
            document.querySelector('h1').textContent = 'Dashboard';
            document.querySelector('.table-container').style.display = 'block';
            document.querySelector('.analytics-buttons').style.display = 'none';
            document.getElementById('barChart').style.display = 'none';
            document.getElementById('pieChart').style.display = 'none';
            document.getElementById('timeChart').style.display = 'none';
        }

        function showAnalytics() {
            document.querySelector('h1').textContent = 'Analytics';
            document.querySelector('.table-container').style.display = 'none';
            document.querySelector('.analytics-buttons').style.display = 'flex';
        }

        // Function to render the charts
        function showChart(type) {
            // Hide all charts initially
            document.getElementById('barChart').style.display = 'none';
            document.getElementById('pieChart').style.display = 'none';
            document.getElementById('timeChart').style.display = 'none';

            if (type === 'bar') {
                document.getElementById('barChart').style.display = 'block';
                renderBarChart();
            } else if (type === 'pie') {
                document.getElementById('pieChart').style.display = 'block';
                renderPieChart();
            } else if (type === 'time') {
                document.getElementById('timeChart').style.display = 'block';
                renderTimeChart();
            }
        }
function renderBarChart() {
    const ctx = document.getElementById('barChart').getContext('2d');
    
    // Prepare the data for the chart
    const requestTypes = [];
    const requestCounts = [];
    
    <?php
    $typeCounts = [];
    foreach ($data as $row) {
        if (!isset($typeCounts[$row['request_type']])) {
            $typeCounts[$row['request_type']] = 0;
        }
        $typeCounts[$row['request_type']]++;
    }
    foreach ($typeCounts as $type => $count) {
        echo "requestTypes.push('{$type}');";
        echo "requestCounts.push({$count});";
    }
    ?>
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: requestTypes,
            datasets: [{
                label: 'Number of Requests',
                data: requestCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


        function renderPieChart() {
            const ctx = document.getElementById('pieChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Time 0-4', 'Time 4-8', 'Time 8-12', 'Time 12-16', 'Time 16-20', 'Time 20-24'],
                    datasets: [{
                        label: 'Requests by Time',
                        data: [
                            <?php echo $time_0_4; ?>,
                            <?php echo $time_4_8; ?>,
                            <?php echo $time_8_12; ?>,
                            <?php echo $time_12_16; ?>,
                            <?php echo $time_16_20; ?>,
                            <?php echo $time_20_24; ?>
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }

        function renderTimeChart() {
            const ctx = document.getElementById('timeChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Time 0-4', 'Time 4-8', 'Time 8-12', 'Time 12-16', 'Time 16-20', 'Time 20-24'],
                    datasets: [{
                        label: 'Requests over Time',
                        data: [
                            <?php echo $time_0_4; ?>,
                            <?php echo $time_4_8; ?>,
                            <?php echo $time_8_12; ?>,
                            <?php echo $time_12_16; ?>,
                            <?php echo $time_16_20; ?>,
                            <?php echo $time_20_24; ?>
                        ],
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }
    </script>
</body>

</html>
