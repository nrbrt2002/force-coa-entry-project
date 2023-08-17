<?php include("includes/header.php")?>

<h1 class="h2">Report</h1>
        <!-- <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div> -->
      </div>

      <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->

      <h2>Make your Choice</h2>
      <form>
  <div class="row">
    <form action="" method="get">
    <div class="col">
    <select name="period" class="form-control md-2" id="" required>
                            <option value="">--SELECT A PERIOD --</option>
                            <?php
            
                                $select_query = mysqli_query($connection, "SELECT * FROM budget ORDER BY month_year DESC");
                                    while($row = mysqli_fetch_array($select_query)){
                                        $id = $row['id'];
                                        $month_year = $row['month_year'];
                                        $budget = $row['budget'];
                                        // $_SESSION['choosen_period_balance'] = $budget;
                                        // $_SESSION['month_year'] = $month_year;
                                    ?>
                            <option value="<?php echo $id?>"><?php echo $month_year?></option>
                            <?php   }  ?>
                        </select>
    </div>
    
    <div class="col">
      <input type="submit" class="btn btn-primary" placeholder="Last name">
    </div>
    </form>
  </div>
</form><hr>
        <?php

        if(isset($_GET['period'])){
            $period = $_GET['period'];
            $select_query = mysqli_query($connection, "SELECT * FROM budget WHERE id = $period");
            $row = mysqli_fetch_array($select_query);
                $id = $row['id'];
                $month_year = $row['month_year'];
                $budget = $row['budget'];

        
        ?>
        <button id="printButton" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
</svg>Print</button>
        <h2 class="text-center">Expence Report of <?php echo $month_year; ?></h2><br>
            <?php
                $total_spent = 0;
                $final_query = mysqli_query($connection, " SELECT * FROM budget JOIN transaction ON DATE_FORMAT(date, '%Y-%m') = '$month_year' JOIN account ON transaction.payment_by = account.id JOIN subcategory ON transaction.sub_category_id = subcategory.id JOIN category ON category.id = subcategory.main_category WHERE budget.month_year = '$month_year';");
                while($final = mysqli_fetch_array($final_query)){
                    $id = $final['id'];
                    $month_year = $final['month_year'];
                    $budget = $final['budget'];
                    $name = $final['name'];
                    $type = $final['type'];
                    $date = $final['date'];
                    $account_name = $final['account_name'];
                    $total_paid = $final['total_paid'];
                    $description = $final['description'];
                    $sub_category_name = $final['sub_category_name'];
                    $category_name = $final['category_name'];
                ?>

                    <div id="contentToPrint" class="text-left">
                        <?php if($type =='in'){ 
                            
                            $total_spent += $total_paid; 

                            ?>

                        
                        <h5><?php echo $name; ?></h5>
                        Transaction: <span class="badge bg-primary"><?php echo $type; ?></span>
                        on <?php echo $date; ?>,
                        Paid: <span class="badge bg-primary"><?php echo $total_paid; ?>Frw</span> 
                        On: <span class="badge bg-primary"><?php echo $sub_category_name; ?>Frw</span> 
                        Of: <span class="badge bg-primary"><?php echo $category_name; ?>Frw</span> 
                        Using: <span class="badge bg-primary"><?php echo $account_name; ?>Frw</span> Account <br>
                        <p><b>Descriptions:</b> <?php echo $description; ?></p>

                    <?php }else if($type =='out'){ 
                        $total_spent -= $total_paid; 

                        ?>

                        <h5><?php echo $name; ?></h5>
                        Transaction: <span class="badge bg-danger"><?php echo $type; ?></span>
                        on <?php echo $date; ?>,
                        Paid: <span class="badge bg-danger"><?php echo $total_paid; ?>Frw</span> 
                        On: <span class="badge bg-danger"><?php echo $sub_category_name; ?>Frw</span> 
                        Of: <span class="badge bg-danger"><?php echo $category_name; ?>Frw</span> 
                        Using: <span class="badge bg-danger"><?php echo $account_name; ?>Frw</span> Account <br>
                        <p><b>Descriptions:</b> <?php echo $description; ?></p>

                    <?php } ?>
                    </div>
                    <hr>
                <?php }    ?>
                <h1 class="h1">Total Spent: <span class="badge bg-warning "><?php echo $total_spent; ?>Frw</span></h1>
      <?php } ?>
    </main>
  </div>
</div>
<script>
    const printButton = document.getElementById("printButton");
const contentToPrint = document.getElementById("contentToPrint");

printButton.addEventListener("click", () => {
    // Hide other content that you don't want to print (if needed)
    // ...

    // Print the specific content
    window.print();

    // Show the hidden content again (if needed)
    // ...
});

</script>
<?php include"includes/footer.php"; ?>