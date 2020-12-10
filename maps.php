<?php
session_start();
   $current_user_number = $_GET['n'];
  /* $nm1 = substr_replace($get, ' ',strlen($get) - 5);
  $spazio = '';
  $nm = $spazio.substr($nm1,2); */
 
  $_SESSION['num'] = trim($current_user_number);
  

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/map.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>Main page</title>
</head>
<body>
    <div class="container">
        <div class="maps d-none d-sm-flex hidden-xs">
            <div class="btn-box">
                    <button class="btn btn-success btn-customize">Click</button>
            </div>
                <div class="result">
                    <ul id="list">
                        <?php
                        require './bin/config.php';

                       
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
                                        
                                  

                                    // $li .= '<li><div class="center">'.$row['location'].'</div>
                                    // <input class="checkbox" type="checkbox" data-lon="'.$row['Lon'].'" data-lat="'.$row["Lat"].'"><div id="pv_'.$row["idPuntoVendita"].'" class="last">'.$row['Indirizzo'].'</div>
                                    // </li>';
                                
                                
                                    }

                            
                                echo $html;
                            
                        
                    
                    
                    ?>
                    </ul>
                    
                </div>
            
            </div>
        </div>
        

    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous">
  </script>

    <script>
        $(document).ready(function() {
            $('.checkbox').click(function() {
               
                var lat = $(this).attr('data-lat');
                var long = $(this).attr('data-lon');
                
                var current_session_number = "<?php  echo $_SESSION['num'] ?>";
                var current_id = $(this).attr('data-id');

                if($(this).prop('checked')) { 
             
                
                    $.ajax({
                        url: './vendor/auth.php',
                        type: 'post',
                        data : {
                            id: current_id,
                            number: current_session_number
                        },
                        success: function(result) {
                            toastr.success('Modifiche salvate..', 'Successo');
                            toastr.options.timeOut = 1000;
                        }
                    });
                }
            });

            
           

            

           

        });

        
</script>

    

</body>
</html>


