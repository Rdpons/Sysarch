<?php
    session_start();
    if (!isset($_SESSION['firstName'])) {
        header("Location: login.php");
        exit;
    }
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];

	include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<title>Student Dashboard</title>
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
			.container {
            max-width: 100%;
            margin: 0 20px;
            padding: 20px;
        }
        .announcement {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
		.container h1{
			color: #fff;
			font-family: var(--poppins);
			font-size: 40px;
		}
        .announcement h3 {
            margin-top: 0;
			margin-bottom: 20px;
            color: #333;
			font-family: var(--poppins);
        }
        .announcement p {
            margin-bottom: 10px;
			font-family: var(--poppins);
        }
        .announcement .date {
            color: #888;
            font-size: 14px;
			font-family: var(--poppins);
        }
		.announcement.empty {
			background-color: #f9f9f9;
			border: 1px solid #ddd;
			padding: 10px;
			border-radius: 5px;
			text-align: center;
			color: #888;
		}
		hr{
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
<section id="sidebar">
		<a href="profile.php" class="brand">
			<img src="./images/ccs.png" height="100px">
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="home.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="homeview.php">
					<i class='bx bxs-hourglass' ></i>
					<span class="text">Remaining Session</span>
				</a>
			</li>
			<li>
				<a href="sitinhistory.php">
					<i class='bx bx-history' ></i>
					<span class="text">View Student History</span>
				</a>
			</li>
			<li>
				<a href="reserve.php">
				<i class='bx bxs-message-square-dots'></i>
					<span class="text">Make Reservation</span>
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
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		</main>
		<div class="container">
			<h1>Site announcements</h1>
			<?php
				include('config.php');
				$sql = "SELECT * FROM mydb.announcements ORDER BY created_at DESC";
				$result = $con->query($sql);

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<div class='announcement'>";
						echo "<h3>" . $row["title"] . "</h3>";
						echo "<hr>";						
						echo "<p>" . $row["content"] . "</p>";
						echo "<div class='date'>Posted on: " . $row["created_at"] . "</div>";
						echo "</div>";
					}
				} else {
					echo "<div class='announcement empty'>";
					echo "<p>No announcements at the moment.</p>";
					echo "</div>";
				}
				$con->close();
			?>
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
	document.getElementById('feedbackLink').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('feedbackForm').style.display = 'block';
    });

    document.getElementById('feedbackSubmitForm').addEventListener('submit', function(e) {
        alert('Feedback submitted successfully!');
    });

	</script>
</html>
