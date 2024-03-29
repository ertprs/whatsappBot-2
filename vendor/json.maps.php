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
    $address_selected = array();

    $sql = "SELECT
                Indirizzo,
                Location,
                Telefono,
                Lat AS Latitude,
                Lon AS Longitude,
                IdPuntoVendita AS id,
                regione,
                id_pv
              FROM puntivendita e
                LEFT JOIN user_pv u ON e.IdPuntoVendita = u.id_pv AND u.status = 3 AND u.numero = '".$_POST['numero']."'

              WHERE 1
                AND Lat > 0
                AND active = '1'
              ORDER BY IdPuntoVendita
              LIMIT 25";
    $res = $db->query($sql);

    while ($f = $res->fetch()) {
        switch ($f['id_pv']) {
            case '':
                $address[] = [
                  'address' => $f['Indirizzo'],
                  'Latitude' => $f['Latitude'],
                  'Longitude' => $f['Longitude'],
                  'nome' => $f['Location'],
                  'regione' => $f['regione'],
                  'id' => $f['id'],
                  'telefono' => $f['Telefono'],
                  'id_pv' => $f['id_pv'],
                  'text' => $results[$n]['distance']['text'],
                  'duration' => $results[$n]['duration']['text'],
                  'value' => $results[$n]['distance']['value']
                ];
            break;
          
            default:
                $address_selected[] = [
                  'address' => $f['Indirizzo'],
                  'Latitude' => $f['Latitude'],
                  'Longitude' => $f['Longitude'],
                  'nome' => $f['Location'],
                  'regione' => $f['regione'],
                  'id' => $f['id'],
                  'telefono' => $f['Telefono'],
                  'id_pv' => $f['id_pv'],
                  'text' => $results[$n]['distance']['text'],
                  'duration' => $results[$n]['duration']['text'],
                  'value' => $results[$n]['distance']['value']
                ];
            break;
        }


        $n++;
    }

    usort($address, function ($a, $b) {
        return $a['value'] <=> $b['value'];
    });

    usort($address_selected, function ($a, $b) {
        return $a['value'] <=> $b['value'];
    });

    $result = array_merge($address_selected, $address);

    $n = 0;
    foreach ($result as $key => $val) {
        /**/

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
                <span> ' . $val['text'] . ' ' . $val['duration'] . ' </span>
                <h4>'.strtoupper($val['regione']).'</h4>
                <h5>'.strtoupper($val['nome']).'</h5>
                '.ucwords(strtolower($val['address'])).' 
              </div>
            
              <div class="last">
                <div class="checkbox '.($val['id_pv'] != '' ? 'active' : '').'" data-id="pv_'.$val['id'].'"><span>V</span></div>
                <span> ABBINA </span> 
              </div>

            </li>';
    }

    echo json_encode($toReturn, JSON_PRETTY_PRINT);
    flush();
}
