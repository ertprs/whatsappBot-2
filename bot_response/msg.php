<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");
include '../bin/config.php';



$number = $_POST['user_number'];


        $sql = "SELECT DISTINCT `id_pv`, `numero`, `regioni` FROM `user_pv` WHERE `msgFromPv` = 'true' AND `numero` = '$number' AND `status` = '2'";
        $query = mysqli_query($con, $sql);        
        $numRows = mysqli_num_rows($query);
       
            if($numRows > 0) {


                while($row = mysqli_fetch_array($query)) {

                    $_regioni = $row['regioni'];
                    $id = $row['id_pv'];

                    $lvl3 = "UPDATE `user_pv` SET `status` = '3', `msgFromPv` = 'false' WHERE `numero` = '$number' AND `id_pv` ='$id'";
                    $exc = mysqli_query($con, $lvl3);

                    if($exc) {
                        
                        $blockCat = "INSERT INTO `user_send` (`id`,`numero`, `regione`, `data_time`) VALUES(NULL, '$number', '$_regioni', NULL) ON DUPLICATE KEY UPDATE `numero`='$number', `regione` = '$_regioni'";
                        $querys = mysqli_query($con, $blockCat) or die("INSERIMENTE non andato a buon fine");
                       

                    }
                }
            }





// $sql = "SELECT DISTINCT `numero`, `id_pv` FROM `user_pv` WHERE `msgFromPv` = 'true' AND `numero` = '$number'";
// $query = mysqli_query($con, $sql);

// while($row = mysqli_fetch_array($query)) {
//     $id_pv = $row['id_pv'];

//     $fff = "SELECT `idPuntoVendita`, `regione` FROM `puntivendita` WHERE `idPuntoVendita`= '$id_pv' ";
//         $act = mysqli_query($con, $fff);
//             while($fw = mysqli_fetch_array($act)) {
//                 $reg = $fw['regione'];

            
//             $userSend = "INSERT INTO `user_send` (`id`, `numero`, `regione`, `data_time`) VALUES(NULL, '$number', '$reg', NULL)ON DUPLICATE KEY UPDATE `numero`= '$number' AND `regione` = '$reg'";
//             $inject = mysqli_query($con, $userSend);

//            if($inject) {
//                 $prepare = "UPDATE `user_pv` SET `msgFromPv` = 'false' WHERE `id_pv`= '$id_pv' AND `numero` = '$number'";
//                 $inject = mysqli_query($con,$prepare) or die("Update is not done");

//            } 



        
            
//         }

// }

// /* Update status message */
// $statusMSG = "UPDATE `usr_msg` SET `status` = '0' WHERE `usr_number` = '$number'";
// $excuteMSG = mysqli_query($con, $statusMSG) or die("Attention. Something is wrong...");








?>