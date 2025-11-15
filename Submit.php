<?php
session_start();
$applied_jobs = $_SESSION['Networks'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Networks</title>
<style>
body { font-family: Arial; background:#eef4f2; padding:30px; }
h1 { text-align:center; color:#006d3c; }
.job-card { background:#fff; border-radius:10px; padding:15px; margin:10px auto; width:400px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
strong { color:#007a3d; }
</style>
</head>
<body>

<h1>👥 My Networks</h1>

<?php if (empty($applied_jobs)): ?>
<p style="text-align:center;">You haven’t applied for any jobs yet.</p>
<?php else: ?>
<?php foreach ($applied_jobs as $job): ?>
<div class="job-card">
<strong><?= htmlspecialchars($job['job']) ?></strong><br>
<small>Applicant: <?= htmlspecialchars($job['fullname']) ?> (<?= htmlspecialchars($job['gender']) ?>, <?= htmlspecialchars($job['age']) ?>)</small><br>
<small>Email: <?= htmlspecialchars($job['email']) ?></small><br>
<small>CV: <?= htmlspecialchars($job['cv']) ?></small>
</div>
<?php endforeach; ?>
<?php endif; ?>

<a href="jobs.php" style="display:block;text-align:center;margin-top:30px;color:#6a1b9a;font-weight:bold;">⬅ Back to Jobs</a>

</body>
</html>
