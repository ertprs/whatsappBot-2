<?php

require '../bin/config.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");




$qqq = "SELECT DISTINCT `id_pv`, `numero`, `time_stamp` FROM `user_pv`";
$action = mysqli_query($con,$qqq);
 while($rw = mysqli_fetch_array($action)) {
    $iDP = $rw['id_pv'];
    $num = $rw['numero'];
    $pv_time = $rw['time_stamp'];
    $fff = "SELECT DISTINCT `idPuntoVendita`, `regione` FROM `puntivendita` WHERE `idPuntoVendita`= '$iDP' ";
    $act = mysqli_query($con, $fff);
        while($fw = mysqli_fetch_array($act)) {
            $reg = $fw['regione'];



            /* Controll if regione exsist in user_send table */
            $select = "SELECT DISTINCT `regione`, `numero`, `data_time` FROM `user_send` WHERE `regione` = '$reg' AND `numero` = '$num'";
            $execute = mysqli_query($con, $select);
            
            /* DATA update. if data != current DELETE  */
            // $today = date("Y-m-d");
            // $todayLong = date("Y-m-d H:i:s");
            // $dbTime = substr($pv_time, 0, 10);
           
                while($lines = mysqli_fetch_array($execute)) {
                    $regLine = $lines['regione'];
                    

                   
                        if($regLine == 'Sisa Campania') {
                            $upgrade = "UPDATE `user_pv` SET `msgFromPv` = 'false' WHERE numero = '$num' AND `id_pv` = '$iDP'";
                            $exc = mysqli_query($con, $upgrade);
                        }else if($regLine == 'Sisa Puglia') {
                            $upgrade = "UPDATE `user_pv` SET `msgFromPv` = 'false' WHERE numero = '$num' AND `id_pv` = '$iDP' ";
                            $exc = mysqli_query($con, $upgrade);
                        }else if($regLine == 'Negozio Italia') {
                            $upgrade = "UPDATE `user_pv` SET `msgFromPv` = 'false' WHERE numero = '$num' AND `id_pv` = '$iDP' ";
                            $exc = mysqli_query($con, $upgrade);
                        }    
                  


                }

                 
            
             
        }       
         
 }

 /* Reset data only 24h */

 $todayLong = date("Y-m-d H:i:s");

 $substrTime = substr($todayLong, 11,5);

 if($substrTime == '00:00' ) {
    // echo 'ecco';
     $truncate = "TRUNCATE TABLE `user_send`";
     $turncateQuery = mysqli_query($con, $truncate) or die("Truncate is failed...");
     
 }







 $child = array();


// /* Send message where message status is true */

    $sql = "SELECT DISTINCT `numero`, `msgFromPv` FROM `user_pv` WHERE `numero` !='' AND `msgFromPv` = 'true'";
    $query = mysqli_query($con, $sql);
    $selectRows = mysqli_num_rows($query);
    if($selectRows > 0) { 
    while($row = mysqli_fetch_array($query)) {
        
        $msgFromPv = $row['msgFromPv'];
        $num = $row['numero'];

       

         if($msgFromPv) {
            
            /* Befoure send messgae preapre our link in base of region selected from user */
            

           
            $getMessage = "SELECT `id`, `regions` FROM `usr_msg` WHERE `usr_number` = '$num' AND `status` = '1' ";
            $getEXE = mysqli_query($con, $getMessage) or die("Query is failed...");
            while($items = mysqli_fetch_array($getEXE)) {
                $_region = $items['regions'];

                $selLinks = "SELECT `volantino` FROM `regioni` WHERE `regione` = '$_region'";
                $getLinks = mysqli_query($con,$selLinks) or die("Cant found links..");
                 while($link = mysqli_fetch_array($getLinks)) {

                     $volantino = $link['volantino'];
                    
                     $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/controller/redirection.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\n$_region:\n$volantino";

                        $child['msg'][] = $text; 
                 }

              
               
            }
               

                   
           


                
            } else {
                exit();
            }

            $child['numero'] = $num;
            echo json_encode($child);


        }
    }


    /* Support checking.... */

    $controllMsg = "SELECT * FROM `support_register` WHERE `actual_status` ='email' LIMIT 1";
    $sendMsg = mysqli_query($con, $controllMsg);
     $numRows = mysqli_num_rows($sendMsg);
     $child = array();
        if($numRows > 0) {
        
                $updateAlert = "UPDATE `support_register` SET `actual_status` = 'message to admin'";
                $prepare = mysqli_query($con, $updateAlert);
                    if($prepare) {
                        while($msg = mysqli_fetch_array($sendMsg)) {
                            $user_number = $msg['number'];
                            $code_report = $msg['code_report'];
                            $actual_status = $msg['actual_status'];
            
                            $text = "Attenzione 🚨\nVerificato il problema🔎:\ncode_report '".$code_report."'\nutente con il numero : '".$user_number."'\nactual_status: '".$actual_status."' ";
                            $child['msg'][] = $text; 
                    }
            }
            
          
                $child['numero'] = '393278463663';

               
            
            echo json_encode($child);
        }



        /* Checking banned user... */
        $controlBan = "SELECT * FROM `banned_user` WHERE `status` = 'bann'";
        $excBan = mysqli_query($con, $controlBan) or die("Not get..");
        $banSQLROWS = mysqli_num_rows($excBan);
        $child = array();
       
        if($banSQLROWS > 0) {
            while($ban = mysqli_fetch_array($excBan)) {
                $number = $ban['user_number'];
                $ip = $ban['ip_address'];
                $data = $ban["time"];
                $child['msg'][] = "Ban List❗\nData: $data\nNumero 📱: $number\nIp_address 🖥️: $ip";
                
            }
                $banUpdate = "UPDATE `banned_user` SET `status` = 'avviso'";
                $excupdateBan = mysqli_query($con, $banUpdate);
                if($excupdateBan) {
                    $child['numero'] = '393278463663';
                    echo json_encode($child);    
                }
    
    
        }

        
        


?>
