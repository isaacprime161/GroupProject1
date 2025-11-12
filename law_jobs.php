<?php
$law_jobs = [
    ["Legal Advisor", "Bachelor’s in Law (LLB)", "Full-time (40 hrs/week)", 3],
    ["Paralegal", "Diploma in Legal Studies", "Full-time (38 hrs/week)", 2],
    ["Corporate Lawyer", "LLB + Advocate of the High Court", "Full-time (40 hrs/week)", 4],
    ["Human Rights Officer", "LLB + Experience in Advocacy", "Contract (35 hrs/week)", 1],
    ["Legal Researcher", "LLB or Legal Studies Degree", "Part-time (20 hrs/week)", 3]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Law Job Listings</title>
<style>
    body {
        font-family: "Segoe UI", Arial;
        background: #f2f0ea;
        margin: 0;
        padding: 30px;
    }

    h1 {
        text-align: center;
        color: #5c3d00;
        margin-bottom: 25px;
    }

    .job-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }

    .job-card {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        width: 240px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        position: relative;
    }

    .job-card:hover {
        transform: translateY(-4px);
    }

    .job-type {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        color: #fff;
        font-size: 0.8em;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .full-time { background: #8b5e00; }
    .part-time { background: #ff9800; }
    .contract { background: #3f51b5; }
    .internship { background: #2196f3; }

    .profession {
        font-size: 1.1em;
        font-weight: bold;
        color: #8b5e00;
        margin-bottom: 6px;
    }

    .detail {
        margin: 4px 0;
        color: #333;
        font-size: 0.9em;
    }

    .vacancies {
        color: #006600;
        font-weight: bold;
    }

    .apply-btn {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 14px;
        background: #8b5e00;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 500;
        transition: background 0.3s, transform 0.2s;
        font-size: 0.9em;
    }

    .apply-btn:hover {
        background: #6e4800;
        transform: scale(1.05);
    }

    @media screen and (max-width: 900px) {
        .job-card {
            width: 100%;
        }
    }
</style>
</head>
<body>
<h1>⚖️ Law Job Openings</h1>

<div class="job-container">
    <?php foreach ($law_jobs as $job): ?>
        <?php
            // Detect job type
            $type = '';
            $type_class = '';
            if (stripos($job[2], 'Full-time') !== false) {
                $type = 'Full-time';
                $type_class = 'full-time';
            } elseif (stripos($job[2], 'Part-time') !== false) {
                $type = 'Part-time';
                $type_class = 'part-time';
            } elseif (stripos($job[2], 'Contract') !== false) {
                $type = 'Contract';
                $type_class = 'contract';
            } elseif (stripos($job[2], 'Internship') !== false) {
                $type = 'Internship';
                $type_class = 'internship';
            }
        ?>
        <div class="job-card">
            <div class="job-type <?= $type_class ?>"><?= htmlspecialchars($type) ?></div>
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
