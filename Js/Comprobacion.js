function notText(valor) {
  var aux = (valor == null || valor.length == 0 || /^\s+$/.test(valor));
  //console.log(valor+": "+aux);
  return aux;
}

function notNumber(valor) {
  var aux = isNaN(valor) || valor.length == 0 ;
  //console.log(valor+": "+aux);
  return aux;
}
