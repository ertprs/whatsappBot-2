<?php 
  session_start();
   $get = $_GET['n'];
  $nm1 = substr_replace($get, ' ',strlen($get) - 5);
  $spazio = '';
  $nm = $spazio.substr($nm1,2);
 
  $_SESSION['num'] = trim($nm);

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
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

     <section style="background-color: #8ec044;">
        <div class="container">
          <div class="row">

            <form id="registra_cluster">
              <label>Il tuo numero di telefono</label>
              <div class="input_content">
                <input type="number" id="numControll" class="form-control" readonly name="numero" value="<?php echo $_SESSION['num'] ?>" required><span>+39 | </span>
              </div>
              <label>Il nome</label>
                <input type="text" class="form-control" name="nome" id="nome">

              <label>il cognome</label>
                <input type="text" class="form-control" id="cognome" name="cognome">    
                <div class="terms">
                  <input type="checkbox" name="terms" required  id="terms">  I Agree Terms & Coditions
                </div>
                <div class="btn-box">
                  <input type="submit" value="SALVA"  class="btn btn-success w100" style="margin-top:30px; width:100%">
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
    toastr.info('Caricamento della pagina..', 'Waiting..');
    toastr.options.timeOut = 100; // 3s


    $('#numControll').on('click', function() {
      toastr.warning('Il campo selezionatio non si può cambiare', 'Attenzione..');
      toastr.options.timeOut = 2000;
    })



    $(document).on('submit', '#registra_cluster', function(e) {
      e.preventDefault();
      $.ajax({
          url: '../vendor/terms.php',
          type: 'post',
          data: $('#registra_cluster').serialize(),

          success: function(result) {
            toastr.success('Dati inseritit..', 'Successo');
            toastr.options.timeOut = 2000;
            setTimeout(() => {
              location.href= "https://testing3.volantinopiu.it/auth/login.php";              
            }, 2500);
              
          }
      })
    });           


 

  });
    

  </script>
</body>
</html>