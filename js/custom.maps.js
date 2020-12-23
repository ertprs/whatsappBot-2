/* ====================================================================================
/* google maps
/* ==================================================================================== */



function initMap() {
  //$.getScript("js/markerclusterer.js");

  var map, infoWindow, myMarker;

  var currentPos = {
    lat: 41.0820867,
    lng: 14.254187199
  };

  map = new google.maps.Map(document.getElementById('mappa'), {
    center: new google.maps.LatLng(currentPos['lat'], currentPos['lng'] - 0.5),
    zoom: 13,
    zoomControl: false,
    mapTypeControl: false,
    streetViewControl: false,
    fullscreenControl: false
  });
  infoWindow = new google.maps.InfoWindow;

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    //alert(navigator.geolocation);
    navigator.geolocation.getCurrentPosition(function(position) {
      currentPos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      var google_map_position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      var google_maps_geocoder = new google.maps.Geocoder();
      google_maps_geocoder.geocode({ 'latLng': google_map_position },
        function(results, status) {
          if (status == google.maps.GeocoderStatus.OK && results[0]) {

            myMarker = new google.maps.Marker({
              map: map,
              position: currentPos,
              animation: google.maps.Animation.DROP,
              /*icon: {
                url: 'img/favicon.png',
                scaledSize: new google.maps.Size(35, 35)
              }*/
            });
            infoWindow.setContent(results[4].formatted_address);
            infoWindow.open(currentPos, myMarker);
            map.setCenter(new google.maps.LatLng(currentPos['lat'], currentPos['lng'] - 0.5));
          }
        }
      );

      startAjax(currentPos);

    }, function() {
      startAjax(currentPos);
      handleLocationError(true, infoWindow, map);
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map);
  }

  function startAjax(currentPos) {

    $.ajax({
      type: "POST",
      url: "vendor/json.maps.php",
      data: {
        tipo : 'pv',
        numero: current_session_number,
      },
      success: function(result) {
        var result = $.parseJSON(result);
        response = result['point'];

        var marker_destinations = [];
        var markers = [];
        var image = result['pin'];

        response.forEach(function(item) {

          var marker_position = new google.maps.LatLng(item['Latitude'], item['Longitude']);

          marker = new google.maps.Marker({
            position: marker_position,
            animation: google.maps.Animation.DROP,
            id: item['id'],
            infopv: getPV(item),
            map: map,
            icon: {
              url: image,
              scaledSize: new google.maps.Size(40, 48)
            }
          });

          google.maps.event.addListener(marker, 'click', (function(marker) {
            return function() {
              infoWindow.setContent(marker.infopv);
              infoWindow.open(map, marker);
              //console.log(marker.getPosition());
            }
          })(marker));

          marker_destinations.push(marker_position);
          markers.push(marker);

        });

        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
          origins: [currentPos],
          destinations: marker_destinations,
          travelMode: 'DRIVING',
        }, callback);

        /*
        var options = {
          imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        };

        var markerCluster = new MarkerClusterer(map, markers, options);
        */

        // Trigger a click event on each marker when the corresponding marker link is clicked
        $(document).on("click", ".marker-link", function(e) {
          //var m = markers[$(this).data('markerid')];
          var lat = $(this).data('lat');
          var lon = (($(this).data('lon'))-0.1);
          map.panTo({ lat: lat, lng: lon });

          var id = $(this).data('markerid');

          markers.forEach(function(marker) {
            if(marker.id == id) {
              infoWindow.setContent(marker.infopv);
              map.setZoom(10);
              infoWindow.open(map, marker);
            }
          });
        });
      },
    });
  }
};

function getPV(item) {
  //console.log(item);
  return '<div class="popupPv"> <h5>' + item['Location'] + '</h5> <div class="indirizzo">' + item['Indirizzo'] + '</div> <button class="btn btn-sm btn-danger" >' + item['Telefono'] + '</button> </div>';
}

function callback(response, status) {
  //console.log(response);
  if (status == "OK") {
    var results = response.rows[0].elements;
    $.ajax({
      type: 'POST',
      url: "vendor/json.maps.php",
      data: {
        results: results,
        tipo: 'distance',
        numero: current_session_number,
      },
      success: function(result) {
        var result = $.parseJSON(result);

        $(".mapsPv > span").css("display", "none");
        $("#jsres").html(result);
        $("#sub_").css('display', 'block');

        $('.last').click(function() {
            var current_id = $(this).find(".checkbox").attr('data-id');

            if ($(this).find(".checkbox").hasClass("active")) {
                $(this).find(".checkbox").removeClass('active');
            } else {
                $(this).find(".checkbox").addClass('active');
            }

            $.ajax({
              url: './vendor/auth.php',
              type: 'post',
              data : {
                  id: current_id,                 
              },
              success: function() {
                  console.log("Success");
              }
          });
        });
      },
    });
  }
}

function successFunction(position) {
  lat = position.coords.latitude;
  lng = position.coords.longitude;
  codeLatLng(lat, lng)
}

function errorFunction() {
  populate(n, c, "!");
}

function initialize() {
  geocoder = new google.maps.Geocoder();
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
  }
}

function codeLatLng(lat, lng) {

  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({ 'latLng': latlng }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        var indice = 0;
        for (var j = 0; j < results.length; j++) {
          if (results[j].types[0] == 'locality') {
            indice = j;
            break;
          }
        }
        for (var i = 0; i < results[j].address_components.length; i++) {
          if (results[j].address_components[i].types[0] == "locality") {
            //this is the object you are looking for
            gcity = results[j].address_components[i];
            populate(n, c, gcity.long_name);
          }
        }
      }
    } else {
      console.log("Geocoder failed due to: " + status);
    }
  });
}

function handleLocationError(browserHasGeolocation, infoWindow, map) {
  alert("Il browser non supporta la geolocalizzazione");
  infoWindow.setPosition(map.getCenter());
  infoWindow.setContent(browserHasGeolocation ?
    'Error: The Geolocation service failed.' :
    'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}

function showError(error) {
  console.log(error);
}
