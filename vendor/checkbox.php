<?php 

    
require '../bin/config.php';

$current_user_number = $_POST['number'];
                       
    $sql = "SELECT DISTINCT `location`, `Indirizzo`, `idPuntoVendita`, `Lat`, `Lon` FROM `puntivendita`";
    $query = mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($query)) {
            $id = $row['idPuntoVendita'];
            $location = $row['location'];
            $Lon =$row['Lon'];
            $Lat = $row['Lat'];
            $address = $row['Indirizzo'];

            

            /* Control if checked state true in DB */
            $checked = "SELECT `id_pv`, `numero`, `status` FROM `user_pv` WHERE `id_pv` = '$id' AND `numero` = '$current_user_number'";
            $exc = mysqli_query($con, $checked);
                $rows = mysqli_num_rows($exc);

            if($rows > 0) {
                $html.= '<li class="center"><div>'.$location.'</div></li>';
                $html.='<li><input class="checkbox" type="checkbox" checked data-lon="'.$Lon.'" data-lat="'.$Lat.'" data-id="pv_'.$id.'"><div class="last">'.$address.'</div></li>';
            } else {
                $html.= '<li class="center"><div>'.$location.'</div></li>';
                $html.='<li><input class="checkbox" type="checkbox" data-lon="'.$Lon.'" data-lat="'.$Lat.'" data-id="pv_'.$id.'"><div class="last">'.$address.'</div></li>';
            }
                
        
            }


        echo $html;




?>





