<?php
$education_jobs = [
    ["Teacher", "Bachelor of Education (B.Ed)", "Full-time (40 hrs/week)", 6],
    ["Lecturer", "Master’s in Education or related field", "Full-time (40 hrs/week)", 3],
    ["School Administrator", "Degree in Education Management", "Full-time (38 hrs/week)", 2],
    ["Guidance Counselor", "Diploma or Degree in Counseling", "Part-time (30 hrs/week)", 2]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Education Job Listings</title>
<style>
    body {
        font-family: "Segoe UI", Arial;
        background: #fff5f5;
        margin: 0;
        padding: 30px;
    }

    h1 {
        text-align: center;
        color: #c62828;
        margin-bottom: 30px;
    }

    /* Use grid layout to fill space uniformly */
    .job-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        justify-items: center;
        align-items: stretch;
    }

    .job-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        width: 100%;
        max-width: 320px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    .profession {
        font-size: 1.3em;
        font-weight: bold;
        color: #e53935;
        margin-bottom: 10px;
    }

    .detail {
        margin: 5px 0;
        color: #333;
        flex-grow: 1;
    }

    .vacancies {
        color: #c62828;
        font-weight: bold;
    }

    .apply-btn {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 18px;
        background: #e53935;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        text-align: center;
        transition: background 0.3s, transform 0.2s;
    }

    .apply-btn:hover {
        background: #c62828;
        transform: scale(1.05);
    }
</style>
</head>
<body>
<h1>📚 Education Job Openings</h1>

<div class="job-container">
    <?php foreach ($education_jobs as $job): ?>
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
