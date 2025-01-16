<?php
session_start();

include("config.php");
$query = "SELECT idno, firstName, middleName, lastName, email, session FROM users WHERE idno = '{$_SESSION['idno']}'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) == 1) {
    $userData = mysqli_fetch_assoc($result);
    $_SESSION['idno'] = $userData['idno'];
    $_SESSION['firstName'] = $userData['firstName'];
    $_SESSION['middleName'] = $userData['middleName'];
    $_SESSION['lastName'] = $userData['lastName'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['session'] = $userData['session'];
} else {
    echo "Error updating session";
}
?>
