<?php
session_start();
include("../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $demo_link = $_POST['demo_link'] ?? '';
    $github_link = $_POST['github_link'] ?? '';
    $tech_stack = $_POST['tech_stack'] ?? '';

    if (empty($name) || empty($description)) {
        $_SESSION['error'] = "❌ الرجاء ملء جميع الحقول المطلوبة";
    } else {

        // --- MULTIPLE IMAGE UPLOAD LOGIC ---
        $uploaded_images = [];
        $upload_dir = '../assets/uploads/';

        // Create the directory automatically if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $key => $filename) {
                $tmp_name = $_FILES['images']['tmp_name'][$key];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $new_name = uniqid('proj_') . '.' . $ext;
                $destination = $upload_dir . $new_name;

                if (move_uploaded_file($tmp_name, $destination)) {
                    $uploaded_images[] = $destination;
                }
            }
        }

        // Encode the array to JSON for database storage
        $images_json = json_encode($uploaded_images);
        // ------------------------------------

        $stmt = $conn->prepare("INSERT INTO projects (title, description, demo_link, github_link, tech_stack, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $description, $demo_link, $github_link, $tech_stack, $images_json);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        if ($stmt->execute()) {
            $_SESSION['success'] = "✅ تم إضافة المنتج بنجاح";
        } else {
            $_SESSION['error'] = "❌ خطأ: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    header("Location: ../views/pages/add_project_form.php");
    exit();
}
?>