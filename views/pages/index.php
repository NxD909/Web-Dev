<?php
session_start();

// --- 1. DATABASE CONNECTION ---
include("../../config.php");

// --- 2. FETCH PROJECTS ---
$sql = "SELECT * FROM projects ORDER BY id DESC";
$projects_result = $conn->query($sql);
// ------------------------------

if (isset($_SESSION['success'])) {
    ?>
    <div id="alertBox" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: #28a745;
    color: white;
    padding: 15px 25px;
    border-radius: 10px;
    font-size: 16px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    z-index: 9999;
    transition: opacity 0.5s ease;
">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
    </div>

    <script>
        setTimeout(function () {
            let alertBox = document.getElementById("alertBox");
            if (alertBox) {
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 3000);
    </script>

    <?php
}
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/code.png" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title>Ayman Omer | Portfolio</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/JavaScript" src="../assets/js/script.js" defer></script>

    <style>
        [data-lang="ar"] {
            /* Hide arabic lang by default */
            display: none;
        }
    </style>
</head>

<body>
    <?php include("./partials/nav_bar.php"); ?>

    <button id="theme-switch">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
            <path
                d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
            <path
                d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z" />
        </svg>
    </button>

    <button id="lang" onclick="toggleLanguage()">
        <i style="font-size: large;" class="fa-solid fa-language"></i>
    </button>

    <section class="hero">
        <img src="../assets/images/pfp.avif" alt="Profile Picture" class="profile-img" />
        <h1 data-lang="en">Ayman Omer</h1>
        <h1 data-lang="ar"> أيمن عمر</h1>
        <p data-lang="en">Web Developer | Student | 2026 Trainee</p>
        <p data-lang="ar">مطور ويب | طالب | متدرب 2026</p>
    </section>

    <section id="about" class="section">
        <h2 data-lang="en">About Me</h2>
        <h2 data-lang="ar">من نحن</h2>
        <p data-lang="en">
            Hello! Welcome to my website! <br />
            My name is Ayman Omer, am a Computer Science student at
            <a href="https://bu.edu.sa/"> Al Baha University</a> <br />
            I like working with programming languges and learn about different tools
            that help me build my carrer goals and passions to be real <br />
            I have learned HTML, CSS and on my way to js and a lot more to be a full
            web Developer!
        </p>
        <p data-lang="ar">
            مرحبا! أهلا وسهلا في موقعي! <br />
            اسمي أيمن عمر، أنا طالب علوم الحاسوب في
            <a href="https://bu.edu.sa/">جامعة الباحة</a> <br />
            أحب العمل مع لغات البرمجة والتعلم عن الأدوات المختلفة
            التي تساعدني على بناء أهدافي الوظيفية وتحقيق شغفي <br />
            لقد تعلمت HTML و CSS وأنا في طريقي لتعلم JavaScript والكثير غيره لأصبح
            مطور ويب كامل!
        </p>
    </section>

    <section id="certificates" class="section">
        <h2 data-lang="en">Certificates</h2>
        <h2 data-lang="ar">الشهادات</h2>
        <div class="certificates">
            <div class="card">
                <span data-lang="en">HTML Essentials<br />
                    <a href="https://www.netacad.com/">Cisco Networking Academy</a></span>
                <span data-lang="ar">أساسيات HTML<br />
                    <a href="https://www.netacad.com/">أكاديمية سيسكو للشبكات</a></span>
            </div>
            <div class="card">
                <span data-lang="en">Data Fundamentals<br /><a href="https://skillsbuild.org/">IBMSkillsBuild</a></span>
                <span data-lang="ar">أساسيات البيانات<br /><a href="https://skillsbuild.org/">IBMSkillsBuild</a></span>
            </div>
            <div class="card">
                <span data-lang="en">Certificate 3</span>
                <span data-lang="ar">الشهادة 3</span>
            </div>
        </div>
    </section>

    <section id="skills" class="section">
        <h2 data-lang="en">Skills</h2>
        <h2 data-lang="ar">المهارات</h2>
        <div class="skills">
            <div class="card">HTML <i class="fa-brands fa-html5"></i></div>
            <div class="card">CSS <i class="fa-brands fa-css3-alt"></i></div>
            <div class="card">JavaScript <i class="fa-brands fa-js"></i></div>
            <div class="card">Php <i class="fa-brands fa-php"></i></div>
            <div class="card">SQL <i class="fa-solid fa-database"></i></div>
        </div>
    </section>

    <section id="projects" class="section">
        <h2 data-lang="en">My Projects</h2>
        <h2 data-lang="ar">مشاريعي</h2>
        <div class="projects">

            <?php
            // --- 3. DISPLAY PROJECTS DYNAMICALLY ---
            if ($projects_result && $projects_result->num_rows > 0):
                while ($project = $projects_result->fetch_assoc()):
                    ?>
                    <a href="project_details.php?id=<?= htmlspecialchars($project['id']) ?>" class="card">
                        <?= htmlspecialchars($project['title']) ?>
                    </a>
                    <?php
                endwhile;
            else:
                ?>
                <p data-lang="en">No projects added yet.</p>
                <p data-lang="ar">لم يتم إضافة مشاريع بعد.</p>
            <?php endif; ?>

            <a href="admin_projects.php" class="button">
                <span data-lang="en">Projects Management</span>
                <span data-lang="ar">إدارة المشاريع</span>
            </a>
        </div>
    </section>

    <section id="contact" class="section">
        <h2 data-lang="en">Contact Us</h2>
        <h2 data-lang="ar">تواصل معنا</h2>
        <form id="messageForm" action="../../controllers/insert_msg.php" method="post">
            <input type="text" placeholder="Enter your Name" data-lang="en" id="name" name="name" required />
            <input type="text" placeholder="أدخل اسمك" data-lang="ar" id="name" name="name" required />

            <input type="email" placeholder="Email" data-lang="en" id="email" name="email" required />
            <input type="email" placeholder="البريد الإلكتروني" data-lang="ar" id="email" name="email" required />

            <textarea rows="5" placeholder="Message" data-lang="en" id="message" name="message" required></textarea>
            <textarea rows="5" placeholder="الرسالة" data-lang="ar" id="message" name="message" required></textarea>

            <button class="button" type="submit" data-lang="en">Send</button>
            <button class="button" type="submit" data-lang="ar">إرسال</button>
        </form>
    </section>

    <footer>
        <section style="padding: 10px 20px 20px 20px">
            <span data-lang="en"> © 2026 Ayman Omer</span>
            <span data-lang="ar"> © 2026 أيمن عمر</span>
            <div class="contact-info">
                <a href="tel:+966537383513" dir="ltr">
                    <i class="fa-solid fa-phone"></i> +966537383513
                </a>
                <br>
                <a href="mailto:aymanomer2005@gmail.com" dir="ltr">
                    <i class="fa-solid fa-envelope"></i> aymanomer2005@gmail.com
                </a>
            </div>
        </section>

        <ul dir="ltr">
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

<?php
// Close the database connection at the very end of the file
if (isset($conn)) {
    $conn->close();
}
?>