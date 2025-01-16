<?php
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['firstname'])) {
        // Redirect to the login page if not logged in
        header("Location: adminlogin.php");
        exit;
    }

    // Include database connection
    include("config.php");

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate inputs
        $id = $_POST['id'];
        $new_password = $_POST['new_password'];

        // Update password in the database
        $sql = "UPDATE users SET password = ? WHERE idno = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $new_password, $id);

	if ($stmt->execute()) {
		// Alert the user about successful submission
		echo "<script>alert('Password reset successfull!');</script>";
		// Redirect back to the original page after form submission
		echo '<script>window.location.href = "adminreset.php";</script>';
		exit(); // Ensure that script execution stops after redirection
	} else {
		// If there's an error, display a generic error message
		 echo "<script>alert('An error occurred. Please try again later.');</script>";
	}
        // Close statement
        $stmt->close();
    }

    // Close connection
    $con->close();
?>
