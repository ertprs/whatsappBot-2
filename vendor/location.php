<?php

 require '../bin/config.php';

 

 $regione = $_POST['regione'];
 $html ='';
//  `IdPuntoVendita`
 $sql = "SELECT DISTINCT `location` FROM `puntivendita` WHERE `regione`= '$regione'";
 $query = mysqli_query($con, $sql);

 while ($row = mysqli_fetch_array($query)) {
     $location = $row['location'];
     $id = $row['IdPuntoVendita'];
     $address = $row['Indirizzo'];

     $html .= '<option id="_' .$id. ' ">' .$location.'</option>';
    
 }

 echo $html;




?>