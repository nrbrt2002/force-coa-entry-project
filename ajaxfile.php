<?php
include "dbcon.php";
 
$id = $_POST['id'];
 
$sql = "SELECT * FROM category where id=".$id;
$result = mysqli_query($conn,$sql);
while( $row = mysqli_fetch_array($result) ){
?>
<p><?php echo $row['category_name']?></p>
 
<?php } ?>