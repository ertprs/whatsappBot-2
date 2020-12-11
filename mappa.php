
<?php
session_start();

if(!isset($_SESSION['num'])) {
  header("location: public/register.php");
}

$_SESSION['status'] = '1';

 

?>


<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

	<div id="mappa"></div>
	<div class="mapsPv"> 
    <div class="btn_top"> <i class="far fa-chevron-up"></i> </div>
    <ul id="jsres"> </ul> 
  </div>

  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/4ad3211947.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

	<script src="js/custom.maps.js?v<?php echo date('mdYhisa', time()); ?>"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw5RwNMRim53BW4IgTVWu-1nHZM26730A&callback=initMap"> </script>
  

</body>
</html>

