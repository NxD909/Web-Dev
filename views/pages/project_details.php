<?php
session_start();

// 1. Check if an ID was passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No project ID was provided.");
}

$project_id = $_GET['id'];

// 2. Connect to the database
include("../../config.php");

// 3. Fetch the specific project using a Prepared Statement (For Security)
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $project_id); // "i" means integer
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

// Check if the project actually exists in the database
if (!$project) {
    die("Error: Project not found.");
}
?>

<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/code.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title><?= htmlspecialchars($project['title']) ?> | Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* --- MODERN UI STYLES --- */
        :root {
            --accent-color: #007bff;
            --accent-hover: #0056b3;
            --card-bg: rgba(30, 30, 30, 0.85);
            --card-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8f9fa;
            --text-muted: #adb5bd;
        }

        .project-details-container {
            max-width: 900px;
            margin: 120px auto 60px;
            padding: 40px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            color: var(--text-main);
            position: relative;
        }

        /* --- UPDATED BACK BUTTON STYLES --- */
        .back-btn-wrapper {
            margin-bottom: 25px;
            display: flex;
            justify-content: flex-start;
            /* Keeps it aligned to the left for best UX */
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.05);
            /* Subtle dark background */
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            /* Pill shape */
            color: var(--text-main);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            transform: translateX(-5px);
            /* Slide left effect */
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }

        /* ---------------------------------- */

        .project-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--card-border);
            padding-bottom: 10px;
            display: inline-block;
        }

        .project-description {
            font-size: 1.15rem;
            line-height: 1.8;
            color: #d1d5db;
            margin-bottom: 30px;
        }

        .tech-stack-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .tech-badge {
            background: rgba(0, 123, 255, 0.15);
            color: #66b2ff;
            border: 1px solid rgba(0, 123, 255, 0.3);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .project-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
            border-top: 1px solid var(--card-border);
            padding-top: 20px;
        }

        .project-links a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .project-links a:hover {
            background-color: var(--accent-hover);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }

        .project-links a.github-btn {
            background-color: #24292e;
        }

        .project-links a.github-btn:hover {
            background-color: #1b1f23;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        /* --- AUTO-PLAY CAROUSEL CSS --- */
        .carousel-container {
            position: relative;
            width: 100%;
            margin-bottom: 30px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--card-border);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            background: #000;
        }

        .carousel-slide {
            display: none;
            width: 100%;
            animation: fadeEffect 0.8s ease-in-out;
        }

        .carousel-slide.active {
            display: block;
        }

        .carousel-slide img,
        .single-image {
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            display: block;
            cursor: zoom-in;
        }

        .prev-btn,
        .next-btn {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: auto;
            padding: 16px;
            color: white;
            font-size: 24px;
            font-weight: bold;
            transition: 0.3s ease;
            border-radius: 0 8px 8px 0;
            user-select: none;
            background-color: rgba(0, 0, 0, 0.4);
            border: none;
            z-index: 10;
        }

        .next-btn {
            right: 0;
            border-radius: 8px 0 0 8px;
        }

        .prev-btn {
            left: 0;
        }

        .prev-btn:hover,
        .next-btn:hover {
            background-color: rgba(0, 123, 255, 0.8);
        }

        @keyframes fadeEffect {
            from {
                opacity: 0.4;
            }

            to {
                opacity: 1;
            }
        }

        /* --- LIGHTBOX/MODAL CSS --- */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(8px);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.8);
            animation: zoom 0.3s ease;
        }

        @keyframes zoom {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close-modal:hover,
        .close-modal:focus {
            color: var(--accent-color);
            text-decoration: none;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .project-details-container {
                padding: 25px;
                margin-top: 100px;
            }

            .project-title {
                font-size: 2.2rem;
            }

            .carousel-slide img,
            .single-image {
                aspect-ratio: 4 / 3;
            }

            .modal-content {
                width: 100%;
            }
        }
    </style>
</head>

<body class="darkmode">
    <!-- ---------- NAVBAR ---------- -->
    <?php include("./partials/nav_bar.php"); ?>

    <!-- --- THE LIGHTBOX MODAL --- -->
    <div id="imageModal" class="modal">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="fullImage">
    </div>

    <div class="project-details-container">

        <!-- --- BACK BUTTON (MOVED TO TOP) --- -->
        <div class="back-btn-wrapper">
            <a href="index.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Portfolio</a>
        </div>

        <!-- Project Title -->
        <h1 class="project-title">
            <?= htmlspecialchars($project['title']) ?>
        </h1>

        <!-- --- AUTO-PLAY CAROUSEL HTML --- -->
        <?php
        $images = json_decode($project['image'], true);
        if (is_array($images) && count($images) > 0):
            ?>
            <div class="carousel-container" id="projectCarousel">
                <?php foreach ($images as $index => $img_path):
                    $fixed_path = str_replace('../assets/', '../../assets/', $img_path);
                    $active_class = ($index === 0) ? 'active' : '';
                    ?>
                    <div class="carousel-slide <?= $active_class ?>">
                        <img src="<?= htmlspecialchars($fixed_path) ?>" alt="Project Screenshot" class="clickable-img">
                    </div>
                <?php endforeach; ?>

                <?php if (count($images) > 1): ?>
                    <button class="prev-btn" onclick="changeSlide(-1)">&#10094;</button>
                    <button class="next-btn" onclick="changeSlide(1)">&#10095;</button>
                <?php endif; ?>
            </div>

        <?php elseif (!empty($project['image'])):
            $fixed_single_path = str_replace('../assets/', '../../assets/', $project['image']);
            ?>
            <div class="carousel-container">
                <img src="<?= htmlspecialchars($fixed_single_path) ?>" alt="Project Screenshot"
                    class="clickable-img single-image">
            </div>
        <?php endif; ?>
        <!-- --------------------------- -->

        <!-- Tech Stack Badges -->
        <div class="tech-stack-container">
            <?php
            $tech_raw = htmlspecialchars($project['tech_stack']);
            $tech_array = explode(',', $tech_raw);
            foreach ($tech_array as $tech) {
                $tech = trim($tech);
                if (!empty($tech)) {
                    echo "<span class='tech-badge'>  " . $tech . "</span>";
                }
            }
            ?>
        </div>

        <!-- Description -->
        <div style="margin-top: 30px;">
            <h3 class="section-title">About the Project</h3>
            <p class="project-description"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
        </div>

        <!-- Action Links -->
        <div class="project-links">
            <?php if (!empty($project['demo_link'])): ?>
                <a href="<?= htmlspecialchars($project['demo_link']) ?>" target="_blank">
                    <i class="fa-solid fa-earth-americas"></i> Live Demo
                </a>
            <?php endif; ?>

            <?php if (!empty($project['github_link'])): ?>
                <a href="<?= htmlspecialchars($project['github_link']) ?>" target="_blank" class="github-btn">
                    <i class="fa-brands fa-github"></i> GitHub Repo
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- --- JAVASCRIPT LOGIC --- -->
    <script>
        // --- 1. CAROUSEL LOGIC ---
        let slideIndex = 0;
        let slides = document.querySelectorAll(".carousel-slide");
        let autoPlayTimer;

        function changeSlide(n) {
            showSlide(slideIndex += n);
            resetAutoPlay();
        }

        function showSlide(n) {
            if (slides.length === 0) return;
            if (n >= slides.length) { slideIndex = 0; }
            if (n < 0) { slideIndex = slides.length - 1; }

            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            slides[slideIndex].classList.add("active");
        }

        function startAutoPlay() {
            if (slides.length > 1) {
                autoPlayTimer = setInterval(function () {
                    changeSlide(1);
                }, 5000);
            }
        }

        function resetAutoPlay() {
            clearInterval(autoPlayTimer);
            startAutoPlay();
        }

        startAutoPlay();

        const carouselContainer = document.getElementById("projectCarousel");
        if (carouselContainer && slides.length > 1) {
            carouselContainer.addEventListener('mouseenter', () => clearInterval(autoPlayTimer));
            carouselContainer.addEventListener('mouseleave', startAutoPlay);
        }

        // --- 2. LIGHTBOX / MODAL LOGIC ---
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("fullImage");
        const closeModalBtn = document.getElementsByClassName("close-modal")[0];
        const clickableImages = document.querySelectorAll(".clickable-img");

        clickableImages.forEach(img => {
            img.addEventListener("click", function () {
                modal.style.display = "block";
                modalImg.src = this.src;
                clearInterval(autoPlayTimer);
            });
        });

        closeModalBtn.onclick = function () {
            modal.style.display = "none";
            resetAutoPlay();
        }

        modal.onclick = function (e) {
            if (e.target !== modalImg) {
                modal.style.display = "none";
                resetAutoPlay();
            }
        }
    </script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>