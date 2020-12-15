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

        $fff = "SELECT DISTINCT `idPuntoVendita`, `regione` FROM `puntivendita` WHERE `idPuntoVendita`= '$id' ";
        $act = mysqli_query($con, $fff);
            while($fw = mysqli_fetch_array($act)) {
                $reg = $fw['regione'];

            $message = "INSERT INTO `usr_msg` (`id`,`regions`,`usr_number`, `status`) VALUES(NULL,'$reg', '$current_number', '1') ON DUPLICATE KEY UPDATE  `regions` = '$reg', `status` = '1' ";
            $update = mysqli_query($con, $message) or die("Oops... something wrong!!!");
                
            // $message = "INSERT INTO `user_msg` (`id`, `regions`,`usr_number`, `status`) SELECT(NULL, `regione`, '$current_number', '1' FROM `puntovendita` WHERE `idPuntovendita` = '$id')";
            // print_r($message);
            // $update = mysqli_query($con, $message) or die ("Query error.....");
       }
    }

}




?>