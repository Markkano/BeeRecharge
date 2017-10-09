/*
Inicializa el mapa, con la posicion y nivel de zoom indicados, e invoca
la funcion para solicitar y agregar los marcadores.
GenerarMapa debe ser invocada como callback por el script que solicita el api
de Google:
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCBbhiQn8Z1G7-uj5IVlDj1pSYKlgfT3I&callback=GenerarMapa"></script>
*/
var _center = {lat: -38.003310, lng: -57.553013};
var _zoom = 12;
var _admin = false;

/*

*/
function GenerarMapaAdmin() {
  var map = InitMapa(_center, _zoom);
  _admin = true;
  TraerMarcadores(map);
  var new_marker = new google.maps.Marker({
    map: map
  });
  map.addListener('click', function(e) {
    var lat = e.latLng.lat();
    var lon = e.latLng.lng();
    GenerarSucursal(map, lat, lon);
    new_marker.setPosition({lat:lat, lng:lon});
    ObtenerDireccion(lat, lon, document.getElementById('direccion'));
  });
}

/*
Geolocalizacion Inversa: Obtengo la direccion a partir de las coordenadas
*/
function ObtenerDireccion(lat, lon, dir) {
  //Armo un objeto LatLng con la posicion
  var latlng = {lat: lat, lng: lon};
  //Inicializo el Geocoder
  var geocoder = new google.maps.Geocoder;
  dir.value = 'Buscando...';
  /*
  Buscamos a partir de latLng, e invocamos una funcion anonima
  a la cual le pasamos el resultado y el estado de la Geolocalizacion
  */
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
      if (results[1]) {
        //Indico la direccion encontrada en el formulario
        dir.value = results[1].formatted_address;
      } else {
        //No se encontraron resultados
        dir.value = '';
      }
    } else {
      //Error
      //window.alert('Geocoder failed due to: ' + status);
    }
  });
}

/*
Genera un mapa y trae los marcadores de las sucursales
*/
function GenerarMapa() {
  var map = InitMapa(_center, _zoom);
  TraerMarcadores(map);
};

/*
Inicializa un mapa con la posicion y zoom
*/
function InitMapa(center, zoom) {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: zoom,
    center: center,
    fullscreenControl: false,
    streetViewControl: false
  });
  return map;
}

/*
Se conecta a generar.php y trae mediante AJAX la lista de sucursales en
formato XML e invoca RecorrerMarcadores pasandole el mapa.
*/
function TraerMarcadores(map) {
  Ajax('generar.php', 'get', null, function(respuestaAjax) {
    document.getElementById('respuesta').innerHTML = respuestaAjax;
    RecorrerMarcadores(map);
  });
};

/*
Recorre las etiquetas que contienen la informacion de las sucursales,
y crea un marcador por cada sucursal.
*/
function RecorrerMarcadores(map) {
  var markers = document.getElementsByTagName('marker');
  for (x = 0; x < markers.length; x++) {
    AgregarMarcador (
      parseFloat(markers[x].getAttribute('lat')), //lat
      parseFloat(markers[x].getAttribute('lon')), //lon
      map,  //map
      markers[x].getAttribute('descripcion'), //descripcion
      markers[x].getAttribute('direccion'), //direccion
      markers[x].getAttribute('telefono'), //telefono
      '#' //href
    );
  }
}

/*
Inserta un nuevo marcador en el mapa.
*/
function AgregarMarcador(lat, lon, map, descripcion, direccion, telefono, href) {
  var marker = new google.maps.Marker({
    position: {lat: lat, lng: lon},
    map: map,
    title: descripcion
  });
  AgregarInfoWindow(marker, map, descripcion, direccion, telefono, href);
};

/*
Agrega un InfoWindow con los datos de la sucursal al marcador seleccionado
*/
function AgregarInfoWindow(marker, map, descripcion, direccion, telefono, href) {
  var contentString = ''+
  '<div id="content">'+
    '<div id="siteNotice">'+
    '</div>'+
    '<h2 id="firstHeading" class="firstHeading">' + descripcion + '</h2>'+
    '<div id="bodyContent">'+
    '<p>' + direccion + ' | ' + telefono + '</p>'+
    '<input type="button" name="" value="Elegir sucursal" onclick="alert(\'' + descripcion + '\');">'+
    '</div>'+
  '</div>';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  marker.addListener('click', function() {
    infowindow.open(map, marker);
    if (_admin) {
      LlenarDatos(descripcion, direccion, telefono, marker.getPosition().lat(), marker.getPosition().lng());
    }
  });
}

/*
Completa los datos del formulario con los datos del marcador seleccionado.
*/
function LlenarDatos(descripcion, direccion, telefono, lat, lon) {
  document.getElementById('descripcion').value = descripcion;
  document.getElementById('direccion').value = direccion;
  document.getElementById('telefono').value = telefono;
  document.getElementById('lat').value = lat;
  document.getElementById('lon').value = lon;
}

/*

*/
function GenerarSucursal(map, lat, lon) {
  LlenarDatos('', '', '', lat, lon);
}
