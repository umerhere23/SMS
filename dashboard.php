<?php
 session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>School Management Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">School Logo</a>
      <form class="d-flex mx-auto" role="search">
        <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
      </form>
      <div>
        <i class="bi bi-bell mx-3 text-white"></i>
        <i class="bi bi-person-circle mx-3 text-white"></i>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
       <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <i class="bi bi-house-door"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="classmgt.html">
                <i class="bi bi-building"></i> Class Management
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-people"></i> Student Management
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-currency-dollar"></i> Fee Management
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-bar-graph"></i> Payment Records
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-graph-up"></i> Analytics & Reports
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="bi bi-gear"></i> Settings
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./Backend/logout.php">
                <i class="bi bi-gear"></i> Logout
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Dashboard Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>

        <!-- Overview Cards -->
        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm">
              <div class="card-body">
                <h5><i class="bi bi-people-fill"></i> Total Students</h5>
                <p class="card-text display-4">1200</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow-sm">
              <div class="card-body">
                <h5><i class="bi bi-building"></i> Total Classes</h5>
                <p class="card-text display-4">30</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white shadow-sm">
              <div class="card-body">
                <h5><i class="bi bi-wallet2"></i> Monthly Collection</h5>
                <p class="card-text display-4">$5000</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white shadow-sm">
              <div class="card-body">
                <h5><i class="bi bi-exclamation-triangle"></i> Outstanding Fees</h5>
                <p class="card-text display-4">$1000</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts Section -->
<!-- Charts Section -->
<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card shadow-sm chart-card">
      <div class="card-body">
        <h5 class="card-title">Monthly Collection Trend</h5>
        <canvas id="collectionChart"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card shadow-sm chart-card">
      <div class="card-body">
        <h5 class="card-title">Outstanding Fees by Class</h5>
        <canvas id="outstandingChart"></canvas>
      </div>
    </div>
  </div>
</div>


      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Collection Trend Chart
    const ctxCollection = document.getElementById('collectionChart').getContext('2d');
    const collectionChart = new Chart(ctxCollection, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
          label: 'Monthly Collection ($)',
          data: [5000, 7000, 8000, 7500, 8500, 9000],
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          fill: true
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      }
    });

     const ctxOutstanding = document.getElementById('outstandingChart').getContext('2d');
    const outstandingChart = new Chart(ctxOutstanding, {
      type: 'doughnut',
      data: {
        labels: ['Class A', 'Class B', 'Class C', 'Class D'],
        datasets: [{
          label: 'Outstanding Fees ($)',
          data: [2000, 1500, 1000, 500],
          backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)'
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      }
    });
  </script>
</body>
</html>
