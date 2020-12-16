
<?php
session_start();
require './bin/config.php';

if(!isset($_SESSION['num'])) {
  header("location: public/register.php");
}
$_first ='39';
$current_session_number = $_first.$_SESSION['num'];

/* Control if mobile status true */
$select = "SELECT `numero`, `status` FROM `mobile` WHERE `numero` = '$current_session_number' AND `status` = '1' ";
$query = mysqli_query($con, $select);
$query_rows = mysqli_num_rows($query);
  if($query_rows == 0) {
    header("location: validation/validation.html");
  }

$_SESSION['status'] = '1';



// $_SERVER['REMOTE_ADDR'];
 

?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/map.css?v<?php echo date('mdYhisa', time()); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <title>Punti vendita</title>

</head>
<body>

  <div id="header">
    <img src="img/logo.png" class="img-fluid">
  </div>

	<div id="mappa"></div>
	<div class="mapsPv"> 
   
    <div class="btn_top text-center"> <i class="far fa-chevron-up"></i> </div>
    
    <div class="btn_bottom text-center"> <i class="far fa-chevron-down"></i> </div>
    <ul id="jsres"> </ul>
    <button id="sub_" class="btn btn-success w100">Salva</button> 
  </div>

  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/4ad3211947.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <script src="js/custom.js?v<?php echo date('mdYhisa', time()); ?>"></script>
  <script src="js/custom.maps.js?v<?php echo date('mdYhisa', time()); ?>"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw5RwNMRim53BW4IgTVWu-1nHZM26730A&callback=initMap"> </script>
  <script>
    $('#sub_').on('click', function(e) {
        e.preventDefault();

        // $(".mapsPv").removeClass('in');
        // $(".mapsPv").addClass('out');
        // $("#sub_").css("display", "none");
        $('#jsres').animate({
            scrollTop: ($('.marker-link').first().offset().top)
          },700);

          var current_session_number = '<?php echo "39".$_SESSION['num'] ?>'
            $.ajax({
                url: './vendor/submit.php',
                type: 'post',
                data: {
                    number: current_session_number
                },
                success: function() {
                    toastr.success('Iscrizione attiavata...', 'Successo');
                    toastr.options.timeOut = 800;
                    
                }
            })
    });
  </script>

</body>
  

</html>

