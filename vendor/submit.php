<?php 

require '../bin/config.php';
header('Access-Control-Allow-Origin: *');

$current_number = $_POST['number'];

$select = "SELECT `id_pv`, `msgFromPv` FROM `user_pv` WHERE `numero` = '$current_number'";
$execute = mysqli_query($con,$select);
    while($row = mysqli_fetch_assoc($execute)) {
       $id = $row['id_pv'];

       $update = "UPDATE `user_pv` SET `msgFromPv` = 'true' WHERE `numero` = '$current_number' AND `id_pv` = '$id' ";
       $action = mysqli_query($con, $update) or die("Updayting is failed..");

       if($action) {
           echo 'Tutto ok';
       }
    }





?>