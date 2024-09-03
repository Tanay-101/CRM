<?php
    include 'db.php';
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Prepare and execute the SQL query to get data for the logged-in user
        $sql = "SELECT email, request_type FROM service_requests_no_fk WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        // Bind variables to prepared statement
        $stmt->bind_result($email, $request_type);

        // Fetch data and store it in an array to be displayed in the HTML
        $data = [];
        while ($stmt->fetch()) {
            $data[] = [
                'email' => $email,
                'request_type' => $request_type
            ];
        }

        $stmt->close();
    } else {
        echo "You need to log in to see your service requests.";
        exit;
    }
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
</head>

<body>
    <style>
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
        }
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
                <a href="http://localhost/crm/index.html#blog">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Home</h3>
                </a>
               
            </div>
        </aside>
        <!----------------------- END OF ASIDE -------------------->
        <main>
            <h1>Your Requests</h1>
            <br>

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

            <!-- Buttons -->
            <div class="analytics-buttons">
                <button class="btn" onclick="showChart('bar')">Show Bar Chart</button>
                <button class="btn" onclick="showChart('pie')">Show Pie Chart</button>
            </div>

        </main>

        <!------------------------- END OF MAIN -------------------->
        <div class="right">
            <div class="top">
                <!-- Additional elements for the right section can go here -->
            </div>
        </div>
    </div>

    <script>
        // Function to handle the active state and animation
        function setActiveLink(event) {
            // Remove active class from all links
            const links = document.querySelectorAll('.sidebar a');
            links.forEach(link => {
                link.classList.remove('active');
            });

            // Add active class to the clicked link
            event.currentTarget.classList.add('active');
        }

        // Attach event listeners to each navbar item
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', setActiveLink);
        });

        function showDashboard() {
            document.querySelector('h1').textContent = 'Dashboard';
            document.querySelector('.table-container').style.display = 'block';
            document.querySelector('.analytics-buttons').style.display = 'none';
        }

        function showAnalytics() {
            document.querySelector('h1').textContent = 'Analytics';
            document.querySelector('.table-container').style.display = 'none';
            document.querySelector('.analytics-buttons').style.display = 'flex';
        }

        function showChart(type) {
            alert(`Show ${type} chart here`);
        }
    </script>
</body>

</html>

  