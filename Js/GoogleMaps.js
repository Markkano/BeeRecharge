var _center = {lat: -38.003310, lng: -57.553013};
var _zoom = 12;
var _admin = false;
var map;
var marker;

function initMap(center, zoom) {
   map = new google.maps.Map(document.getElementById('map'), {
    zoom: zoom,
    center: center,
    fullscreenControl: false,
    streetViewControl: false
  });
  return map;
}

function GenerateMap() {
  var map = initMap(_center, _zoom);
  marker = new google.maps.Marker({
    map: map
  });
  map.addListener('click', function(e) {
    var lat = e.latLng.lat();
    var lon = e.latLng.lng();
    marker.setPosition({lat:lat, lng:lon});
    document.form.lat.value = lat;
    document.form.lon.value = lon;
  });
  Actualizar();
}

function Mostrar(datos) {
  var subsidiary = JSON.parse(datos);
  //console.log(subsidiary.lat + " " + subsidiary.lon);
  GenerateMarker(subsidiary);
}

function GenerateMarker(subsidiary) {
  var lat = parseFloat(subsidiary.lat); //lat
  var lon = parseFloat(subsidiary.lon); //lat
  document.form.lat.value = lat;
  document.form.lon.value = lon;
  marker.setPosition({lat:lat, lng:lon});
};
