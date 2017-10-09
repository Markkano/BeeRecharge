function Ajax(destino, metodo, mensaje, callback) {
  /*
  Para realizar Ajax es impresindible una peticion asincronica.
  */
  var asincronica = true;
  /*
  Se crea la peticion y la abrimos indicando metodo y destino.
  */
  var xhr = new XMLHttpRequest();
  xhr.open(metodo, destino, asincronica);
  /*
  Se envia el header de la peticion.
  */
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  /*
  Cuando cambie el estado de la peticion ejecutamos una funcion.
  */
  xhr.onreadystatechange = function() {
      if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
        /*
        Se ejecuta la funcion de callback, por la cual utilizamos la respuesta
        en la pagina html que solicito Ajax.
        */
        callback(xhr.responseText);
      }
  }
  /*
  Se envia el mensaje al servidor.
  */
  xhr.send(mensaje);
}
