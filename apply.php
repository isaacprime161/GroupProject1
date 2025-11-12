<?php
// Get the job name from the link (e.g., ?job=Doctor)
$job_title = isset($_GET['job']) ? htmlspecialchars($_GET['job']) : "Job Application";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Apply for <?= $job_title ?></title>
<style>
    body {
        font-family: "Segoe UI", Arial;
        background: #f4f7f8;
        margin: 0;
        padding: 40px;
    }

    .form-container {
        background: #fff;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #00796b;
        margin-bottom: 25px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="number"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1em;
        transition: border-color 0.2s;
    }

    input:focus, select:focus {
        border-color: #009688;
        outline: none;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    button {
        flex: 1;
        padding: 10px;
        font-size: 1em;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.3s, transform 0.2s;
    }

    .submit-btn {
        background-color: #009688;
        color: white;
    }

    .submit-btn:hover {
        background-color: #00796b;
        transform: scale(1.05);
    }

    .clear-btn {
        background-color: #ccc;
        color: black;
    }

    .clear-btn:hover {
        background-color: #aaa;
        transform: scale(1.05);
    }
</style>
</head>
<body>

<div class="form-container">
    <h2>Apply for <?= $job_title ?></h2>

    <form action="submit_application.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="job_title" value="<?= $job_title ?>">

        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" placeholder="Enter your age" min="18" required>
        <label for="email"  >Email:</label>
        <input type="text" id="email" name="email" placeholder="Enter your email address" required>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">-- Select Gender --</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
           
        </select>

        <label for="cv">Upload CV:</label>
        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>

        <div class="button-group">
            <button type="submit" class="submit-btn">Submit</button>
            <button type="reset" class="clear-btn">Clear</button>
        </div>
    </form>
</div>

</body>
</html>
