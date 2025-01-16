<?php
session_start();
if (!isset($_SESSION['firstname'])) {
    header("Location: adminlogin.php");
    exit;
}
include("config.php");
$firstname = $_SESSION['firstname'];

$selectedDate = isset($_POST['date']) ? $_POST['date'] : "";
$result = null; 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $selectedDate = $_POST['date'];
    $query = "SELECT * FROM login_history WHERE 1";
    if (!empty($selectedDate)) {
        $query .= " AND DATE(timein) = '$selectedDate'"; 
    }
    $result = mysqli_query($con, $query);
}

$purpose_counts = [];
$lab_counts = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $purpose = $row['purpose'];
        if (array_key_exists($purpose, $purpose_counts)) {
            $purpose_counts[$purpose]++;
        } else {
            $purpose_counts[$purpose] = 1;
        }

        $lab = $row['lab'];
        if (array_key_exists($lab, $lab_counts)) {
            $lab_counts[$lab]++;
        } else {
            $lab_counts[$lab] = 1;
        }
    }
}

$chart_data = "['Purpose', 'Count'],";
foreach ($purpose_counts as $purpose => $count) {
    $chart_data .= "['$purpose', $count],";
}
$chart_data = rtrim($chart_data, ",");

$chart_data2 = "['Lab', 'Count'],";
foreach ($lab_counts as $lab => $count) {
    $chart_data2 .= "['$lab', $count],";
}
$chart_data2 = rtrim($chart_data2, ",");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<title>Admin Dashboard</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		a {
			text-decoration: none;
		}

		li {
			list-style: none;
		}

		:root {
			--poppins: 'Poppins', sans-serif;
			--lato: 'Lato', sans-serif;

			--light: #F9F9F9;
			--blue: #3C91E6;
			--light-blue: #CFE8FF;
			--grey: #eee;
			--dark-grey: #AAAAAA;
			--dark: #342E37;
			--red: #DB504A;
			--yellow: #FFCE26;
			--light-yellow: #FFF2C6;
			--orange: #FD7238;
			--light-orange: #FFE0D3;
		}

		html {
			overflow-x: hidden;
		}

		body.dark {
			--light: #0C0C1E;
			--grey: #060714;
			--dark: #FBFBFB;
		}

		body {
			background: #25274D;
			overflow-x: hidden;
		}
		#sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: 280px;
			height: 100%;
			background: var(--light);
			z-index: 2000;
			font-family: var(--lato);
			transition: .3s ease;
			overflow-x: hidden;
			scrollbar-width: none;
		}
		#sidebar::--webkit-scrollbar {
			display: none;
		}
		#sidebar.hide {
			width: 60px;
		}
		#sidebar .brand {
			font-size: 24px;
			font-weight: 700;
			height: 56px;
			display: flex;
			align-items: center;
			color: var(--blue);
			position: sticky;
			top: 0;
			left: 0;
			background: var(--light);
			z-index: 500;
			padding-bottom: 20px;
			box-sizing: content-box;
		}
		#sidebar .brand .bx {
			min-width: 60px;
			display: flex;
			justify-content: center;
		}
		#sidebar .side-menu {
			width: 100%;
			margin-top: 48px;
		}
		#sidebar .side-menu li {
			height: 48px;
			background: transparent;
			margin-left: 6px;
			border-radius: 48px 0 0 48px;
			padding: 4px;
		}
		#sidebar .side-menu li.active {
			background: var(--grey);
			position: relative;
		}
		#sidebar .side-menu li.active::before {
			content: '';
			position: absolute;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			top: -40px;
			right: 0;
			box-shadow: 20px 20px 0 var(--grey);
			z-index: -1;
		}
		#sidebar .side-menu li.active::after {
			content: '';
			position: absolute;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			bottom: -40px;
			right: 0;
			box-shadow: 20px -20px 0 var(--grey);
			z-index: -1;
		}
		#sidebar .side-menu li a {
			width: 100%;
			height: 100%;
			background: var(--light);
			display: flex;
			align-items: center;
			border-radius: 48px;
			font-size: 16px;
			color: var(--dark);
			white-space: nowrap;
			overflow-x: hidden;
		}
		#sidebar .side-menu.top li.active a {
			color: var(--blue);
		}
		#sidebar.hide .side-menu li a {
			width: calc(48px - (4px * 2));
			transition: width .3s ease;
		}
		#sidebar .side-menu li a.logout {
			color: var(--red);
		}
		#sidebar .side-menu.top li a:hover {
			color: var(--blue);
		}
		#sidebar .side-menu li a .bx {
			min-width: calc(60px  - ((4px + 6px) * 2));
			display: flex;
			justify-content: center;
		}
		#content {
			position: relative;
			width: calc(100% - 280px);
			left: 280px;
			transition: .3s ease;
		}
		#sidebar.hide ~ #content {
			width: calc(100% - 60px);
			left: 60px;
		}
		#content nav {
			height: 56px;
			background: var(--light);
			padding: 0 24px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			grid-gap: 24px;
			font-family: var(--lato);
			position: sticky;
			top: 0;
			left: 0;
			z-index: 1000;
		}
		#content nav::before {
			content: '';
			position: absolute;
			width: 40px;
			height: 40px;
			bottom: -40px;
			left: 0;
			border-radius: 50%;
			box-shadow: -20px -20px 0 var(--light);
		}
		#content nav a {
			color: var(--dark);
		}
		#content nav .bx.bx-menu {
			cursor: pointer;
			color: var(--dark);
		}
		#content nav .nav-link {
			font-size: 16px;
			transition: .3s ease;
		}
		#content nav .nav-link:hover {
			color: var(--blue);
		}
		#content nav form {
			max-width: 400px;
			width: 100%;
			margin-right: auto;
		}
		#content nav form .form-input {
			display: flex;
			align-items: center;
			height: 36px;
		}
		#content nav form .form-input input {
			flex-grow: 1;
			padding: 0 16px;
			height: 100%;
			border: none;
			background: var(--grey);
			border-radius: 36px 0 0 36px;
			outline: none;
			width: 100%;
			color: var(--dark);
		}
		#content nav form .form-input button {
			width: 36px;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
			background: var(--blue);
			color: var(--light);
			font-size: 18px;
			border: none;
			outline: none;
			border-radius: 0 36px 36px 0;
			cursor: pointer;
		}
		#content nav .notification {
			font-size: 20px;
			position: relative;
		}
		#content nav .notification .num {
			position: absolute;
			top: -6px;
			right: -6px;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			border: 2px solid var(--light);
			background: var(--red);
			color: var(--light);
			font-weight: 700;
			font-size: 12px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#content nav .profile img {
			width: 36px;
			height: 36px;
			object-fit: cover;
			border-radius: 50%;
		}
		
		#content main {
			width: 100%;
			padding: 36px 24px;
			font-family: var(--poppins);
			max-height: calc(100vh - 56px);
			overflow-y: auto;
		}
		#content main .head-title {
			display: flex;
			align-items: center;
			justify-content: space-between;
			grid-gap: 16px;
			flex-wrap: wrap;
		}
		#content main .head-title .left h1 {
			font-size: 36px;
			font-weight: 600;
			margin-bottom: 10px;
			color: white;
		}
		#content main .head-title .left .breadcrumb {
			display: flex;
			align-items: center;
			grid-gap: 16px;
		}
		#content main .head-title .left .breadcrumb li {
			color: white;
		}
		#content main .head-title .left .breadcrumb li a {
			color: var(--dark-grey);
			pointer-events: none;
		}
		#content main .head-title .left .breadcrumb li a.active {
			color: var(--blue);
			pointer-events: unset;
		}
		#content main .box-info {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
			grid-gap: 24px;
			margin-top: 36px;
		}
		#content main .box-info li {
			padding: 24px;
			background: var(--light);
			border-radius: 20px;
			display: flex;
			align-items: center;
			grid-gap: 24px;
		}
		#content main .box-info li .bx {
			width: 80px;
			height: 80px;
			border-radius: 10px;
			font-size: 36px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#content main .box-info li:nth-child(1) .bx {
			background: var(--light-blue);
			color: var(--blue);
		}
		#content main .box-info li:nth-child(2) .bx {
			background: var(--light-yellow);
			color: var(--yellow);
		}
		#content main .box-info li:nth-child(3) .bx {
			background: var(--light-orange);
			color: var(--orange);
		}
		#content main .box-info li .text h3 {
			font-size: 24px;
			font-weight: 600;
			color: var(--dark);
		}
		#content main .box-info li .text p {
			color: var(--dark);	
		}
		@media screen and (max-width: 768px) {
			#sidebar {
				width: 200px;
			}

			#content {
				width: calc(100% - 60px);
				left: 200px;
			}

			#content nav .nav-link {
				display: none;
			}
		}
		@media screen and (max-width: 576px) {
			#content nav form .form-input input {
				display: none;
			}

			#content nav form .form-input button {
				width: auto;
				height: auto;
				background: transparent;
				border-radius: none;
				color: var(--dark);
			}

			#content nav form.show .form-input input {
				display: block;
				width: 100%;
			}
			#content nav form.show .form-input button {
				width: 36px;
				height: 100%;
				border-radius: 0 36px 36px 0;
				color: var(--light);
				background: var(--red);
			}

			#content nav form.show ~ .notification,
			#content nav form.show ~ .profile {
				display: none;
			}

			#content main .box-info {
				grid-template-columns: 1fr;
			}

			#content main .table-data .head {
				min-width: 420px;
			}
			#content main .table-data .order table {
				min-width: 420px;
			}
			#content main .table-data .todo .todo-list {
				min-width: 420px;
			}
			}
			#sidebar img{
				margin-left: 90px;
				margin-top: 60px;
				transition: margin-left 0.3s ease; 
			}

			#sidebar.hide img {
				margin-left: 15px; 
				width: 30px; 
				height: 30px; 
			}
			#content nav .profile {
				display: flex;
				align-items: center;
				margin-right: 24px;
			}

			#content nav .profile img {
				width: 36px;
				height: 36px;
				object-fit: cover;
				border-radius: 50%;
				margin-right: 8px; 
			}
			#content nav .profile span {
				color: white;
				font-size: 16px;
				font-weight: 500;
			}
            .head-title {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f8f8f8;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-top: px;
            }

            .head-title h1 {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }
            form {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
            }

            label {
                font-size: 14px;
                color: #666;
                margin-bottom: 5px;
            }

            select,
            input[type="number"] {
                padding: 8px;
                margin-bottom: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 14px;
                margin-left: 150px;
            }
            .student{
                margin-right: -5px;
            }
            input[type="text"] {
                padding: 8px;
                margin-bottom: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 14px;
                margin-right: 120px;
            }
            button[type="submit"] {
                padding: 8px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
            }
			button[type="submit"]:hover {
				background-color: #0056b3; 
				color: white;
            }
            table {
                width: 80%;
                margin-top: 20px;
                border-collapse: collapse;
				margin-right: 500px;
            }

            th, td {
                padding: 8px;
                border-bottom: 1px solid #ccc;
                text-align: left;
            }

            th {
                background-color: #f8f8f8;
            }
            .generate-report-form select {
                width: 100%; 
                padding: 10px;
                font-size: 16px; 
                border: 1px solid #ccc; 
                border-radius: 4px; 
                box-sizing: border-box; 
                margin-bottom: 10px; 
                background-color: #f9f9f9; 
                color: #333; 
            }
            .generate-report-form select option {
                padding: 10px; 
                background-color: #f9f9f9;
                color: #333; 
            }
            .generate-report-form select:hover {
                border-color: #007bff;
            }
			.ee-btn {
				padding: 8px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
			}

			.ee-btn:hover {
				background-color: #0056b3; 
				color: white;
			}
			input[type="date"] {
				padding: 8px;
				margin-bottom: 10px;
				border-radius: 5px;
				border: 1px solid #ccc;
				font-size: 14px;
				width: calc(100% - 16px); 
				box-sizing: border-box; 
				background-color: #f9f9f9;
				color: #333;
			}

			input[type="date"]:hover {
				border-color: #007bff;
			}
            .chart-container {
                width: 800px;
                height: 400px;
                margin: 20px auto;
                background-color: black;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                padding: 20px;
            }

            #chart_div {
                align-items: center;
                width: 100%;
                height: 100%;
            }
            #chart_div2 {
                align-items: center;
                width: 100%;
                height: 100%;
            }
            .btn{
                padding: 8px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
            }
            .btn:hover {
				background-color: #0056b3; 
				color: white;
			}
	</style>
</head>
<body>
<main>
<section id="sidebar">
		<a href="#" class="brand">
			<img src="./images/ccs.png" height="100px">
		</a>
		<ul class="side-menu top">
			<li>
				<a href="admin.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="adminsearch.php">
					<i class='bx bx-search-alt-2'></i>
					<span class="text">Search</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-folder-minus'></i>
					<span class="text">Delete</span>
				</a>
			</li>
			<li>
				<a href="adminview.php">
					<i class='bx bx-street-view'></i>
					<span class="text">View Records</span>
				</a>
			</li>
			<li class="active">
				<a href="adminreports.php">
					<i class='bx bxs-report'></i>
					<span class="text">Reports</span>
				</a>
			</li>
			<li>
				<a href="adminfeedback.php">
				<i class='bx bxs-message-square-dots'></i>
					<span class="text">View Student Feedback</span>
				</a>
			</li>
			<li>
				<a href="adminreset.php">
				<i class='bx bxs-message-square-dots'></i>
					<span class="text">Reset Password</span>
				</a>
			</li>
            <li>
				<a href="adminbooking.php">
				<i class='bx bxs-message-square-dots'></i>
					<span class="text">Booking Approval</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<section id="content">
		<nav>
			<i class='bx bx-menu'></i>
			<form action="#"></form>
			<a href="#" class="notification">
				<i class='bx bxs-bell'></i>
				<span class="num">0</span>
			</a>
		</nav>
        <main>
			<div class="head-title">
            <h2>Daily Analytics</h2>
        <hr>
        <form method="post" class="generate-report-form">
            
            <label class="date" for="date">Date:</label>
            <input type="date" name="date" id="date" value="<?php echo $selectedDate; ?>">
            <br>
			<br>
            <button type="submit" name="generate_report">Generate Report</button>
        </form>
        <div id="chart_div2"></div>
        <div id="chart_div"></div>
			<button class="btn" onclick="location.href='adminreports.php?date=<?php echo $selectedDate; ?>'">Return</button>
        </div>
    </main>
    </section>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.39/jspdf.plugin.autotable.min.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script> 
<script>
	const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
	allSideMenu.forEach(item=> {
		const li = item.parentElement;

		item.addEventListener('click', function () {
			allSideMenu.forEach(i=> {
				i.parentElement.classList.remove('active');
			})
			li.classList.add('active');
		})
	});
	const menuBar = document.querySelector('#content nav .bx.bx-menu');
	const sidebar = document.getElementById('sidebar');

	menuBar.addEventListener('click', function () {
		sidebar.classList.toggle('hide');
	})
	const searchButton = document.querySelector('#content nav form .form-input button');
	const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
	const searchForm = document.querySelector('#content nav form');

	searchButton.addEventListener('click', function (e) {
		if(window.innerWidth < 576) {
			e.preventDefault();
			searchForm.classList.toggle('show');
			if(searchForm.classList.contains('show')) {
				searchButtonIcon.classList.replace('bx-search', 'bx-x');
			} else {
				searchButtonIcon.classList.replace('bx-x', 'bx-search');
			}
		}
	})
	if(window.innerWidth < 768) {
		sidebar.classList.add('hide');
	} else if(window.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
	window.addEventListener('resize', function () {
		if(this.innerWidth > 576) {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
			searchForm.classList.remove('show');
		}
	})
	</script>
	<script>
    function downloadLoginHistory() {
        if (confirm("Do you want to download the login history?")) {
            var table = document.getElementById('loginHistoryTable');
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(table);
            XLSX.utils.book_append_sheet(wb, ws, "Login History");
            XLSX.writeFile(wb, 'login-history.xlsx');
        }
    }
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            <?php echo $chart_data; ?>
        ]);

        var options = {
            title: 'Purpose Count',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        var data2 = google.visualization.arrayToDataTable([
            <?php echo $chart_data2; ?>
        ]);

        var options2 = {
            title: 'Lab Count',
            pieHole: 0.4,
        };

        var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);
    }
    document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').value = today;
});
</script>
</html>
