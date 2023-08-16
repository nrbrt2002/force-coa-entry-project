<?php
$connection = mysqli_connect('localhost', 'root', '', 'Force COA');
session_start();
if(!$_SESSION['name']){
    header("Location: login.php");
}

$select_balance_query = mysqli_query($connection, "SELECT * FROM budget WHERE month_year = DATE_FORMAT(NOW(), '%m-%Y')");
$budget = mysqli_fetch_array($select_balance_query);
$balance = $budget['budget'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Force COA- Evaluation Test</title>
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    

    <!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModalDefault">
Balance: <?php echo $balance; ?>Frw
</button>
  <!-- <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a> -->
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div>
  </div>
  <input class="form-control form-control-dark bg-dark w-100" type="text" aria-label="Search" disabled>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div>
</header>
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="categories.php">
              <span data-feather="list"></span>
              Categories
            </a>
            <!--
          </li>
           <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>-->
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li> -->
        </ul>
      </div>
    </nav>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <?php
      
      if(isset($_POST['update-budget'])){

        $balance_query = mysqli_query($connection, "SELECT * FROM budget WHERE month_year = DATE_FORMAT(NOW(), '%m-%Y')");

        $row = mysqli_fetch_array($balance_query);
        $id = $row['id'];
        $new_budget = $row['budget'] + $_POST['budget'];
        $update_balance_query = mysqli_query($connection, "UPDATE budget SET budget = $new_budget");

        if($update_balance_query){
          echo"<script>
          setTimeout(function() {
          window.location.href = 'index.php';
          }, 1000);
          </script>";
          ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  Budget Updated Successfuly
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
  <?php
        }
        
      }

    ?>



