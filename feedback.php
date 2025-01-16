<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idno = $_POST['idno'];
    $session = $_POST['session'];
    $feedback = $_POST['feedback'];
    $checkQuery = "SELECT * FROM mydb.login_history WHERE idno = ? AND session = ? AND feedback IS NOT NULL";
    $checkStmt = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 'ii', $idno, $session);
    mysqli_stmt_execute($checkStmt);
    $existingFeedback = mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);

    if ($existingFeedback) {
        echo "<script>alert('Feedback already exists for this entry.'); window.location.href='sitinhistory.php';</script>";
    } else {
        $updateQuery = "UPDATE mydb.login_history SET feedback = ? WHERE idno = ? AND session = ?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'sii', $feedback, $idno, $session);
        $insertQuery = "INSERT INTO mydb.feedback (idno, message) VALUES (?, ?)";
        $insertStmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'is', $idno, $feedback);
        mysqli_begin_transaction($con);
        $updateResult = mysqli_stmt_execute($updateStmt);
        $insertResult = mysqli_stmt_execute($insertStmt);

        if ($updateResult && $insertResult) {
            mysqli_commit($con);
            echo "<script>alert('Feedback submitted successfully!'); window.location.href='sitinhistory.php';</script>";
        } else {
            mysqli_rollback($con);
            echo "<script>alert('Error submitting feedback: " . mysqli_error($con) . "'); window.location.href='sitinhistory.php';</script>";
        }

        mysqli_stmt_close($updateStmt);
        mysqli_stmt_close($insertStmt);
    }

    mysqli_close($con);
} else {
    header("Location: sitinhistory.php");
    exit;
}
?>

