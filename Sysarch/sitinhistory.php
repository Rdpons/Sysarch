<?php
session_start();
if (!isset($_SESSION['idno'])) {
    header("Location: login.php");
    exit;
}
include("config.php");
$idno = $_SESSION['idno'];

$query = "SELECT * FROM mydb.login_history WHERE idno = ?";
$statement = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($statement, 'i', $idno);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);
if (!$result) {
    die('Error fetching data: ' . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<title>Student History</title>
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
                margin-top: 100px;
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
            input[type="number"],
            input[type="text"] {
                padding: 8px;
                margin-bottom: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                font-size: 14px;
                margin-left: 50px;
            }
            .student{
                margin-right: 280px;
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
            .latest table {
                width: 100%; 
                border-collapse: collapse; 
                margin-bottom: 20px; 
                background-color: white; 
            }

            .latest table th,.latest table td {
                padding: 12px;
                text-align: left; 
                border-bottom: 1px solid #ddd; 
                color: #333; 
            }

            .latest table th {
                background-color: white; 
                font-weight: bold; 
            }

            .latest table tr:hover {
                background-color: #f5f5f5; 
            }

            .latest table tr:hover {
                background-color: #f5f5f5;
            }
            @media screen and (max-width: 768px) {
            .latest table, thead, tbody, th, td, tr {
                    display: block;
                }

            .latest table {
                    width: 100%;
                    overflow-x: auto;
                }

            .latest thead tr {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                }

            .latest table caption {
                    font-size: 1.3em;
                    margin-bottom: 10px;
                }

            .latest table th {
                    border: none;
                    border-bottom: 1px solid #eee;
                    position: relative;
                    padding-left: 50%;
                }

            .latest table td {
                    border: none;
                    border-bottom: 1px solid #eee;
                    position: relative;
                    padding-left: 50%;
                    padding-top: 10px;
                    padding-bottom: 10px;
                }

            .latest table td:before {
                    position: absolute;
                    top: 0;
                    left: 6px;
                    width: 45%;
                    padding-right: 10px;
                    white-space: nowrap;
                }

            .latest table td:nth-of-type(1):before { content: "ID Number"; }
            .latest table td:nth-of-type(2):before { content: "First Name"; }
            .latest table td:nth-of-type(3):before { content: "Last Name"; }
            .latest table td:nth-of-type(4):before { content: "Purpose"; }
            .latest table td:nth-of-type(5):before { content: "Lab"; }
            .latest table td:nth-of-type(6):before { content: "Session"; }
            }
            .latest h2{
                    color: #fff;
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
			.button1 {
				background-color: #007bff; 
				border: none;
				color: white;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				margin: 4px 2px;
				cursor: pointer;
				transition-duration: 0.4s;
				border-radius: 12px;
			}

			.button1:hover {
				background-color: #0056b3;
				color: white;
			}
			
			.download-report {
			display: block;
			margin: 20px auto;
			padding: 10px 20px;
			background-color: #007BFF;
			border: none;
			border-radius: 3px;
			color: #fff;
			font-size: 1em;
			cursor: pointer;
			transition: background-color 0.2s;
			}
			.modal {
				display: none; /* Hidden by default */
				position: fixed; /* Stay in place */
				z-index: 1000; /* Sit on top */
				left: 0;
				top: 0;
				width: 100%; /* Full width */
				height: 100%; /* Full height */
				overflow: auto; /* Enable scroll if needed */
				background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
				}
							.modal-content {
					background-color: #fefefe;
					margin: 25% auto; /* Center the modal */
					padding: 20px;
					border: 1px solid #888;
					width: 50%; /* Width of the modal */
					max-width: 400px; /* Maximum width */
					border-radius: 10px; /* Rounded corners */
				}

				/* Style for the close button inside the modal */
				.close {
					color: #aaa;
					float: right;
					font-size: 28px;
					font-weight: bold;
				}

				.close:hover,
				.close:focus {
					color: black;
					text-decoration: none;
					cursor: pointer;
				}

				/* Style for the feedback form itself */
				.feedback-form {
					margin-top: 20px; /* Space from the top */
					padding: 24px; /* Padding around the form */
					background: var(--light); /* Background color */
					border-radius: 20px; /* Rounded corners */
					display: flex;
					flex-direction: column;
					align-items: center; /* Center items */
					gap: 16px; /* Space between form elements */
					width: 100%; /* Full width */
				}

				/* Style for the textarea */
				#message {
					width: 100%; /* Full width */
					height: 150px; /* Height */
					padding: 16px; /* Padding */
					border: 1px solid #ccc; /* Border */
					border-radius: 5px; /* Rounded corners */
					resize: vertical; /* Allow vertical resizing */
					font-size: 16px; /* Font size */
					color: var(--dark); /* Text color */
					background: var(--grey); /* Background color */
				}

				/* Placeholder text style for the textarea */
				#message::placeholder {
					color: var(--dark-grey); /* Placeholder text color */
					text-align: center; /* Center-aligned placeholder text */
				}

				/* Style for the submit button */
				button[type="submit"] {
					padding: 12px 24px; /* Padding */
					background: var(--blue); /* Background color */
					color: var(--light); /* Text color */
					border: none; /* No border */
					border-radius: 20px; /* Rounded corners */
					cursor: pointer; /* Cursor style */
					font-size: 18px; /* Font size */
					margin-top: 20px;
					margin-right: auto;
					margin-left: auto;
				}

				/* Hover effect for the submit button */
				button[type="submit"]:hover {
					background-color: #0056b3; /* Darker shade on hover */
					color: var(--light); /* Maintain light text color */
				}
	</style>
</head>
<body>
<section id="sidebar">
		<a href="#" class="brand">
			<img src="./images/ccs.png" height="100px">
		</a>
		<ul class="side-menu top">
			<li>
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
			<li class="active">
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
    <div class="latest">
        <h2>Login History</h2>
		<hr>
		<br>
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <table id="loginHistoryTable">
                <tr>
                    <th>ID Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Purpose</th>
                    <th>Lab</th>
                    <th>Session</th>
					<th>Time in</th>
					<th>Feedback</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['idno']; ?></td>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['purpose']; ?></td>
                        <td><?php echo $row['lab']; ?></td>
                        <td><?php echo $row['session']; ?></td>
						<td><?php echo $row['timein']; ?></td>
						<td>
                            <?php if (!empty($row['feedback'])) : ?>
                                <button disabled class="button1">Feedback Given</button>
                            <?php else : ?>
                                <button class="button1" onclick="showFeedbackForm('<?php echo $row['idno']; ?>', '<?php echo $row['session']; ?>')">Leave Feedback</button>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p>No login history found for this user.</p>
        <?php endif; ?>
		<button onclick="downloadLoginHistory()" class="ee-btn">Download Login History</button>
    </div>
	<div id="feedbackModal" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeFeedbackForm()">&times;</span>
				<h2>Leave Feedback</h2>
				<form id="feedbackForm" action="feedback.php" method="POST">
					<input type="hidden" name="idno" id="feedbackIdno">
					<input type="hidden" name="session" id="feedbackSession">
					<textarea name="feedback" id="message" rows="4" placeholder="Your feedback here..." onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Your Feedback here..."></textarea>
					<button type="submit" name="submit">Submit Feedback</button>
				</form>
			</div>
		</div>
    </div>
</div>
</main>
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
	function showFeedbackForm(idno, session) {
        document.getElementById('feedbackIdno').value = idno;
        document.getElementById('feedbackSession').value = session;
        document.getElementById('feedbackModal').style.display = 'block';
    }

    function closeFeedbackForm() {
        document.getElementById('feedbackModal').style.display = 'none';
    }


</script>
</html>
