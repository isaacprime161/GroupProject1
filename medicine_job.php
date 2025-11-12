<?php
$medicine_jobs = [
    ["Doctor", "Bachelor of Medicine and Surgery (MBChB)", "Full-time (40 hrs/week)", 5],
    ["Nurse", "Diploma or Degree in Nursing", "Full-time (38 hrs/week)", 6],
    ["Pharmacist", "Bachelor’s in Pharmacy", "Full-time (40 hrs/week)", 3],
    ["Laboratory Technician", "Diploma in Medical Lab Technology", "Part-time (30 hrs/week)", 2],
    ["Radiologist", "Degree in Radiology + Certification", "Full-time (40 hrs/week)", 1]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medical Job Listings</title>
<style>
    body {
        font-family: "Segoe UI", Arial;
        background: #f3f9f9;
        margin: 0;
        padding: 30px;
    }

    h1 {
        text-align: center;
        color: #00796b;
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
        color: #009688;
        margin-bottom: 10px;
    }

    .detail {
        margin: 5px 0;
        color: #333;
    }

    .vacancies {
        color: #008000;
        font-weight: bold;
    }

    .apply-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 18px;
        background: #009688;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.3s, transform 0.2s;
    }

    .apply-btn:hover {
        background: #00796b;
        transform: scale(1.05);
    }
</style>
</head>
<body>
<h1>🏥 Medical Job Openings</h1>

<div class="job-container">
    <?php foreach ($medicine_jobs as $job): ?>
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
