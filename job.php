<?php
// job.php — Profession Explorer Page


$professions = [
    ["name" => "Architecture", "image" => "https://images.unsplash.com/photo-1503387762-592deb58ef4e"],
    ["name" => "Engineering", "image" => "https://images.unsplash.com/photo-1504384308090-c894fdcc538d"],
    ["name" => "Medicine", "image" => "https://images.unsplash.com/photo-1576091160550-2173dba999ef"],
    ["name" => "Law", "image" => "https://images.unsplash.com/photo-1589395595558-3f4e6c8f63f7"],
    ["name" => "Education", "image" => "https://images.unsplash.com/photo-1523050854058-8df90110c9f1"],
    ["name" => "Information Technology", "image" => "https://images.unsplash.com/photo-1519389950473-47ba0277781c"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1b263b;
            padding: 10px 20px;
            color: white;
        }

        .navbar h1 {
            margin: 0;
            font-size: 22px;
        }

        .search-bar input {
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            outline: none;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 40px;
            justify-items: center;
        }

        .card {
            position: relative;
            width: 100%;
            max-width: 600px;
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.03);
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
            padding: 10px 20px;
            border-radius: 8px;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
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

    <div class="navbar">
        <h1>Jobs</h1>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search for a profession..." onkeyup="searchProfession()">
        </div>
    </div>

    <div class="card-container">
        <?php foreach ($professions as $profession): ?>
            <div class="card">
                <img src="<?= $profession['image'] ?>" alt="<?= $profession['name'] ?>">
                <h2><?= $profession['name'] ?></h2>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
