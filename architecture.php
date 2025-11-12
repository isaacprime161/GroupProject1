<?php
$architecture_jobs = [
    ["Architect", "Bachelor of Architecture (B.Arch)", "Full-time (40 hrs/week)", 4],
    ["Interior Designer", "Diploma or Degree in Interior Design", "Full-time (38 hrs/week)", 3],
    ["Urban Planner", "Degree in Urban and Regional Planning", "Full-time (40 hrs/week)", 2],
    ["Landscape Architect", "Degree in Landscape Architecture", "Part-time (30 hrs/week)", 2]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Architecture Job Listings</title>
<style>
    body {
        font-family: "Segoe UI", Arial;
        background: #f6f3fa;
        margin: 0;
        padding: 30px;
    }

    h1 {
        text-align: center;
        color: #6a1b9a;
        margin-bottom: 30px;
    }

    .job-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .job-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .job-card:hover {
        transform: translateY(-4px);
    }

    .profession {
        font-size: 1.3em;
        font-weight: bold;
        color: #8e24aa;
        margin-bottom: 10px;
    }

    .detail {
        margin: 5px 0;
        color: #333;
    }

    .vacancies {
        color: #6a1b9a;
        font-weight: bold;
    }

    .apply-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 18px;
        background: #8e24aa;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.3s, transform 0.2s;
    }

    .apply-btn:hover {
        background: #6a1b9a;
        transform: scale(1.05);
    }
</style>
</head>
<body>
<h1>🏗️ Architecture Job Openings</h1>

<div class="job-container">
    <?php foreach ($architecture_jobs as $job): ?>
    <div class="job-card">
        <div class="profession"><?= htmlspecialchars($job[0]) ?></div>
        <div class="detail"><strong>Qualification:</strong> <?= htmlspecialchars($job[1]) ?></div>
        <div class="detail"><strong>Work Hours:</strong> <?= htmlspecialchars($job[2]) ?></div>
        <div class="detail vacancies"><strong>Vacancies:</strong> <?= htmlspecialchars($job[3]) ?></div>
        <a href="apply.php?job=<?= urlencode($job[0]) ?>" class="apply-btn">Apply</a>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>
