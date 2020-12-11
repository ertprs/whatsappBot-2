<?php 
  session_start();
  require '../bin/config.php';

  $_SESSION['num'];
  $get = $_SESSION['num'];
  /* Generate key for report */
  $generete_key = substr($get, 7);
  $number = '39'.$_SESSION['num'];


  $select = "SELECT `numero`, `status` FROM `mobile` WHERE `numero` = '$number' AND `status` = '1' ";
    $query = mysqli_query($con, $select);
    $query_rows = mysqli_num_rows($query);
      if($query_rows == 0) {
        header("location: ../validation/validation.html");
      }

  

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <title>VolantinoPiu</title>
</head>
<body>
<div id="home" class="container-fluid">
    <div class="banner-text top">
      <div class="row text-center">
        <div class="col-sm-12">      
         <a href="#" alt="VolantinoPiu homepage" title="VolantinoPiu homepage" class="logo">
            <img src="../logo_complete.png" class="img-responsive">
          </a>   
          <!-- <img class="banner-img img-fluid right-img wow slideInDown" src="img/half_logo_right.png" alt=""> -->
        </div>
      </div>
    </div>
  </div>

     <section style="background-color: grey;">
        <div class="container">
          <div class="row">
              <div class='title'>
                  <h6>Inserisci le informazioni e salva per selezionare i tuoi supermercati SISA preferiti</h6>
                  <smail>Hai problemi con registrazione?</smail>
                  <a href="https://api.whatsapp.com/send?phone=+393294557479&text=Problemi con autorizzazione.Il codice report: F<?php echo $generete_key;?>">Clicca qua!</a>
              </div>
            <form id="registra_cluster">
              <label>Il tuo numero di telefono</label>
              <div class="input_content">
                <input type="number" id="numControll" class="form-control" readonly name="numero" value="<?php echo $_SESSION['num'] ?>" required><span>+39 | </span>
              </div>
              <label>Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" minlength="3" required>

              <label>Cognome</label>
                <input type="text" class="form-control" id="cognome" name="cognome" minlength= "3" required>    
                <div class="terms" style="padding-top: 7px;">
                  <input type="checkbox" name="terms" required  id="terms" > Autorizzo il trattamento dei miei dati personali ai sensi del Decreto Legislativo 30 giugno 2003, n. 196 “Codice in materia di protezione dei dati personali” e dell’art. 13 del GDPR (Regolamento UE 2016/679).
                </div>
                <div class="btn-box">
                  <input type="submit" value="SALVA"  class="btn btn-success w100" style="margin-top:20px; width:100%">
                </div>
            </form>
    
          </div>
        </div>
      </section>

      

  <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous">
  </script>
             

  <script>

  $(document).ready(function() {
    
    $('#numControll').on('click', function() {
      toastr.warning('Il campo selezionatio non si può cambiare', 'Attenzione..');
      toastr.options.timeOut = 2000;
    })

    let current_number = "<?php  echo $_SESSION['num'] ?>";
   

    $(document).on('submit', '#registra_cluster', function(e) {
      e.preventDefault();
     
      $.ajax({
          url: '../vendor/terms.php',
          type: 'post',
          data: $('#registra_cluster').serialize(),

          complete: function(result) {
            
            toastr.success('Dati inseritit..', 'Successo');
            toastr.options.timeOut = 2000;
              
            
            setTimeout(() => {
                location.href= `https://testing3.volantinopiu.it/whatsapp/mappa.php?`;  
            }, 2500);
              
          }
      })
    });           


 

  });
    

  </script>
</body>
</html>