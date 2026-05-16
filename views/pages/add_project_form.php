<?php include("../../config.php");
session_start(); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CoffeeLand | Add Project</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* --- SEARCHABLE TECH STACK CSS --- */
        .tech-stack-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .tech-input-box {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.2);
            /* Dark input background */
            min-height: 45px;
            align-items: center;
            cursor: text;
        }

        .tech-tag {
            background: #007bff;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeIn 0.2s ease;
        }

        .tech-tag i {
            cursor: pointer;
            font-size: 12px;
            transition: color 0.2s;
        }

        .tech-tag i:hover {
            color: #ff4d4d;
        }

        .tech-search {
            border: none !important;
            background: transparent !important;
            color: white !important;
            flex-grow: 1;
            outline: none;
            padding: 5px !important;
            margin: 0 !important;
            min-width: 150px;
            box-shadow: none !important;
        }

        .suggestions-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #2a2a2a;
            border: 1px solid #444;
            border-radius: 8px;
            max-height: 180px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            margin-top: 5px;
        }

        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            color: #e3e3e3;
            border-bottom: 1px solid #444;
            transition: background 0.2s;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background: #007bff;
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <main>
        <section class="form">
            <h2> Addition Form </h2>
            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-error'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>

            <form action="../../controllers/handle_add_project.php" method="post" enctype="multipart/form-data">
                <label>Project Name:</label>
                <input type="text" name="name" required />

                <label>Description</label>
                <textarea name="description" rows="2" placeholder="Add Project Description..."></textarea>

                <label>Demo Link:</label>
                <input type="text" name="demo_link" />

                <label>Github Link:</label>
                <input type="text" name="github_link" />

                <!-- --- NEW SEARCHABLE TECH STACK UI --- -->
                <label>Tech Stack:</label>
                <div class="tech-stack-wrapper">
                    <div class="tech-input-box" onclick="document.getElementById('techSearch').focus()">
                        <div id="selectedTechsContainer" style="display:flex; flex-wrap:wrap; gap:8px;"></div>
                        <input type="text" id="techSearch" class="tech-search"
                            placeholder="Type to search technologies..." autocomplete="off" />
                    </div>
                    <div class="suggestions-list" id="techSuggestions"></div>
                </div>
                <!-- This hidden input holds the comma-separated string that gets sent to PHP -->
                <input type="hidden" name="tech_stack" id="hiddenTechStack" required />
                <!-- --------------------------------------- -->

                <label>Project Images: </label>
                <div class="file-upload-wrapper">
                    <label for="image" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i> Choose images
                    </label>
                    <input type="file" id="image" name="images[]" accept="image/*" multiple required />
                    <div class="file-name" id="fileName"></div>
                </div>

                <button type="submit" class="button save">Save </button>
                <a href="admin_projects.php" class="button back"><i class="fa-solid fa-circle-arrow-left"></i> Back </a>
            </form>
        </section>
    </main>

    <script>
        // --- IMAGE UPLOAD SCRIPT ---
        document.getElementById('image').addEventListener('change', function (e) {
            const files = e.target.files;
            let text = '';
            if (files.length > 0) {
                text = '✅ ' + files.length + ' image(s) selected';
            }
            document.getElementById('fileName').textContent = text;
        });

        // --- DYNAMIC TECH STACK SCRIPT ---
        // This is now just a "Suggested" list to help you type faster.
        // It NO LONGER limits what you can add!
        const suggestedTechnologies = [
            "HTML", "CSS", "JavaScript", "PHP", "MySQL", "React", "Node.js",
            "Python", "Java", "C++", "C#", "Ruby", "Laravel", "Tailwind CSS",
            "Bootstrap", "MongoDB", "Express.js", "Git", "GitHub", "Figma"
        ];

        let selectedTechs = [];

        const searchInput = document.getElementById('techSearch');
        const suggestionsBox = document.getElementById('techSuggestions');
        const selectedContainer = document.getElementById('selectedTechsContainer');
        const hiddenInput = document.getElementById('hiddenTechStack');

        // 1. Listen for typing to show suggestions
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            suggestionsBox.innerHTML = '';

            if (!query) {
                suggestionsBox.style.display = 'none';
                return;
            }

            const filteredTechs = suggestedTechnologies.filter(tech =>
                tech.toLowerCase().includes(query) && !selectedTechs.includes(tech)
            );

            if (filteredTechs.length > 0) {
                suggestionsBox.style.display = 'block';
                filteredTechs.forEach(tech => {
                    const div = document.createElement('div');
                    div.textContent = tech;
                    div.className = 'suggestion-item';
                    div.onclick = () => addTech(tech);
                    suggestionsBox.appendChild(div);
                });
            } else {
                // Tell the user they can press Enter to add their custom tech!
                suggestionsBox.style.display = 'block';
                suggestionsBox.innerHTML = `<div class="suggestion-item" style="color: #adb5bd; font-style: italic;">
                Press "Enter" or "," to add "${this.value}"
            </div>`;
            }
        });

        // 2. THE MAGIC: Allow pressing "Enter" or "Comma" to add brand new technologies
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault(); // Stop the form from submitting accidentally!

                const newTech = this.value.trim();

                // If the input isn't empty, and isn't already selected, add it!
                if (newTech && !selectedTechs.includes(newTech)) {
                    // Capitalize the first letter nicely just in case
                    const formattedTech = newTech.charAt(0).toUpperCase() + newTech.slice(1);
                    addTech(formattedTech);
                } else {
                    // If they hit enter on an empty box or duplicate, just clear it
                    this.value = '';
                    suggestionsBox.style.display = 'none';
                }
            }
        });

        // Add a technology
        function addTech(tech) {
            selectedTechs.push(tech);
            searchInput.value = '';
            suggestionsBox.style.display = 'none';
            updateTechUI();
            searchInput.focus();
        }

        // Remove a technology
        function removeTech(tech) {
            selectedTechs = selectedTechs.filter(t => t !== tech);
            updateTechUI();
        }

        // Update the UI and the hidden input
        function updateTechUI() {
            selectedContainer.innerHTML = '';

            selectedTechs.forEach(tech => {
                const span = document.createElement('span');
                span.className = 'tech-tag';
                span.innerHTML = `${tech} <i class="fas fa-times" onclick="removeTech('${tech}')"></i>`;
                selectedContainer.appendChild(span);
            });

            hiddenInput.value = selectedTechs.join(', ');
        }

        // Close suggestions if clicking elsewhere
        document.addEventListener('click', function (e) {
            if (!document.querySelector('.tech-stack-wrapper').contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    </script>
</body>

</html>