<?php
    require '../bin/config.php';
    
    $citta = $_POST['address'];
    $pv_status = $_POST['status'];
    $status = trim($pv_status);
    $id = $_POST['id'];
    $html = '';
    $num = trim($_POST['number']);
    $_first = '39';
    $number = $_first.$num;
   


    $sql = "SELECT DISTINCT `location`, `IdPuntoVendita`, `Indirizzo` FROM `puntivendita` WHERE `location`= '$citta'";
    $query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $location = $row['location'];
        $id = $row['IdPuntoVendita'];
        $address = $row['Indirizzo'];
      
        
        $qee = "SELECT `id_pv`, `numero`, `status` FROM `user_pv` WHERE `id_pv` = '$id' AND `numero` = '$number'";
        $exc = mysqli_query($con, $qee);
        $rows = mysqli_num_rows($exc);
      

        if($rows > 0) {
            $html .= '<input type="checkbox" name="pv[]" class="check-box" id="'.$id.'"  checked value="pv_'.$id.'">  '.$address.'</input>'."<br>";
        }else {
            $html .= '<input type="checkbox" name="pv[]" class="check-box" id="'.$id.'"   value="pv_'.$id.'">'.$address.'</input>'."<br>";
        }
       
      

       
    }
   
    echo $html;
   

?>