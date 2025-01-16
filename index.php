<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Role Selection</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

		:root{
			--black: #2c2b30;
			--gray: #4f4f51;
			--white: #fff;
			--pink: #f2c4ce;
			--orange: #f58f7c;
			--bg: linear-gradient(180deg, rgba(116,6,233,0.68) 0%, rgba(175,123,125,0.49343487394957986) 47%, rgba(241,255,3,0.68) 100%);
			--role_bg: #413543;
		}
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			background: var(--bg);
		}
		h1 {
			text-align: center;
		}
		.admin-con {
			display: flex;
			flex-direction: column;
			align-items: center;
			background: var(--role_bg);
			border: 1px solid #ccc;
			padding: 10px;
			margin: 10px;
			border-radius: 30px;
			width: 250px;
		}
		.admin-con img:hover{
			transform: scale(1.5);
		}
		.student-con {
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #413543;
			border: 1px solid #ccc;
			padding: 10px;
			margin-left: 100px;
			border-radius: 30px;
			width: 250px;
		}
		.student-con img:hover{
			transform: scale(1.5);
		}
		img {
			width: 200px;
			height: 200px;
			margin-bottom: 10px;
		}
		.label {
			font-family: 'Poppins', sans-serif;
			font-weight: 500;
			font-size: 18px;
			color: var(--white);
		}
	</style>
</head>
<body>
    <div class="admin-con">
		<a href="adminlogin.php"><img src="./images/admin.jpg" alt="Admin"></a>
		<span class="label">Admin</span>
	</div>
    <div class="student-con">
		<a href="login.php"><img src="./images/student.png" alt="Student"></a>
		<span class="label">Student</span>
	</div>
</body>
</html>
