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



// set the variables that define the limits:
$min_time = 60; // seconds
$max_requests = 5;

// Make sure we have a session scope
session_start();

// Create our requests array in session scope if it does not yet exist
if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

// Create a shortcut variable for this array (just for shorter & faster code)
$requests = $_SESSION['requests'];

$countRecent = 0;
$repeat = false;
foreach($requests as $request) {
    // See if the current request was made before
    if ($request["userid"] == $id) {
        $repeat = true;
    }
    // Count (only) new requests made in last minute
    if ($request["time"] >= time() - $min_time) {
        $countRecent++;
    }
}

// Only if this is a new request...
if (!$repeat) {
    // Check if limit is crossed.
    // NB: Refused requests are not added to the log.
    if ($countRecent >= $max_requests) {
        die("Too many new ID requests in a short time");
    }   
    // Add current request to the log.
    $countRecent++;
    $requests[] = ["time" => time(), "userid" => $id];
}

// Debugging code, can be removed later:
echo  count($requests) . " unique ID requests, of which $countRecent in last minute.<br>"; 

// if execution gets here, then proceed with file content lookup as you have it.



?>