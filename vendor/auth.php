<?php
   require '../bin/config.php';
   header('Access-Control-Allow-Origin: *');
   
   session_start();
   
    $number = $_SESSION['num'];
    
    
    
    if($_POST['id'] !="" && $number != "") {
        function validate($data) {
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        validate($_POST);

        // $num = ($_POST['number']);
        // $session_num = $number;
        // $_first = '39';
        // $num = $_first.$session_num;
        $num = $number;

        $Getid = $_POST['id'];
        $id = substr($Getid, 3);


        $PuntoVendita = "SELECT DISTINCT `idPuntoVendita`, `regione` FROM `puntivendita` WHERE `idPuntoVendita`= '$id' ";
        $excutePVD = mysqli_query($con, $PuntoVendita) or die("Something...is wrong");
            while($row = mysqli_fetch_array($excutePVD)) {
                $_regione = $row['regione'];

                $delete  = "DELETE FROM `user_pv` WHERE `numero` = '$num' AND `status`= '0' AND `id_pv`= '$id'";
                $excDelte = mysqli_query($con, $delete) or die("Delteing is impossible... try again..");

                $sql = "INSERT INTO `user_pv` (`numero`,`id_pv`, `time_stamp`, `msgFromPv`, `status`,`regioni`) VALUES('$num', '$id', NULL, 'false', '1', '$_regione') ON DUPLICATE KEY UPDATE `numero`='$num', `id_pv`='$id', `status` = '0' ";
                $exc = mysqli_query($con, $sql) or die("La categorie non e stata inserita...");

            }
       

    /* make true status in $sql */
    /* Work vesion */
                 
        // $sq = "SELECT * FROM `user_pv` WHERE `status` = '0' AND `numero` = '$current_number' ";
        //     $build = mysqli_query($con, $sq);
        //     while($rs = mysqli_fetch_array($build)) {
        //         $numero = $rs['numero'];
                

        //         $delete = "DELETE FROM `user_pv` WHERE `numero` = '$numero' AND `id_pv` = '$id'";
        //         $run = mysqli_query($con, $delete);
        // //         if($run) {
        // //             echo 'Cancellato';
        //         }
        //     }
            


                  
       

    } else {
        die("Per favore controlla numero di telefono o seleziona il puntovendita");
    }

    
   



?>

