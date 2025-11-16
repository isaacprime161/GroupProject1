<?php
// job.php — Profession Explorer Page


$professions = [
    [
        "name" => "Architecture",
        "image" => "https://images.unsplash.com/photo-1503387762-592deb58ef4e",
        "link" => "architecture.php"
    ],
    [
        "name" => "Engineering",
        "image" => "https://images.unsplash.com/photo-1504384308090-c894fdcc538d",
        "link" => "engineering_jobs.php"
    ],
    [
        "name" => "Medicine",
        "image" => "https://images.unsplash.com/photo-1576091160550-2173dba999ef",
        "link" => "medicine_job.php"
    ],
    [
        "name" => "Law",
        "image" => "assets/law.jpg",
        "link" => "law_jobs.php"
    ],
    [
        "name" => "Education",
        "image" => "assets/education.jpg",
        "link" => "education.php"
    ],
    [
        "name" => "Information Technology",
        "image" => "https://images.unsplash.com/photo-1519389950473-47ba0277781c",
        "link" => "IT.php"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3524/3524659.png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            display: flex;
            color: #1e293b;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 220px;
            background-color: #2563eb;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin: 20px 0;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            padding: 0 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 12px 10px;
            border-radius: 8px;
            margin: 5px 0;
            transition: background 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #1d4ed8;
        }

        .bottom-link {
            text-align: center;
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bottom-link a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s ease;
        }

        .bottom-link a:hover {
            opacity: 0.85;
        }

        .bottom-link img {
            width: 20px;
            height: 20px;
            filter: invert(100%);
        }

        /* Main content */
        .main-content {
            flex: 1;
            margin-left: 220px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 14px 24px;
            color: #1e293b;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
        }

        .search-bar input {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #dbeafe;
            outline: none;
            transition: box-shadow 0.3s ease, border 0.3s ease;
        }

        .search-bar input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 6px rgba(37, 99, 235, 0.4);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            padding: 40px;
            justify-items: center;
        }

        .card {
            position: relative;
            width: 100%;
            max-width: 600px;
            height: 260px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: white;
            text-decoration: none;
            color: white;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.25);
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(70%);
        }

        .card h2 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            text-align: center;
            background: rgba(0, 0, 0, 0.4);
            padding: 12px 24px;
            border-radius: 8px;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .card-container {
                grid-template-columns: 1fr;
                padding: 20px;
            }

            .card {
                max-width: 90%;
            }
        }
    </style>

    <script>
        function searchProfession() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const cards = document.getElementsByClassName("card");

            for (let i = 0; i < cards.length; i++) {
                const title = cards[i].querySelector("h2").innerText.toLowerCase();
                cards[i].style.display = title.includes(input) ? "block" : "none";
            }
        }
    </script>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div>
            <h2>Geolink</h2>
            <div class="nav-links">
                <a href="home.php">🏠 Home</a>
                <a href="network.php">🌐 My Network</a>
            </div>
        </div>
        <div class="bottom-link">
            <a href="adminlogin.php">
                <img src="https://cdn-icons-png.flaticon.com/512/3524/3524659.png" alt="Admin">
                Admin Panel
            </a>
        </div>
    </div>

    <!-- Main Page Content -->
    <div class="main-content">
        <div class="navbar">
            <h1>Jobs</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for a profession..." onkeyup="searchProfession()">
            </div>
        </div>

        <div class="card-container">
            <?php foreach ($professions as $profession): ?>
                <a href="<?= $profession['link'] ?>" class="card">
                    <img src="<?= $profession['image'] ?>" alt="<?= $profession['name'] ?>">
                    <h2><?= $profession['name'] ?></h2>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
