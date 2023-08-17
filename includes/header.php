<?php
// error_reporting(0);

$connection = mysqli_connect('localhost', 'root', '', 'Force COA');
ini_set('session.gc_maxlifetime', 1800);
session_start();
if(!$_SESSION['name']){
    header("Location: login.php");
}

$select_balance_query = mysqli_query($connection, "SELECT * FROM budget WHERE month_year = DATE_FORMAT(NOW(), '%Y-%m')");
$budget = mysqli_fetch_array($select_balance_query);
if($budget == null){
  $balance = 0;
}else{
  $balance = $budget['budget'];
}
$_SESSION['balance'] = $balance;
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
    <link href="assets/css/style.css" rel="stylesheet">

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
Balance: <?php echo $_SESSION['balance']; ?>Frw
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
          </li>
           <li class="nav-item">
            <a class="nav-link" href="accounts.php">
              <span data-feather="credit-card"></span>
              Accounts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="transaction.php">
              <span data-feather="bar-chart-2"></span>
              Transactions 
            </a>
          </li>
          <!--<li class="nav-item">
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
          <span>Generate reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="report.php">
              <span data-feather="file-text"></span>
              Generate
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

        $balance_query = mysqli_query($connection, "SELECT * FROM budget WHERE month_year = DATE_FORMAT(NOW(), '%Y-%m')");
        $row = mysqli_fetch_array($balance_query);

        if($row == null){
          $the_budget = $_POST['budget'];
          $insert_balance_query = mysqli_query($connection, "INSERT INTO budget VALUES('', DATE_FORMAT(NOW(), '%m-%Y'), $the_budget)");

          if($insert_balance_query){
            echo"<script>
            setTimeout(function() {
            window.location.href = 'index.php';
            }, 1000);
            </script>";
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Budget Added Successfuly
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
    <?php }else{ ?>

    <?php 
        $id = $row['id'];
        $new_budget = $row['budget'] + $_POST['budget'];
        $update_balance_query = mysqli_query($connection, "UPDATE budget SET budget = $new_budget where month_year = DATE_FORMAT(NOW(), '%m-%Y')");

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
      }
    }
    ?>
<?php
$date = date('Y-m-d');
$theFirstday = date("d");
$monthName = date('F', strtotime($date));
if ($theFirstday == 1 && $_SESSION['balance'] == 0) {
?>
<div class="popup-overlay">
        <div class="popup-content">
           <h1>Add <?php   echo $monthName; ?> Budget</h1>
           <hr>

           <?php
            if (isset($_POST['add-budget'])) {
              $new_budget = $_POST['new-budget'];
              $add_budget_query = mysqli_query($connection, "INSERT INTO budget VALUES('', DATE_FORMAT(NOW(), '%Y-%m'), $new_budget)");
              if($add_budget_query){
                echo"<script>
                setTimeout(function() {
                window.location.href = 'index.php';
                }, 1000);
                </script>";
            }
           }
           ?>

           <form action="" method="post">
            <div class=" mb-3">
                  <label>Amount:</label>
                  <input type="number" name="new-budget" class="form-control" placeholder="10000000" required><br>
                  <input type="submit" name="add-budget" class="btn btn-primary" value="Update">

              </div>
           </form>
            <!-- <button id="close-popup">Close</button> -->
        </div>
    </div>

<?php }else if($_SESSION['balance'] <= 0){
  ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
</svg> Your Balance is less than 0 try to not spend much</h5>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

  <?php } ?>