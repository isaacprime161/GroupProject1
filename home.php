<?php
session_start();
require_once 'db_connection.php'; // DB connection file

// Redirect to login if session not set
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$database = new Database();
$pdo = $database->connect();

// Fetch user's first name from DB using email in session
$email = $_SESSION['email'];
$sql = "SELECT firstname FROM users WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle case where no record found
$firstname = $user ? htmlspecialchars($user['firstname']) : "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GeoLink Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 0;
    }
    /* Navbar Styling */
    .navbar {
      background-color: #0a66c2;
      padding: 12px 0;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
      color: #fff !important;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
      font-weight: 500;
      margin-right: 20px;
    }
    .navbar-nav .nav-link:hover {
      text-decoration: underline;
    }
    .navbar-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .navbar-right a {
      color: #fff;
      font-weight: 500;
      text-decoration: none;
    }
    .navbar-right a:hover {
      text-decoration: underline;
    }
     /* Job Search Bar */
    .job-search {
      margin-top: -30px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    /* Hero Section */
    .hero-section {
      background: linear-gradient(to right, #0a66c2, #004182);
      color: white;
      text-align: center;
      padding: 80px 0;
    }
    .card {
      border: none;
      border-radius: 15px;
    }
    .card:hover {
      transform: translateY(-5px);
      transition: 0.3s;
    }
  </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">GeoLink</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="job.php"><i class="fas fa-briefcase"></i> Jobs</a></li>
        <li class="nav-item"><a class="nav-link" href="network.php"><i class="fas fa-users"></i> My Network</a></li>
      </ul>

      <div class="navbar-right">
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="adminlogin.php"><i class="fas fa-user-shield"></i> Admin</a>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <h1 class="fw-bold">Welcome back, <?= $firstname ?> !</h1>
    <p class="lead">Find your next career opportunity today.</p>
  </div>
</section>

<!-- Job Search Bar -->
<div class="job-search">
  <form class="d-flex flex-wrap justify-content-center gap-2">
    <input type="text" class="form-control" placeholder="Job title or keyword" style="max-width:300px;">
    <input type="text" class="form-control" placeholder="Location" style="max-width:200px;">
    <select class="form-select" style="max-width:200px;">
      <option selected>Category</option>
      <option>IT & Software</option>
      <option>Marketing</option>
      <option>Education</option>
      <option>Engineering</option>
    </select>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
  </form>
</div>

<!-- Featured Jobs -->
<div class="container mt-5">
  <h3 class="mb-4 text-primary"><i class="fas fa-briefcase"></i> Featured Jobs</h3>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Software Developer</h5>
          <p class="card-text text-muted">TechLink Ltd · Nairobi, Kenya</p>
          <p><span class="badge bg-success">Full-Time</span></p>
          <a href="jobdetails.php?id=1" class="btn btn-primary w-100">View Job</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Marketing Assistant</h5>
          <p class="card-text text-muted">BrightFuture Media · Mombasa</p>
          <p><span class="badge bg-warning text-dark">Internship</span></p>
          <a href="jobdetails.php?id=2" class="btn btn-primary w-100">View Job</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Companies Hiring -->
<div class="container mt-5">
  <h3 class="mb-4 text-primary"><i class="fas fa-building"></i> Companies Hiring</h3>
  <div class="d-flex flex-wrap gap-3">
    <div class="card shadow-sm p-3 text-center" style="width: 180px;">
      <img src="images/company1logo.png" alt="Company Logo" class="img-fluid mb-2" style="height:60px;">
      <p class="fw-bold mb-1">Safaritech</p>
      <small class="text-muted">5 Open Positions</small>
    </div>
    <div class="card shadow-sm p-3 text-center" style="width: 180px;">
      <img src="images/company2logo.png" alt="Company Logo" class="img-fluid mb-2" style="height:60px;">
      <p class="fw-bold mb-1">EduLink Africa</p>
      <small class="text-muted">3 Open Positions</small>
    </div>
  </div>
</div>

<!-- Career Resources -->
<div class="container mt-5 mb-5">
  <h3 class="mb-4 text-primary"><i class="fas fa-book-open"></i> Career Resources</h3>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">How to Write a Strong CV</h5>
          <p class="card-text text-muted">Tips on crafting a compelling and ATS-friendly resume.</p>
          <a href="#" class="text-decoration-none">Read More →</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Interview Preparation</h5>
          <p class="card-text text-muted">Key steps to prepare for common interview questions.</p>
          <a href="#" class="text-decoration-none">Read More →</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
