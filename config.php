<?php
$conn = mysqli_connect("localhost", "root", "", "myportfolio");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
