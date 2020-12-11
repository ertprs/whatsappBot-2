<?php 

    session_start();
    /* Difine session */
   

    $get = $_GET['n'];
    $nm1 = substr_replace($get, ' ',strlen($get) - 5);
    $spazio = '';
    $nm = $spazio.substr($nm1,2);

    $_SESSION['num'] = trim($nm);
    
    if(isset($_SESSION['num']) && $_SESSION['status'] != '1') {
        $_SESSION['status'] = '0';
        header("location: ../public/register.php");
    }
    else if(isset($_SESSION['num']) && $_SESSION['status'] == '1') {
        header("location:../mappa.php");
    }



?>