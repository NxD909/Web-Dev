<?php
session_start();
include "../config.php";

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (Name, Email, Message)
        VALUES ('$name', '$email', '$message')";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "تم إرسال الرسالة بنجاح ✅";
    header("Location: ../views/pages/index.php#contact");
    exit();
} else {
    echo "❌ خطأ: " . mysqli_error($conn);
}

mysqli_close($conn);
?>