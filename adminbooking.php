<?php
session_start();
include 'config.php';

if (!isset($_SESSION['firstname'])) {
    header("Location: adminlogin.php");
    exit;
}

$firstname = $_SESSION['firstname'];

if (isset($_POST['approve'])) {
    $id = $_POST['approve'];
    $update_query = "UPDATE reserve SET status = 1 WHERE id = $id";
    mysqli_query($con, $update_query);   
    $select_query = "SELECT * FROM reserve WHERE id = $id";
    $result = mysqli_query($con, $select_query);
    $row = mysqli_fetch_assoc($result); 
    if (!isset($row['lastName'])) {
        echo "Error: lastName not retrieved from reserve table.";
        exit;
    }
    $purpose = $row['purpose'];
    $lab = $row['lab'];
    $idno = $row['idno'];
    $session = $row['session']; 
    $firstName = $row['firstName'];
    $middleName = $row['middleName'];
    $lastName = $row['lastName'];

    $insert_query = "INSERT INTO users_sitin (purpose, lab, idno, session, firstName, middleName, lastName) 
                     VALUES ('$purpose', '$lab', '$idno', '$session', '$firstName', '$middleName', '$lastName')";
    mysqli_query($con, $insert_query);
    header("Location: adminview.php");
    exit;
}
if (isset($_POST['decline'])) {
    $id = $_POST['decline'];
    $update_query = "UPDATE reserve SET status = 2 WHERE id = $id";
    mysqli_query($con, $update_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
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
			.search-form {
				display: flex;
				align-items: center;
				margin-bottom: 20px;
			}

			.search-label {
				margin-right: 10px;
				font-size: 16px;
				color: #fff;
			}

			.search-input {
				padding: 5px 10px;
				border: 1px solid #ccc;
				border-radius: 3px;
				margin-right: 10px;
			}

			.search-input input {
				flex: 1;
				padding: 10px;
				border: none;
				outline: none;
				background: none;
				color: #fff;
			}

			.search-btn {
				padding: 10px 20px;
				background-color: white; 
				color: var(--dark);
				border: none;
				cursor: pointer;
				transition: background-color 0.3s;
				border-radius: 10px;
			}

			.search-btn:hover {
				background-color: gray;
				color: #fff;
			}
			.user-info-row {
				margin-top: 20px;
			}

			.user-info-items {
				display: flex;
				flex-wrap: wrap;
			}

			.user-info-item {
				flex: 0 0 50%; 
				padding: 10px;
				box-sizing: border-box;
				font-size: 25px;
			}

			.user-info-item .label {
				font-weight: bold;
			}

			.user-info-item .value {
				margin-left: 10px;
			}
			.form-container {
				background-color: white;
				padding: 20px;
				border-radius: 10px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				margin-top: 20px;
			}
			.user-info-row h3{
				margin-top: -20px;
				font-size: 30px;
				margin-left: 10px;
			}
			.vertical-align {
				display: flex;
				flex-direction: row;
				align-items: flex-start;
				margin-left: 2px;
			}
			.dropdown {
				padding: 10px;
				font-size: 20px;
				border: none;
				border-radius: 5px;
				background-color: #f9f9f9;
				cursor: pointer;
				display: flex;
				flex-direction: column; 
				align-items: flex-start; 
				margin-bottom: 10px;
				margin-left: 5px;
				width: 200px;
			}
			.dropdowns {
				padding: 10px;
				font-size: 20px;
				border: none;
				border-radius: 5px;
				background-color: #f9f9f9;
				cursor: pointer;
				display: flex;
				flex-direction: row; 
				align-items: flex-start; 
				margin-bottom: 10px;
				margin-left: 60px;
				width: 200px;
			}
			.dropdown select option {
				padding: 10px;
				font-size: 16px;
				background-color: #f9f9f9;
				color: #333;
			}
			.dropdown select option:hover {
				background-color: #ddd;
			}
			.label {
				font-size: 25px;
				font-weight: normal; 
			}
			#content main .user-info-item span#remainingSessionInput {
				padding: 1px 10px 0px ;
				color: red;
			}
			.sit-in-btn{
				background-color: var(--blue);
				color: #fff;
				border: none;
				border-radius: 10px;
				padding: 10px 20px;
				cursor: pointer;
				margin-top: 10px;
				transition: .2s;
			}
			.sit-in-btn:hover{
				background-color: red;
				}
				.user-table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
				font-size: 15px;
				background-color: white; 
			}
			.user-table th, .user-table td {
				border: 1px solid #ddd;
				padding: 4px 8px;
				text-align: left;

			}
			.user-table th {
				background-color: #f2f2f2;
				color: black;
			}

			.user-table tr:nth-child(even) {
				background-color: #f2f2f2;
			}

			.user-table tr:hover {
				background-color: #ddd;
			}
			.timeout-button {
				background-color: var(--blue); 
				color: #FFFFFF; 
				border: none; 
				padding: 10px 20px; 
				text-align: center; 
				text-decoration: none; 
				display: inline-block; 
				font-size: 16px; 
				margin: 4px 2px;
				cursor: pointer; 
				border-radius: 12px;
				transition: background-color 0.3s ease; 
			}

			.timeout-button:hover {
				background-color: red; 
			}
			h2{
				color: #fff;
				font-size: 50px;
			}
			form {
				max-width: 70%;
				margin: 20px auto;
				padding: 20px;
				background-color: #f9f9f9;
				border-radius: 10px;
			}

			input[type="text"],
			textarea {
				width: 100%;
				padding: 10px;
				margin-bottom: 10px;
				border: 1px solid #ccc;
				border-radius: 5px;
			}

			textarea {
				height: 150px;
			}

			button {
				display: block;
				width: 100%;
				padding: 10px;
				background-color: #3C91E6;
				color: #fff;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s;
			}
			button:hover {
				background-color: #2575B3;
			}
            .booking-table {
				font-family:var(--poppins);
                width: 75%;
                border-collapse: collapse;
                font-size: 14px;
                color: #333; 
                margin: 20px auto; 
                background-color: white; 
                box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            }
            .booking-table thead th {
                background-color: #f2f2f2; 
                color: #333;
                padding: 12px 15px; 
                font-weight: bold; 
            }
            .booking-table tbody td {
                padding: 12px 15px; 
                text-align: left; 
                vertical-align: middle; 
                border-top: 1px solid #ddd;
                color: #666; 
            }
            .booking-table tr:nth-child(even) {
                background-color: #f2f2f2; 
            }
			.approved{
				font-family: var(--poppins);
				color: green;
				font-size: 20px;
				font-weight: 600;
			}
			.decline{
				font-family: var(--poppins);
				color: red;
				font-size: 20px;
				font-weight: 600;
			}
			.container {
				display: flex;
				gap: 10px; 
				background-color: #fff;
			}

			.approve-btn{
				padding: 10px 20px;
				background-color: #007bff; 
				cursor: pointer;
				text-align: center;
				width: 100px; /
				border-radius: 5px; 
			}
			.decline-btn {
				padding: 10px 20px;
				background-color: #dc3545; 
				cursor: pointer;
				text-align: center;
				width: 100px; 
				border-radius: 5px; 
			}
            .approve-btn:hover {
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                transform: translateY(-2px);
            }
			.decline-btn:hover{
				filter: brightness(110%);
				background-color: #dc3545;
				transform: translateY(-2px);
			}
            .approve-btn:hover {
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                transform: translateY(-2px);
            }
			h1{
				font-family: var(--poppins);
				font-size: 50px;
				color: #fff;
				text-align: center;
			}
	</style>
</head>
<body>
	<section id="sidebar">
		<a href="#" class="brand">
			<img src="./images/ccs.png" height="100px">
		</a>
		<ul class="side-menu top">
		<li class="active">
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
			<li>
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
		</main>
        <div class="view-container">
			<h1>Future Reservation</h1>
			<table class="booking-table">
				<thead>
					<tr>
						<th>ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Computer Number</th>
                        <th>Purpose</th>
                        <th>Lab</th>
                        <th>Reserved Date</th>
                        <th>Reserved Time</th>
                        <th>ID Number</th>
                        <th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php
                        $query = "SELECT * FROM reserve ORDER BY timein DESC";
                        $result = mysqli_query($con, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['firstName'] . "</td>";
                                echo "<td>" . $row['middleName'] . "</td>";
                                echo "<td>" . $row['lastName'] . "</td>";
                                echo "<td>" . $row['pcnum'] . "</td>";
                                echo "<td>" . $row['purpose'] . "</td>";
                                echo "<td>" . $row['lab'] . "</td>";
                                echo "<td>" . $row['resdate'] . "</td>";
                                echo "<td>" . $row['restime'] . "</td>";
                                echo "<td>" . $row['idno'] . "</td>";
                                echo "<td>";
                                if ($row['status'] == 1) {
                                    echo "<span class='approved'>Approved</h2>";
                                } elseif ($row['status'] == 2) {
                                    echo "<span class='decline'>Declined</h2>";
                                } else {
                                    echo "<form method='post' class='container'>";
                                    echo "<button class='approve-btn' type='submit' name='approve' value='" . $row['id'] . "'>Approve</button>";
                                    echo "<button class='decline-btn'type='submit' name='decline' value='" . $row['id'] . "'>Decline</button>";
                                    echo "</form>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11'>No booking records found</td></tr>";
                        }
                        mysqli_close($con);
                    ?>
				</tbody>
			</table>
		</div>
    </div>

    </section>
</main>
</body>
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
	const searchButton = document.querySelector('#content m-input button');
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
	document.getElementById('search-btn').addEventListener('click', function() {
		const currentTime = new Date();
		const timeIn = currentTime.toISOString();

		fetch('record_time.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ timeIn: timeIn }),
		})
		.then(response => response.json())
		.then(data => console.log(data))
		.catch((error) => {
			console.error('Error:', error);
		});
	});
	    window.addEventListener('beforeunload', function() {
        const currentTime = new Date();
        const timeOut = currentTime.toISOString();

        fetch('record_time.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ timeOut: timeOut }),
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch((error) => {
            console.error('Error:', error);
        });
    });
	function clearPlaceholder(element) {
        element.placeholder = '';
    }
    function restorePlaceholder(element) {
        element.placeholder = element.getAttribute('data-placeholder');
    }
	</script>
</html>