<?php
session_start();
if (!isset($_SESSION['firstname'])) {
    header("Location: adminlogin.php");
    exit;
}

include('config.php');

$title = $_POST['title'];
$content = $_POST['content'];

$stmt = $con->prepare("INSERT INTO ponsica.announcements (title, content) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $content);

if ($stmt->execute()) {
    echo "<script>alert('Announcement created successfully');</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$con->close();

?>
