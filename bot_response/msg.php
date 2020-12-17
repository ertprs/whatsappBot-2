<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");
include '../bin/config.php';



$number = $_POST['numb'];

$sql = "SELECT DISTINCT `numero`, `id_pv` FROM `user_pv` WHERE `msgFromPv` = 'true' AND `numero` = '$number'";
$query = mysqli_query($con, $sql);

while($row = mysqli_fetch_array($query)) {
    $id_pv = $row['id_pv'];

    $fff = "SELECT `idPuntoVendita`, `regione` FROM `puntivendita` WHERE `idPuntoVendita`= '$id_pv' ";
        $act = mysqli_query($con, $fff);
            while($fw = mysqli_fetch_array($act)) {
                $reg = $fw['regione'];

            
            $userSend = "INSERT INTO `user_send` (`id`, `numero`, `regione`, `data_time`) VALUES(NULL, '$number', '$reg', NULL)ON DUPLICATE KEY UPDATE `numero`= '$number'";
            $inject = mysqli_query($con, $userSend);

           if($inject) {
                $prepare = "UPDATE `user_pv` SET `msgFromPv` = 'false' WHERE `id_pv`= '$id_pv' AND `numero` = '$number'";
                $inject = mysqli_query($con,$prepare) or die("Update is not done");

           } 



        
            
        }

}

/* Update status message */
$statusMSG = "UPDATE `usr_msg` SET `status` = '0' WHERE `usr_number` = '$number'";
$excuteMSG = mysqli_query($con, $statusMSG) or die("Attention. Something is wrong...");








?>