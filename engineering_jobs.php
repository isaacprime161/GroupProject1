<?php
$engineering_jobs = [
    ["Civil Engineer", "Bachelor’s in Civil Engineering", "Full-time (40 hrs/week)", 4],
    ["Mechanical Engineer", "Bachelor’s in Mechanical Engineering", "Full-time (40 hrs/week)", 5],
    ["Electrical Engineer", "Bachelor’s in Electrical or Electronics Engineering", "Internship (25 hrs/week)", 3],
    ["Software Engineer", "Bachelor’s in Software or Computer Engineering", "Remote (40 hrs/week)", 7],
    ["Architect", "Bachelor’s in Architecture + Registration", "Full-time (38 hrs/week)", 2],
    ["Project Manager", "Degree in Engineering + PMP Certification", "Full-time (40 hrs/week)", 1],
    ["CAD Technician", "Diploma in Engineering Design or CAD", "Part-time (30 hrs/week)", 3]
];

// Move part-time jobs to the bottom
usort($engineering_jobs, fn($a, $b) => stripos($a[2], 'Part-time') !== false ? 1 : -1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Engineering Job Listings</title>
<style>
    body { font-family: "Segoe UI", Arial; background: #eef4f2; margin: 0; padding: 30px; }
    h1 { text-align: center; color: #006d3c; margin-bottom: 25px; }
    .job-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; }

    .job-card {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        width: 240px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .job-card:hover { transform: translateY(-4px); }

    .profession {
        font-size: 1.1em;
        font-weight: bold;
        color: #009950;
        margin-bottom: 6px;
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

    .full-time { background: #009950; }
    .part-time { background: #ff9800; }
    .internship { background: #2196f3; }
    .remote { background: #6c757d; }

    .detail { margin: 4px 0; color: #333; font-size: 0.9em; }
    .vacancies { color: #006400; font-weight: bold; }

    .apply-btn {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 14px;
        background: #009950;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 500;
        transition: background 0.3s, transform 0.2s;
        font-size: 0.9em;
    }
    .apply-btn:hover { background: #007a3d; transform: scale(1.05); }
</style>
</head>
<body>
<h1>⚙️ Engineering Job Openings</h1>

<div class="job-container">
<?php foreach ($engineering_jobs as $job): 
    $type = match (true) {
        stripos($job[2], 'Full-time') !== false => 'full-time',
        stripos($job[2], 'Part-time') !== false => 'part-time',
        stripos($job[2], 'Internship') !== false => 'internship',
        stripos($job[2], 'Remote') !== false => 'remote',
        default => ''
    };
?>
    <div class="job-card">
        <div class="profession"><?= htmlspecialchars($job[0]); ?></div>
        <span class="job-type <?= $type; ?>"><?= ucfirst(str_replace('-', ' ', $type)); ?></span>
        <div class="detail"><?= htmlspecialchars($job[1]); ?></div>
        <div class="detail"><?= htmlspecialchars($job[2]); ?></div>
        <div class="detail vacancies">Vacancies: <?= htmlspecialchars($job[3]); ?></div>
        <a href="apply_form.php" class="apply-btn">Apply</a>
    </div>
<?php endforeach; ?>
</div>
</body>
</html>
