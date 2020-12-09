<?php 


require '../bin/config.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");



if($_POST['numero'] !='' &&  $_POST['terms'] !='') {
    function validate($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    validate($_POST);

   

    $_tel = $_POST['numero'];
    $_first = '39';
    $user_tel = $_first.$_tel;
    $user_name = $_POST['nome'];
    $user_second_name = $_POST['cognome'];
    $terms = $_POST['terms']; // make default true

    $query = "UPDATE `mobile` SET `nome` = '$user_name', `cognome` = '$user_second_name', `iconsento` ='1', `gps` ='0' WHERE `numero` = '$user_tel' ";
    $execute = mysqli_query($con, $query);

    
   


}else { 
    die("Connection is failed....");
}


?>