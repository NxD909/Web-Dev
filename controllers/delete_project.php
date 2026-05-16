<?php
include "../config.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM projects WHERE id = $id");

header("Location: ../views/pages/admin_projects.php");
exit;
