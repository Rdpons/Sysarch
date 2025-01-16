<?php	
	include("config.php");
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$idno = $_POST['idno'];
		$firstName = $_POST['firstName'];
		$middleName = $_POST['middleName'];
		$lastName = $_POST['lastName'];
		$password = $_POST['password'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$contact = $_POST['contact'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		
		if(!empty($email) && !empty($password) && !is_numeric($email)) {
			$query = "INSERT INTO users (idno, firstName, middleName, lastName, password, age, gender, contact, email, address) VALUES ('$idno','$firstName','$middleName','$lastName','$password','$age','$gender','$contact','$email','$address')";
			if(mysqli_query($con, $query)) {
				$insertSitInQuery = "INSERT INTO users_sitin (idno, firstName, middleName, lastName, password, age, gender, contact, email, address) VALUES ('$idno','$firstName','$middleName','$lastName','$password','$age','$gender','$contact','$email','$address')";
				if(mysqli_query($con, $insertSitInQuery)) {
					echo "<script type='text/javascript'> alert('Registration successful!'); window.location='login.php'; </script>";
					exit;
				} else {
					echo "<script type='text/javascript'> alert('Error in registration!'); window.location='register.php'; </script>";
					exit;
				}
			} else {
				echo "<script type='text/javascript'> alert('Error in registration!'); window.location='register.php'; </script>";
				exit;
			}
		} else {
			echo "<script type='text/javascript'> alert('Invalid information!'); window.location='register.php'; </script>";
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
	<link rel="icon" href="./images/logo2.png" type="image/x-icon">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bg);
    }
    .container{
      position: relative;
      background-color: var(--white);
      width: 100%;
      border-radius: 30px;
      max-width: 900px;
      padding: 30px;
      margin: 0 15px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
    .container header{
      position: relative;
      font-size: 20px;
      font-weight: 600;
      color: var(--gray);
    }
    .container header::before{
      content: "";
      position: absolute;
      left: 0;
      bottom: -2px;
      height: 3px;
      width: 27px;
      background-color: violet;
      border-radius: 8px;
    }
    .container form{
      position: relative;
      min-height: 490px;
      margin-top: 16px;
      background-color: var(--white);
    }
    .container form .details{
      margin-top: 30px;
    }
    .container form .title{
      display: block;
      margin-bottom: 8px;
      font-size: 16px;
      font-weight: 500;
      margin: 6px 0;
      color: var(--gray);
    }
    .container form .fields{
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }
    form .fields .input-fields{
      display: flex;
      width: calc(100% / 3 - 15px);
      flex-direction: column;
      margin: 4px 0;
    }
    .input-fields label{
      font-size: 12px;
      font-weight: 500;
      color: var(--gray);
    }
    .input-fields input{
      height: 42px;
      font-size: 14px;
      color: var(--gray);
      margin: 8px 0;
      outline: none;
      border: 1px solid #aaa;
      border-radius: 5px;
      padding: 0 15px;
    }
    .input-fields input:is(:focus, :valid){
      box-shadow: 0 3px 6px rgba(0,0,0,0.13);
    }
    .input-fields select {
      height: 42px;
      font-size: 14px;
      color: var(--gray);
      margin: 8px 0;
      outline: none;
      border: 1px solid #aaa;
      border-radius: 5px;
      padding: 0 15px;
      appearance: none; 
      background-image: url('data:image/svg+xml;utf8,<svg fill="%234f4f51" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
      background-repeat: no-repeat;
      background-position: right 10px top 50%;
      background-size: 24px auto;
    }
    .input-fields textarea {
      font-size: 14px;
      color: var(--gray);
      margin: 8px 0;
      outline: none;
      border: 1px solid #aaa;
      border-radius: 5px;
      padding: 8px 15px;
      resize: vertical; 
    }
    .btn {
      background-color: var(--black);
      color: var(--white);
      font-size: 16px;
      font-weight: bold;
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .btn input[type="submit"] {
      background: none;
      border: none;
      color: inherit;
      font: inherit;
      padding: 0;
      cursor: pointer;
    }
    .btn:hover {
      background: violet;
    }
	.back-btn a {
            background-color: var(--black);
            color: var(--white);
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
			margin-left: 130px;
			position: absolute;
			top: 429px;
        }
        .back-btn a:hover {
            background-color: violet;
        }
	</style>
</head>
<body>
<div class="container">
	<header>Registration</header>
    <form method="POST" class="registration-container">
	<div class="form first">
        <div class="details personal">
          <span class="title">Personal Details</span>
          <div class="fields">
            <div class="input-fields">
              <label>Id Number</label>
              <input type="text" name="idno" placeholder="Id Number" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="ID Number" required>
            </div>
            <div class="input-fields">
              <label>First Name</label>
              <input type="text" name="firstName" placeholder="First Name" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="First Name"required>
            </div>
            <div class="input-fields">
              <label>Middle Name</label>
              <input type="text" name="middleName" placeholder="Middle Name" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Middle Name" required>
            </div>
            <div class="input-fields">
              <label>Last Name</label>
              <input type="text" name="lastName" placeholder="Last Name" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Last Name" required>
            </div>
            <div class="input-fields">
              <label>Age</label>
              <input type="text" name="age" placeholder="Age" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Age" required>
            </div>
            <div class="input-fields">
              <label>Gender</label>
              <select name="gender" id="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="input-fields">
              <label>Contact Number</label>
              <input type="text" name="contact" placeholder="Contact Number" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Contact Number" required>
            </div>
            <div class="input-fields">
              <label>Address</label>
              <textarea name="address" id="address" cols="1" rows="1" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Address"></textarea>
            </div>
          </div>
        </div>
        <div class="form first">
          <div class="details personal">
            <span class="title">Account Details</span>
            <div class="fields">
              <div class="input-fields">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Email" required>
              </div>
              <div class="input-fields">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Password" required>
              </div>
              <div class="input-fields">
                <label>Confirm Password</label>
                <input type="password" name="password" placeholder="Password" onclick="clearPlaceholder(this)" onfocusout="restorePlaceholder(this)" data-placeholder="Confirm Password" required>
              </div>   
            </div>
            <button class="btn">
        <input type="submit" value="Register" name="save" class="btn">
		</button>
			<div class="back-btn">
                <a href="login.php">Back</a>
            </div>
          </div>
      </div>
    </form>
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
