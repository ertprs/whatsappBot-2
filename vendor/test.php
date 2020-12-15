<?php 

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");
require '../bin/config.php';

$num = $_POST['number'];


$query = "SELECT DISTINCT `regione` FROM `puntivendita` WHERE `IdPuntoVendita` IN(SELECT `id_pv` FROM `user_pv` WHERE `numero` = '$num')";

$excectue = mysqli_query($con, $query) or die("Failed catching data from DB..");

while($row = mysqli_fetch_array($excectue)) {
    $regione = $row['regione'];
    $regione != null ? $regione : '';

    $text = "Complimenti , notifiche attivate!.\n\nPotrai disattivare le notifiche in qualsiasi momento inviando STOP.\n\nDa ora in poi Riceverai in anteprima i volantini dei tuoi supermercati Sisa preferiti.\nTi ricordiamo che potrai in qualsiasi momento aggiungere, modificare la scelta dei punti di vendita da abbinare alle notifiche cliccando il seguente link\n\nhttps://testing3.volantinopiu.it/whatsapp/controller/redirection.php?n=$num@c.us\n\nDi seguito i volantini attivi per i punti vendita da te selezionati:\n\n$regione:\nhttps://preview1.volantinopiu.it//volantino237100-SisaCampania_Marca2020.html";
        
}


$data = array();
                $child = array();

                $child['msg'] = $text;    
                $child['numero'] = $num;

                $data[] = $child;
            
            echo json_encode($data); 



?>