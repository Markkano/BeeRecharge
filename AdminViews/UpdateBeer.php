<style> span { float: right; font-size: 12px; }
span:hover { text-decoration: underline; } </style>
<form class="form" name="form" action="/<?= BASE_URL ?>gestionBeer/UpdateBeer" method="post" onsubmit="return Validar();" enctype="multipart/form-data">
  <table class="centrar">
    <tr>
      <td><h1>Modificar Cerveza</h1></td>
    </tr>
    <tr>
      <td colspan="2">
        <select name="id" id="beer" onchange="Actualizar()">
          <?php foreach($list as $beer) { ?>
          <option <?php if (isset($id_beer) && ($id_beer == $beer->getId())) { echo "selected"; } ?>
             value="<?=$beer->getId();?>"><?=$beer->getName();?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><label for="name">Nombre</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="text" name="name" value=""></td>
    </tr>
    <tr>
      <td><label for="description">Descripción</label></td>
    </tr>
    <tr>
      <td colspan="2"><textarea name="description" rows="8"></textarea></td>
    </tr>
    <tr>
      <td><label for="price">Precio por litro</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.1" min="0" name="price" value=""></td>
    </tr>
    <tr>
      <td><label for="ibu">Ibu</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.1" min="0" name="ibu" value=""></td>
    </tr>
    <tr>
      <td><label for="srm">Srm</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.1" min="0" name="srm" value=""></td>
    </tr>
    <tr>
      <td><label for="graduation">Graduación</label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="number" step="0.1" min="0" name="graduation" value=""></td>
    </tr>
    <tr>
      <td><label>Envases</label> <span onclick="SelTodos();">Seleccionar todos</span></td>
    </tr>
    <?php foreach($packagings_list as $pack) { ?>
    <tr>
      <td><?= $pack->getDescription(); ?></td>
      <td><input type="checkbox" name="packagings[]" value="<?= $pack->getId(); ?>"></td>
    </tr>
    <?php } ?>
    <tr>
      <td><label for="image">Imagen</label></td>
    </tr>
    <tr>
      <td colspan="2" id="img"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="file" name="image" value=""></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" class="submit" value="Guardar cambios"></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function Validar() {
  var ok = true;
  var form = document.form;

  if (notText(form.name.value)) ok = false;
  if (notText(form.description.value)) ok = false;
  if (notNumber(form.price.value)) ok = false;
  if (notNumber(form.ibu.value)) ok = false;
  if (notNumber(form.srm.value)) ok = false;
  if (notNumber(form.graduation.value)) ok = false;

  if (!ok) {
    alert("Compruebe los campos");
  }

  return ok;
}

function SelTodos() {
  inputs = document.getElementsByTagName('input');
  for (i = 0; i < inputs.length; i++) {
    if (inputs[i].type == "checkbox") {
      inputs[i].checked = true;
    }
  }
}

function DesmarcarTodos() {
  inputs = document.getElementsByTagName('input');
  for (i = 0; i < inputs.length; i++) {
    if (inputs[i].type == "checkbox") {
      inputs[i].checked = false;
    }
  }
}

function Marcar(id_packaging) {
  inputs = document.getElementsByTagName('input');
  for (i = 0; i < inputs.length; i++) {
    if (inputs[i].type == "checkbox") {
      if (inputs[i].value == id_packaging) {
        inputs[i].checked = true;
      }
    }
  }
}

function Mostrar(datos) {
  var beer = JSON.parse(datos);
  var form = document.form;
  form.name.value = beer.name;
  form.description.value = beer.description;
  form.price.value = beer.price;
  form.ibu.value = beer.ibu;
  form.srm.value = beer.srm;
  form.graduation.value = beer.graduation;

  DesmarcarTodos();
  for (var i = 0; i < beer.packagings.length; i++) {
    Marcar(beer.packagings[i].id_packaging);
  }

  if (beer.image != "" && beer.image != null) {
    var img = "/<?= BASE_URL.IMG_PATH ?>"+beer.image;
    document.getElementById('img').innerHTML = "<img src="+img+">";
  } else {
    document.getElementById('img').innerHTML = "";
  }
}

function Actualizar() {
  var beer = form.beer.options[form.beer.selectedIndex].value;
  Ajax('/<?= BASE_URL ?>Ajax/GetBeer', 'post', 'msj='+beer, function(respuestaAjax) {
    Mostrar(respuestaAjax);
  });
}

window.onload = function() {Actualizar();}
</script>
</body>
</html>
