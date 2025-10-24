<?php
session_start();

// Example session data
$_SESSION['username'] = $_SESSION['username'] ?? 'George Tevin';
$_SESSION['role'] = $_SESSION['role'] ?? 'admin'; 

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GeoLink - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
    }

    /* Drawer Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: -250px;
      width: 250px;
      height: 100%;
      background-color: #fff;
      border-right: 1px solid #dee2e6;
      padding-top: 60px;
      transition: left 0.3s ease;
      z-index: 1050;
    }
    .sidebar.show {
      left: 0;
    }

    /* Top Navigation Bar */
    .topbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 65px;
      background-color: #0d6efd;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      z-index: 1100;
    }

    /* Left section (logo + search + nav) */
    .topbar-left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    /* GeoLink brand */
    .brand {
      font-weight: bold;
      font-size: 1.4rem;
      color: #fff;
      text-decoration: none;
    }

    /* Search bar */
    .search-bar {
      position: relative;
    }
    .search-bar input {
      padding: 5px 35px 5px 10px;
      border-radius: 20px;
      border: none;
      width: 200px;
      outline: none;
    }
    .search-bar i {
      position: absolute;
      right: 10px;
      top: 7px;
      color: gray;
    }

    /* Navigation links beside search */
    .nav-links a {
      color: #fff;
      text-decoration: none;
      margin-left: 15px;
      font-size: 0.95rem;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: opacity 0.2s ease;
    }
    .nav-links a:hover {
      opacity: 0.8;
    }

    /* Right-side user links */
    .topbar-right a {
      color: #fff;
      text-decoration: none;
      margin-left: 15px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    /* Hamburger Menu Button */
    .menu-btn {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
      margin-right: 10px;
    }

    /* Welcome Message */
    .welcome-message {
      position: fixed;
      top: 70px;
      left: 20px;
      background: rgba(13, 110, 253, 0.9);
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 1rem;
      z-index: 1000;
      opacity: 1;
      animation: fadeOut 4s ease-in forwards;
    }
    @keyframes fadeOut {
      0%, 70% { opacity: 1; }
      100% { opacity: 0; visibility: hidden; }
    }

    /* Overlay for Drawer */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      z-index: 1040;
    }
    .overlay.show {
      opacity: 1;
      visibility: visible;
    }

    /* Content */
    .content {
      transition: margin-left 0.3s ease;
      padding: 20px;
      margin-top: 90px;
    }
  </style>
</head>
<body>

<!-- Top Navigation Bar -->
<div class="topbar">
  <div class="topbar-left">
    <button class="menu-btn" id="menuToggle"><i class="fas fa-bars"></i></button>
    <a href="#" class="brand">GeoLink</a>

    <!-- Search bar -->
    <div class="search-bar">
      <input type="text" placeholder="Search...">
      <i class="fas fa-search"></i>
    </div>

    <br><br>

    <!-- Navigation links -->
    <div class="nav-links">
      <a href="#"><i class="fas fa-home"></i> Home</a>
      <a href="job.php"><i class="fas fa-briefcase"></i> Jobs</a>
      <a href="#"><i class="fas fa-user-friends"></i> My Network</a>
    </div>
  </div>

  <div class="topbar-right">
    <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
    <?php if ($role === 'admin'): ?>
      <a href="admin_dashboard.php"><i class="fas fa-cog"></i> Admin</a>
    <?php endif; ?>
  </div>
</div>

<!-- Welcome Message -->
<div class="welcome-message" id="welcomeMsg">
  Welcome back, <?php echo htmlspecialchars($username); ?>!
</div>

<!-- Sidebar Drawer -->
<div class="sidebar" id="sidebar">
  <h5 class="text-center mt-3">Navigation</h5>
  <ul class="nav flex-column p-3">
    <li class="nav-item"><a href="#" class="nav-link">🏠 Home</a></li>
    <li class="nav-item"><a href="#" class="nav-link">💼 Jobs</a></li>
    <li class="nav-item"><a href="#" class="nav-link">👥 My Network</a></li>
    <li class="nav-item"><a href="#" class="nav-link">💬 Contact</a></li>
  </ul>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Main Content -->
<div class="content">
  <div id="carouselExampleIndicators" class="carousel slide mt-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner rounded shadow">
      <div class="carousel-item active">
        <img src="https://picsum.photos/1200/400?random=1" class="d-block w-100" alt="Image 1">
      </div>
      <div class="carousel-item">
        <img src="https://picsum.photos/1200/400?random=2" class="d-block w-100" alt="Image 2">
      </div>
      <div class="carousel-item">
        <img src="https://picsum.photos/1200/400?random=3" class="d-block w-100" alt="Image 3">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const menuToggle = document.getElementById('menuToggle');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');

  // Toggle sidebar
  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
  });

  // Close sidebar when clicking overlay
  overlay.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  });

  // Remove welcome message after fade
  setTimeout(() => {
    const msg = document.getElementById('welcomeMsg');
    if (msg) msg.remove();
  }, 4000);
</script>

</body>
</html>
