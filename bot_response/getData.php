<?php

include '../bin/config.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");




/* Make case sensetive false */

$userNum = $_POST['num'];

$userMsg = strtolower($_POST['msg']);
$global_ip = $_SERVER['REMOTE_ADDR'];


/* Controller... */

$try = "SELECT `user_number`, `ip_address` FROM `banned_user` WHERE `user_number` = '$userNum'";
$catch = mysqli_query($con, $try) or die("Try another way..");
$control_rows = mysqli_num_rows($catch);
if ($control_rows) {
} else {


    /* Mobile log of everything.. */

    if ($userMsg != '' || $userMsg != 'stop' || $userMsg != 'ok') {
        $getLogFromFetch = "INSERT INTO `mobile_log`(`id`, `numero`, `data_logo`,`action`,`msg`) VALUES (NULL,'$userNum',NULL, 'text','$userMsg')";
        $injectLoginDB = mysqli_query($con, $getLogFromFetch);
    }


    /* Temporary function */
    if ($userMsg == 'reset') {
        $truncate = "TRUNCATE TABLE `user_pv`";
        $exeTruncate = mysqli_query($con, $truncate) or die("Not allowed");
        if ($exeTruncate) {
            $delSMG = "TRUNCATE TABLE `usr_msg`";
            $exeSMG = mysqli_query($con, $delSMG) or die("Some error...");

            if ($exeSMG) {
                $delLast = "TRUNCATE TABLE `user_send`";
                $final = mysqli_query($con, $delLast) or die("Last error...");
                echo "Operation completed";
            }
        }
    }


    /* Support area.. */


    $_pattern = "codice err";
    if (strpos($userMsg, $_pattern) !== false) {

        $support = "SELECT `time_stamp`, `code_report`, `number` FROM `support_register` WHERE `number` = '$userNum' AND `code_report` = '$userMsg'";
        $control = mysqli_query($con, $support);
        $rowsCount = mysqli_num_rows($control);

        $todayLong = date("Y-m-d H:i:s");
        $shortTime = substr($todayLong, 10, 3);

        if ($rowsCount > 0) {

            $updateStatus = "UPDATE `support_register` SET `actual_status` ='crash' WHERE `number`= '$userNum'";
            $getUpdate = mysqli_query($con, $updateStatus) or die("Status was not updayted...");
            if ($shortTime > 14) {
                echo "Buonasera\nChiediamo scusa per il disagio.\nVi contattiamo a breve\nPer avere maggiori informazioni\npreghiamo di contattare noi\nsu questa email: \n\nsupportvolantinopiu@gmail.com\n\nCoridali saluti,\nVolantino support team";
            } else if ($shortTime < 14) {
                echo "Buongiorno\nChiediamo scusa per il disagio.\nVi contattiamo a breve\nPer avere maggiori informazioni\npreghiamo di contattare noi\nsu questa email: \n\nsupportvolantinopiu@gmail.com\n\nCoridali saluti,\nVolantino support team";
            }
        } else {
            $insertSupport = "INSERT INTO `support_register` (`id`, `number`, `code_report`, `actual_status`, `time_stamp`) VALUES(NULL, '$userNum', '$userMsg', 'messaggio', NULL)";
            $querySupport = mysqli_query($con, $insertSupport) or die("Attenzione\nMessaggio non e stato inviato!\nControlla se dati nell messaggio visualizati giusto:\nMessaggio composto dal (Codice err:) e numero (esempio: A663)\n Se campo e vuoto torna alla pagina ed invia messggio di nouvo");
            if ($shortTime > 14) {

                echo "Buonasera\nIl report è stato inviato, vi contatteremo a breve 📧\nIn attesa della risposta vi chiediamo di verificare i seguenti punti:\n1. Connessione internet sia adeguata 🌐\n2. GPS attivo, ed eventualmente riavviare la pagina e consentire la geolocalizzazione 📍\n3. Cambiare browser (Chrome, Mozilla, Opera) 📱\n\nNel caso i punti sopra evidenziati non risolvano il problema si prega di scrivere (stop) e successivamente di nuovo (ok)";
            } else if ($shortTime < 14) {
                echo "Buongiorno\nIl report è stato inviato, vi contatteremo a breve 📧\nIn attesa della risposta vi chiediamo di verificare i seguenti punti:\n1. Connessione internet sia adeguata 🌐\n2. GPS attivo, ed eventualmente riavviare la pagina e consentire la geolocalizzazione 📍\n3. Cambiare browser (Chrome, Mozilla, Opera) 📱\n\nNel caso i punti sopra evidenziati non risolvano il problema si prega di scrivere (stop) e successivamente di nuovo (ok)";
            }
        }
    }





    /* Support area.. */

    // $_pattern = "codice report";
    // if(strpos($userMsg, $_pattern ) !== false ) {
    //     $support = "SELECT `time_stamp`, `code_report`, `number` FROM `support_register` WHERE `number` = '$userNum'";
    //     $control = mysqli_query($con, $support);
    //     $rowsCount = mysqli_num_rows($control);


    //                 if($rowsCount > 0) {

    //                     $updateStatus = "UPDATE `support_register` SET `actual_status` ='email' WHERE `number`= '$userNum'";
    //                     $getUpdate = mysqli_query($con, $updateStatus) or die("Status was not updayted...");
    //                     if($getUpdate) {
    //                         echo "Buonasera\nChiediamo scusa per il disagio.\nVi contattiamo a breve\nPer avere maggiori informazioni\npreghiamo di contattare noi\nsu questa email: \n\nsupportvolantinopiu@gmail.com\n\nCoridali saluti,\nVolantino support team";
    //                     }

    //                 }else {
    //                     $insertSupport = "INSERT INTO `support_register` (`id`, `number`, `code_report`, `actual_status`, `time_stamp`) VALUES(NULL, '$userNum', 'PA', 'messaggio', NULL)";
    //                     $querySupport = mysqli_query($con, $insertSupport) or die("Insert error.. support not passed..");
    //                         if($querySupport) {
    //                             $deleteSup = "DELETE FROM `mobile` WHERE `numero` = '$userNum'";
    //                             $execDelete = mysqli_query($con, $deleteSup) or die("Cant delete from mobile");   
    //                             echo "Buonasera\nReport e stato inviato 📧\nScrivi (ok) per continuare registrazione📀";

    //                         }


    //                 }

    // }



    $todayLong = date("Y-m-d H:i:s");

    $substrTime = substr($todayLong, 11, 5);
    // print_r($substrTime);

    $controller = "SELECT `numero`, `data_logo`, `ip_address` FROM `mobile_log` WHERE `numero` = '$userNum' AND  `data_logo` LIKE '%$substrTime%' ";
    $control = mysqli_query($con, $controller) or die("Can't controll or something is wrong...");
    $time_rows = mysqli_num_rows($control);
    if ($time_rows == 10) {

        $ban = "INSERT INTO `banned_user` (`id`,`user_number`, `ip_address`, `time`, `status`) VALUES (NULL, '$userNum', '$global_ip', NULL, 'bann')";
        $ban_execute = mysqli_query($con, $ban) or die("Ban is not applyied...");
        if ($ban_execute) {
            echo "il tuo account è stato disabilitato  📛\nMotivo:\nSuperato limite delle richieste al minuto\nPer informazione contatta amministrazione:\n\nadmin@volantino.advmail.com";
        }
    } else {






        /* Controll state and command */
        $query = "SELECT  `numero`, `status`, `iconsento`, `data_s` FROM `mobile` WHERE `numero` ='$userNum' ";
        $result = mysqli_query($con, $query);



        while ($row = mysqli_fetch_array($result)) {
            $status = $row['status'];
            $mob = $row['numero'];
            $db_time = $row['data_s'];
            $iconsento = $row['iconsento'];




            if ($status == '1' && $status != '' && $_POST['num'] == $mob) {
                if ($_POST['msg'] == 'ok') {
                    $showNum = substr_replace($mob, '**', strlen($mob) - 2);



                    // echo "Il seguente numero $showNum,\nrisulta già registrato,\r\nper aggiungere/modificare i tuoi negozi preferiti puoi cliccare il seguente link:\r\n https://testing3.volantinopiu.it/whatsappBot/controller/redirection.php?n=$userNum@c.us";

                    echo "Il seguente numero $showNum,\nrisulta già registrato,\r\nper aggiungere/modificare i tuoi negozi preferiti puoi cliccare il seguente link:\r\n https://testing3.volantinopiu.it/whatsappBot/mappa.php?n=$userNum@c.us";

                    $RsLog = "INSERT INTO `mobile_log`(`id`, `numero`, `data_logo`,`action`,`msg`,ip_address) VALUES (NULL,'$userNum',NULL, 'esiste già','$userMsg', '$global_ip')";
                    $injectLogRs = mysqli_query($con, $RsLog);


                    exit;
                }
            }



            /* TODO: */
            /* When user was registrated and iconsent not NULL */
            // else if($status == '0' && $_POST['num'] == $mob && $iconsento == '1' ) {

            //        if($userMsg == 'ok' ) {
            //         $showNum = substr_replace($mob, '**', strlen($mob) - 2);

            //         $dataString = substr($db_time, 11, -6);
            //         $db_time_Int = (int)$dataString;

            //         if($db_time_int > 15) {
            //             echo "Buonasera\n,seguente numero $showNum,\nrisulta già registrato,\r\nper aggiungere/modificare i tuoi negozi preferiti puoi cliccare il seguente link:\r\n https://testing3.volantinopiu.it/auth/maps.php?n=$userNum@c.us";
            //         }else {
            //             echo "Buongiorno\n,seguente numero $showNum,\nrisulta già registrato,\r\nper aggiungere/modificare i tuoi negozi preferiti puoi cliccare il seguente link:\r\n https://testing3.volantinopiu.it/auth/maps.php?n=$userNum@c.us";
            //         }




            //         $updateMobile = "UPDATE `mobile` SET `status` = '1' WHERE `numero` ='$mob'";
            //         $exectuteQuery = mysqli_query($con,$updateMobile) or die("Not updated, happend some error...");

            //         if($exectuteQuery) {
            //             $RsLog = "INSERT INTO `mobile_log`(`id`, `numero`, `data_logo`,`action`,`msg`) VALUES (NULL,'$userNum',NULL, 'auth is true','$userMsg')";
            //             $injectLogRs = mysqli_query($con, $RsLog);    
            //         }

            //         exit;
            //     }
            // }
        }

        /* Register in mobile user */

        if ($userMsg == 'ok') {

            function validation($data)
            {
                $data = trim($_POST);
                $data = htmlspecialchars($_POST);
                return $data;
            }




            $sql = "INSERT INTO `mobile`(`id`, `numero`, `status`, `data_s`, `nome`,`cognome`,`iconsento`,`gps`) VALUES (NULL,'$userNum','1',NULL, NULL, NULL, NULL, NULL) ON DUPLICATE KEY UPDATE `status` = '1' AND `numero` = '$userNum'";
            $injectNum = mysqli_query($con, $sql);

            // $qqq = "SELECT `data_s`, `numero` FROM `mobile` WHERE `status` = '1' AND `numero` = '$userNum'";
            // $qwer = mysqli_query($con, $qqq);
            //     while($rw = mysqli_fetch_array($qwer)) {
            //         $data = $rw['data_s'];
            // $dataString = substr($data, 11, -6);
            // $dataInt = (int)$dataString;

            $todayLong = date("Y-m-d H:i:s");
            $substrTime = substr($todayLong, 10, 3);


            if ($substrTime > 14) {
                // echo "Buonasera,\nIscrizione attiva ✅\nper scegliere i tuoi supermercati Sisa preferiti, clicca il seguente link :\n https://testing3.volantinopiu.it/whatsapp/controller/redirection.php?n=$userNum@c.us";
                echo "Buonasera,\nIscrizione attiva ✅\nper scegliere i tuoi supermercati Sisa preferiti, clicca il seguente link :\n https://testing3.volantinopiu.it/whatsappBot/mappa.php?n=$userNum@c.us";
            } else if ($substrTime < 14) {
                // echo "Buongiorno,\nIscrizione attiva ✅\nper scegliere i tuoi supermercati Sisa preferiti, clicca il seguente link :\n https://testing3.volantinopiu.it/whatsapp/controller/redirection.php?n=$userNum@c.us";
                echo "Buongiorno,\nIscrizione attiva ✅\nper scegliere i tuoi supermercati Sisa preferiti, clicca il seguente link :\n https://testing3.volantinopiu.it/whatsappBot/mappa.php?n=$userNum@c.us";
            } else {
                echo "Salve,\nIscrizione attiva ✅\nper scegliere i tuoi supermercati Sisa preferiti, clicca il seguente link :\n https://testing3.volantinopiu.it/whatsappBot/mappa.php?n=$userNum@c.us";
            }
            // }


            $logQuery = "INSERT INTO `mobile_log`(`id`, `numero`, `data_logo`,`action`,`msg`, `ip_address`) VALUES (NULL,'$userNum',NULL, 'iscrizione','$userMsg', '$global_ip')";
            $injectLog = mysqli_query($con, $logQuery);
        }
        /* Change status if stop */ else if ($userMsg == 'stop') {

            $ifExsist = "SELECT `numero`, `status` FROM `mobile` WHERE `numero` ='$userNum'";
            $elseExsist = mysqli_query($con, $ifExsist);
            while ($line = mysqli_fetch_array($elseExsist)) {
                $status = $line['status'];

                switch ($status) {
                    case '1':
                        // $sql = "INSERT INTO `mobile`(`id`, `numero`, `status`, `data_s`, `nome`,`cognome`,`iconsento`,`gps`) VALUES (NULL,'$userNum','0', NULL , NULL, NULL, NULL, NULL) ON DUPLICATE KEY UPDATE `status` = '0' AND `numero` = '$userNum'";
                        // $injectStatus = mysqli_query($con,$sql);
                        $userDelete = "DELETE FROM `mobile` WHERE `numero` ='$userNum'";
                        $excDeleteUser = mysqli_query($con, $userDelete);
                        if ($excDeleteUser) {
                            $delUsrpv = "DELETE FROM `user_pv` WHERE `numero` ='$userNum'";
                            $excdelUsrpv = mysqli_query($con, $delUsrpv);
                            if ($excdelUsrpv) {
                                $delMsg = "DELETE FROM `user_send` WHERE `numero` = '$userNum'";
                                $excdelMsg = mysqli_query($con, $delMsg);
                                echo "Servizio disattivato.\nPotrai sempre attivarlo scrivendo (ok) \nti ricordiamo che è completamente gratuito";
                            }
                        }

                        break;
                    case '0':
                        echo "Gentile cliente\nNon risulta iscrizione a nessuno volantino 📝\Puoi attivare il servizio scrivendo (ok)\nti ricordiamo che è completamente gratuito";
                        break;
                }
            }


            // $sql = "INSERT INTO `mobile`(`id`, `numero`, `status`, `data_s`, `nome`,`cognome`,`iconsento`,`gps`) VALUES (NULL,'$userNum','0', NULL , NULL, NULL, NULL, NULL) ON DUPLICATE KEY UPDATE `status` = '0' AND `numero` = '$userNum'";
            // $injectStatus = mysqli_query($con,$sql);
            // if($injectStatus) {
            //     echo "Iscrizione disattivato ❌\nPotrai sempre attivare il servizio scrivendo (ok) \nti ricordiamo che il servizio è completamente gratuito";
            //     $stopQuery = "INSERT INTO `mobile_log`(`id`, `numero`, `data_logo`, `action`, `msg`,`id_address`) VALUES (NULL,'$userNum',NULL, 'disattivato', '$userMsg', '$global_ip')";
            //     $injectStatus2 = mysqli_query($con, $stopQuery);    
            // }

        }
    }


    /* Control if user baned or not  */
}
