<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/map.css">
    <title>Main page</title>
</head>
<body>
    <div class="container">
        <div class="maps d-none d-sm-flex hidden-xs">
            <div class="result">
                <ul id="list">
                    <?php
                    require './bin/config.php';
                        $sql = "SELECT DISTINCT `location`, `Indirizzo`, `idPuntoVendita`, `Lat`, `Lon` FROM `puntivendita`";
                        $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)) {
                                // $li .= '<li><div class="last">'.$row['location'].'</div>
                                // <input class="checkbox" type="checkbox"><div id="pv_'.$row["idPuntoVendita"].'" class="center" data-lon="'.$row['Lon'].'" data-lat="'.$row["Lat"].'">'.$row['Indirizzo'].'</div>
                                // </li>';

                                $li .= '<li><div class="last">'.$row['location'].'</div>
                                <input class="checkbox" type="checkbox" data-lon="'.$row['Lon'].'" data-lat="'.$row["Lat"].'"><div id="pv_'.$row["idPuntoVendita"].'" class="center">'.$row['Indirizzo'].'</div>
                                </li>';
                               
                               
                                }

                        
                            echo $li;
                        
                    
                
                
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
            $('.checkbox').on('click', function() {
                // $('.center').each(function() {
                //     var lat = $(this).attr('data-lat');
                //     var idA = $(this).attr('id');
                //     console.log(`Id is ${idA}`);
                // });
                var lat = $(this).attr('data-lat');
                var long = $(this).attr('data-lon');
                   alert(`Latitudine is : ${lat} - Longitudine is : ${long}`);
            });

            
           

            

           

        });

      
    // $('.center').each(function() {
    //     var arr = new Array();
    //     arr = $(this).attr('data-lat');
    //     $('.checkbox').click(function() {
    //             // var long = $('.center').data('lon');
    //             // var lat = $('.center').data('lat');
            
                
    //         });
    // });
    
</script>

    

</body>
</html>



40.7588715 lat 
14.4343121 long