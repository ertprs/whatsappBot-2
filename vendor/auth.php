<?php
   
   require '../bin/config.php';
   header('Access-Control-Allow-Origin: *');
    
    if($_POST['id'] !="" && $_POST['number'] != "") {
        function validate($data) {
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        validate($_POST);

        $getNum = ($_POST['number']);
        $fn = '39';
        $num = $fn.$getNum;
        $id = $_POST['id'];
        
            $sql = "INSERT INTO `user_pv` (`numero`,`id_pv`, `time_stamp`, `msgFromPv`, `status`) VALUES('$num', '$id', NULL, 'true', '1') ON DUPLICATE KEY UPDATE `numero`='$num', `id_pv`='$id', `msgFromPv`='false', `status`= '0'";
            $exc = mysqli_query($con, $sql);

            $sq = "SELECT * FROM `user_pv` WHERE `status` = '0' ";
            $build = mysqli_query($con, $sq);
            while($rs = mysqli_fetch_array($build)) {
                $numero = $rs['numero'];
                

                $delete = "DELETE FROM `user_pv` WHERE `numero` = '$numero' AND `id_pv` = '$id'";
                $run = mysqli_query($con, $delete);
                if($run) {
                    echo 'Cancellato';
                }
            }

                  
            
            
    } else {
        die("Something is wrong(Number or id it's empty...!");
    }

    
   



?>

