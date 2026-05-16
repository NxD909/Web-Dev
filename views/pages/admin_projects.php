<?php include("../../config.php"); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Admin | Projects </title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="scriptForm.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f5f2;
            margin: 0;
            padding: 0;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 20px;
            text-align: center;
            background: linear-gradient(60deg, #5a3e85, white);

        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #5a3e85;
        }

        .products-table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 8px 25px rgba(90, 62, 133, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .products-table th {
            background-color: #5a3e85;
            color: #fff;
            padding: 14px;
            font-size: 16px;
        }

        .products-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        .products-table tr:nth-child(even) {
            background-color: #f3effa;
        }

        .products-table tr:hover {
            background-color: #e6ddf5;
        }

        .pro-btn {
            background-color: #f3effa;
        }

        .pro-btn:hover {
            background-color: #e6ddf5;
        }

        .action-links a {
            margin: 0 6px;
            text-decoration: none;
            color: #6b4226;
            font-weight: bold;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>


    <?php
    mysqli_select_db($conn, "myportfolio");


    $result = mysqli_query($conn, "SELECT * FROM projects");
    ?>

    <h2>Projects Management</h2>
    <div class="add-pro-btn">
        <button class="pro-btn" onclick="window.location.href='add_project_form.php'">
            <i class="fa-regular fa-square-plus"></i> Add Project </button>
    </div>
    <table style="border=1; cellpadding=10;" class="products-table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
        </tr>


        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td class="action-links">
                    <a href="../../controllers/delete_project.php?id=<?= $row['id'] ?>">Delete</a>|
                    <a href="edit_project.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="view_project.php?id=<?= $row['id'] ?>">View</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <dev class="admin-form">
        <a href="index.php" class="admin-button admin-rev"><i class="fa-solid fa-circle-arrow-left"></i> Back </a>
    </dev>
    <!-- ---------- FOOTER ---------- -->
    <footer>
        <section style="padding: 10px 20px 20px 20px">© 2026 Ayman Omer
            <div class="contact-info">
                <a href="tel:+966537383513">
                    <i class="fa-solid fa-phone"></i> +966537383513
                </a>
                <br>
                <a href="mailto:aymanomer2005@gmail.com">
                    <i class="fa-solid fa-envelope"></i> aymanomer2005@gmail.com
                </a>
            </div>
        </section>

        <ul>
            <a href="https://github.com/NxD909" target="_blank" class="social-icon"><i
                    class="fa-brands fa-github"></i></a>
            <a href="https://www.facebook.com/AymanOmer2005/" target="_blank" class="social-icon"><i
                    class="fa-brands fa-facebook"></i></a>
            <a href="https://www.linkedin.com/in/aymanomerel-amin/" target="_blank" class="social-icon"><i
                    class="fa-brands fa-linkedin"></i></a>
        </ul>
    </footer>
</body>

</html>