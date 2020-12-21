<?php

require __DIR__.'/../bin/config2.php';

session_start();

$tipo = $_POST['tipo'];
$numero = $_SESSION['num'];

if ($tipo == 'pv') {
    $a_json = array();

    $address = array();
    $sql = "SELECT
                IdPuntoVendita AS id,
                Indirizzo,
                NomePunto AS ragione,
                Lat AS Latitude,
                Lon AS Longitude,
                Telefono,
                Location
              FROM puntivendita e
              WHERE 1
                AND Lat > 0
                AND active = '1'
              ORDER BY IdPuntoVendita
              LIMIT 25";
    $res = $db->query($sql);
    while ($f = $res->fetch()) {
        array_push($a_json, $f);
    }

    $pin = 'img/pin.png';

    echo json_encode(["point" => $a_json, "pin" => $pin], JSON_PRETTY_PRINT);
    flush();


} elseif ($tipo == 'distance') {
    $results = $_POST['results'];

    $n = 0;
    $toReturn = '';

    $address = array();
    $sql = "SELECT
                Indirizzo,
                Location,
                Telefono,
                Lat AS Latitude,
                Lon AS Longitude,
                IdPuntoVendita AS id,
                regione
              FROM puntivendita e

              WHERE 1
                AND Lat > 0
                AND active = '1'
              ORDER BY IdPuntoVendita
              LIMIT 25";
    $res = $db->query($sql);

    while ($f = $res->fetch()) {
        $address[] = [
          'address' => $f['Indirizzo'],
          'Latitude' => $f['Latitude'],
          'Longitude' => $f['Longitude'],
          'nome' => $f['Location'],
          'regione' => $f['regione'],
          'id' => $f['id'],
          'telefono' => $f['Telefono'],
          'text' => $results[$n]['distance']['text'],
          'value' => $results[$n]['distance']['value']
        ];

        $n++;
    }

    usort($address, function ($a, $b) {
        return $a['value'] <=> $b['value'];
    });

    $n = 0;
    foreach ($address as $key => $val) {
        /**/

        if ($n > 2) {
          break;
        }

        switch ($val['regione']) {
            case 'Negozio Italia':
                $logo = 'https://www.disisacentrosud.it/images/volantinoNG/volantino-sisa-NG.png';
                break;
            case 'Sisa Puglia':
                $logo = 'https://www.disisacentrosud.it/images/volantinoPuglia/volantino-sisa-puglia.png';
                break;
            default:
                $logo = 'https://www.disisacentrosud.it/images/volantinoCampania/volantino-sisa-campania.png';
                break;
        }

        $n++;
        
        $toReturn .= 
            '<li class="marker-link" data-markerid="'.$val['id'].'" data-lat="'.$val['Latitude'].'" data-lon="'.$val['Longitude'].'">
              
              <a href="#"><img src="'.$logo.'" alt="" title="" /></a>

              <div class="center">
                <span> ' . $val['text'] . ' </span>
                <h4>'.strtoupper($val['regione']).'</h4>
                <h5>'.strtoupper($val['nome']).'</h5>
                '.ucwords(strtolower($val['address'])).' 
              </div>
            
              <div class="last">
                <div class="check_box"><input type="checkbox" class="checkbox" data-id="pv_'.$val['id'].'"/></div>
                <span> ABBINA </span> 
              </div>

            </li>';
    }

    echo json_encode($toReturn, JSON_PRETTY_PRINT);
    flush();
}
