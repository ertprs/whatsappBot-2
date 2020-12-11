<?php

require __DIR__.'/../bin/config2.php';

$tipo = $_POST['tipo'];

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
                IdPuntoVendita AS id
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

    foreach ($address as $key => $val) {
        /**/

        $logo = 'img/logo.png';

        $toReturn .= '<li class="marker-link" data-markerid="'.$address[$key]['id'].'" data-lat="'.$address[$key]['Latitude'].'" data-lon="'.$address[$key]['Longitude'].'">';
          $toReturn .= '<a href="#"><img src="'.$logo.'" alt="" title="" /></a>';
          $toReturn .= '<div class="center"><h5>'.$address[$key]['nome'].'</h5>';
          $toReturn .= $address[$key]['address'].' </div>';
          $toReturn .= '<div><input type="checkbox" /></div>';
          $toReturn .= '<div class="last">'.explode(' ', $address[$key]['text'])[0].' <span> '.explode(' ', $address[$key]['text'])[1].'</span> </div>';
        $toReturn .= '</li>';
    }

    echo json_encode($toReturn, JSON_PRETTY_PRINT);
    flush();
}
