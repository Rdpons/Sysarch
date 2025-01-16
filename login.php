<?php
session_start();
include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $userData['id'];
        $_SESSION['idno'] = $userData['idno'];
        $_SESSION['firstName'] = $userData['firstName'];
        $_SESSION['middleName'] = $userData['middleName'];
        $_SESSION['lastName'] = $userData['lastName'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['session'] = $userData['session'];
        header("refresh:1;url=rules.php");
        exit;
    } else {
        $error = "<span style='color: red;'>Invalid email or password</span>";
		echo $error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./images/logo2.png" type="image/x-icon">
	<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

	:root{
		--black: #2c2b30;
		--gray: #4f4f51;
		--white: #fff;
		--pink: #f2c4ce;
		--orange: #f58f7c;
		--bg: linear-gradient(180deg, rgba(116,6,233,0.68) 0%, rgba(175,123,125,0.49343487394957986) 47%, rgba(241,255,3,0.68) 100%);
	}
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		font-family: 'Poppins', sans-serif;
	}

	body{
		display: flex;
		justify-content: center;
		align-items: center;
		min-height: 100vh;
		background: var(--bg);
	}

	.wrapper{  
		background: var(--white);
		color: var(--black);
		width: 500px;
		height: 550px;
		border-top-right-radius: 30px;
		border-bottom-right-radius: 30px;
		padding: 30px 40px;
		margin-left: 500px;	
	}

	.wrapper h1{
		padding: 30px;
		font-size: 36px;
		text-align: center;
	}

	.wrapper .input-box{
		position: relative;
		width: 400px;
		height: 50px;
		margin: 30px 0;
	}

	.input-box input{
		border: 1px solid;
		width: 100%;
		height: 100%;
		background: var(--white);
		border-radius: 40px;
		font-size: 16px;
		padding: 20px 45px 20px 20px;
	}

	.input-box input::placeholder{
		color: var(--black);
	}
	.wrapper .forgot{
		display: flex;
		justify-content: space-between;
		font-size: 14.5px;
		margin: -15px 0 15px;
	}

	.forgot label input{
		accent-color: var(--black);
		margin-right: 3px;
	}

	.forgot a{
		color: var(--black);
		text-decoration: none;
	}
	.forgot a:hover{
		text-decoration: underline;
		color: violet;
	}
	.wrapper .btn{
		margin-left: 110px;
		width: 200px;
		height: 45px;
		background: var(--black);
		border: none;
		outline: none;
		border-radius: 40px;
		box-shadow: 0 0 10px rgba(0, 0, 0, .1);
		cursor: pointer;
		color: var(--white);
		font-weight: 600;
		font-size: 25px;
		padding: 1px 0px;

	}
	.wrapper .btn:hover{
		padding: 1px 0px;
		text-align: center;
		font-size: 25px;
		color: var(--white);
		background: violet;
		font-weight: 700;
	}
	.wrapper .register{
		font-size: 14.5px;
		text-align: center;
		margin-top: 20px;
	}
	.register p a{
		color: var(--black);
		text-decoration: none;
		font-weight: 600;
	}
	.register p a:hover{
		text-decoration: underline;
		color: violet;
	}

	.wrapper .login{
		font-size: 14.5px;
		text-align: center;
		margin-top: 20px;
	}
	.login p a{
		color: var(--pink);
		text-decoration: none;
	}
	.login p a:hover{
		text-decoration: underline;
		color: var(--bg);
	}
	.input-box select {
		width: 100%;
		height: 50px;
		background: transparent;
		border: none;
		outline: none;
		border: 2px solid rgba(255, 255, 255, .2);
		border-radius: 40px;
		font-size: 16px;
		color: var(--white);
		padding: 0 45px 0 20px; 
		-webkit-appearance: none; 
		-moz-appearance: none;
		appearance: none;
	}

	.input-box select::placeholder {
		color: var(--white);
	}

	.input-box i {
		position: absolute;
		right: 20px;
		top: 50%;
		transform: translateY(-50%);
		font-size: 20px;
		color: var(--black);
	}
	.input-box textarea {
		width: 100%;
		background: transparent;
		border: none;
		outline: none;
		border: 2px solid rgba(255, 255, 255, .2);
		border-radius: 10px; 
		font-size: 16px;
		color: var(--white);
		padding: 20px; 
	}
	.input-box textarea::placeholder {
		color: var(--white);
	}
	label {
		display: block;
		margin-bottom: 5px;
		color: var(--black);
	}

	.btn-wrapper {
		text-align: center;
		margin-top: 20px;
	}

	.btn {
		display: inline-block;
		padding: 10px 20px;
		background-color: var(--pink);
		color: var(--black);
		text-decoration: none;
		border-radius: 5px;
		transition: background-color 0.3s;
	}

	.btn:hover {
		background-color: var(--orange);
	}
	.hero{
		width: 500px;
		height: 550px;
		background: var(--white);
		border-top-left-radius: 30px;
		border-bottom-left-radius: 30px;
		position: absolute;
		left: 200px;
		background: rgba( 255, 255, 255, 0.05 );
		box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
		backdrop-filter: blur( 12.5px );
		-webkit-backdrop-filter: blur( 12.5px );
		border-top-left-radius: 30px;	
	}
	.ccs-image{
		padding: 100px 0px;
		margin-left: 125px;
		
	}
	.ccs-image h1{
		font-size: 25px;
		position: absolute;
		top: 390px;
		left: 40px;
		color: var(--white);
		text-shadow: 5px 1px 3px #000000;
	}
	</style>
</head>
<body>
<?php
if(isset($_GET['register']) && $_GET['register'] == 'success') {
    echo '<p style="color: green;">Registration successful!</p>';
}
?>
<div class="wrapper">
    <form id="loginForm" action="#" method="post">
	<h1>Student Login</h1>
    <div class="input-box">
                <input type="text" name="email" placeholder="Email" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Password" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>
            <div class="forgot">
                <label><input type="checkbox" name="remember">Remember Me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
        </div>
	<div class="hero">
    <div class="ccs-image">
        <a href="index.php">
            <img src="./images/ccs.png" alt="logo" width="250" height="300">
        </a>
        <h1>CCS SIT-IN MONITORING SYSTEM</h1>
    </div>
</div>
</body>
<script>
    function clearPlaceholder(element) {
        element.placeholder = '';
    }
    function restorePlaceholder(element) {
        element.placeholder = element.getAttribute('data-placeholder');
    }
</script>
</html>
