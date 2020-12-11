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

           

            $message = "INSERT INTO `usr_msg` (`id`,`regions`,`usr_number`, `status`) VALUES(NULL,'$reg', '$num', '1') ON DUPLICATE KEY UPDATE  `regions` = '$reg' ";
            $update = mysqli_query($con, $message) or die("Oops... something wrong!!!");

            /* Controll if regione exsist in user_send table */
            $select = "SELECT DISTINCT `regione`, `numero`, `data_time` FROM `user_send` WHERE `regione` = '$reg' AND `numero` = '$num'";
            $execute = mysqli_query($con, $select);
            
            /* DATA update. if data != current DELETE  */
            $today = date("Y-m-d");
            $todayLong = date("Y-m-d H:i:s");
            $dbTime = substr($pv_time, 0, 10);
           
                while($lines = mysqli_fetch_array($execute)) {
                    $regLine = $lines['regione'];
                    

                    if($dbTime == $today) {
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
                    } else {
                        $delete = "DELETE FROM `user_send` WHERE `numero` = '$num'";
                        $confirm = mysqli_query($con, $delete);
                        if($confirm) {
                            $updateData = "UPDATE `user_pv` SET `time_stamp` = '$todayLong' WHERE `numero` = '$num'";
                            $confUpdate = mysqli_query($con, $updateData);
                        }
                    }


                }

                 
            
             
        }       
         
 }

 $todayLong = date("Y-m-d H:i:s");

// echo '<pre>';
//     print_r($todayLong);
// echo '</pre>';






/* Send message where message status is true */

    $sql = "SELECT DISTINCT `numero`, `msgFromPv` FROM `user_pv` WHERE `numero` !='' AND `msgFromPv` = 'true'";
    $query = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($query)) {
        
        $msgFromPv = $row['msgFromPv'];
        $num = $row['numero'];

       

         if($msgFromPv) {
            
            /* Befoure send messgae preapre our link in base of region selected from user */
            

            /* TEST */
            $getMessage = "SELECT  `regions` FROM `usr_msg` WHERE `usr_number` = '$num' AND `status` = '1' ";
            $getEXE = mysqli_query($con, $getMessage) or die("Query is failed...");
            while($items = mysqli_fetch_array($getEXE)) {
                $_region = $items['regions'];
                
                
               
                if(($_region == 'Sisa Campania') && ($_region == 'Sisa Puglia') && ($_region == 'Negozio Italia')) {
                    
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nSisa Puglia:\n https://preview1.volantinopiu.it//volantino326100-Sisa.html\n\nSisa Campania:\nhttps://preview1.volantinopiu.it//volantino237100-SisaCampania_Marca2020.html \n\nNegozio Italia:\nhttps://preview1.volantinopiu.it//promo32610202003-ma.html";
                }
                if(!empty($_region == 'Sisa Campania') && !empty($_region == 'Sisa Puglia')) {
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.phpn=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nSisa Puglia:\n https://preview1.volantinopiu.it//volantino326100-Sisa.html\n\nSisa Campania:\nhttps://preview1.volantinopiu.it//volantino237100-SisaCampania_Marca2020.html";
                        
                } 
                if(!empty($_region == 'Sisa Campania') && !empty($_region == 'Negozio Italia')) {
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nNegozio Italia:\n https://preview1.volantinopiu.it//promo32610202003-ma.html\n\nSisa Campania:\nhttps://preview1.volantinopiu.it//volantino237100-SisaCampania_Marca2020.html";
                } 
                 if(!empty($_region == 'Sisa Puglia') && !empty($_region == 'Negozio Italia')) {
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nSisa Puglia:\n https://preview1.volantinopiu.it//volantino326100-Sisa.html\n\nSisa Negozio Italia:\nhttps://preview1.volantinopiu.it//promo32610202003-ma.html";
                } 
                 if(!empty($_region == 'Sisa Campania')) {
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nSisa Campania:\nhttps://preview1.volantinopiu.it//volantino237100-SisaCampania_Marca2020.html";
                } 
                if(($_region == 'Sisa Puglia')) {
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nSisa Puglia:\nhttps://preview1.volantinopiu.it//volantino326100-Sisa.html";
                }
                 if(!empty($_region == 'Negozio Italia')) {
                    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/mappa.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\nNegozio Italia :\nhttps://preview1.volantinopiu.it//promo32610202003-ma.html";
                }

               
            }
                $data = array();
                $child = array();

                $child['msg'] = $text;    
                $child['numero'] = $num;

                $data[] = $child;
            
            echo json_encode($data);



                
            } else {
                exit();
            }
          
    }


    /* Support checking.... */

    $controllMsg = "SELECT * FROM `support_register` WHERE `actual_status` ='email' LIMIT 1";
    $sendMsg = mysqli_query($con, $controllMsg);
     $numRows = mysqli_num_rows($sendMsg);
        if($numRows > 0) {
        
                $updateAlert = "UPDATE `support_register` SET `actual_status` = 'message to admin'";
                $prepare = mysqli_query($con, $updateAlert);
                    if($prepare) {
                        while($msg = mysqli_fetch_array($sendMsg)) {
                            $user_number = $msg['number'];
                            $code_report = $msg['code_report'];
                            $actual_status = $msg['actual_status'];
            
                            $text = "Attenzione 🚨\nVerificato il problema🔎:\ncode_report '".$code_report."'\nutente con il numero : '".$user_number."'\nactual_status: '".$actual_status."' ";
                    }
            }
            
            $data = array();
            $child = array();

                $child['msg'] = $text;    
                $child['numero'] = '393278463663';

                $data[] = $child;
            
            echo json_encode($data);
        }



?>
