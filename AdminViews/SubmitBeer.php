<style> span { float: right; font-size: 12px; }
span:hover { text-decoration: underline; } </style>
    <form class="form" name="form" action="/<?= BASE_URL ?>gestionBeer/SubmitBeer" method="post" onsubmit="return Validar();" enctype="multipart/form-data">
      <table class="centrar">
        <tr>
          <td><h1>Nueva Cerveza</h1></td>
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
        <?php
        if (is_array($packagings_list) && !empty($packagings_list)) {
          foreach($packagings_list as $pack) { ?>
        <tr>
          <td><?= $pack->getDescription(); ?></td>
          <td><input type="checkbox" name="packagings[]" value="<?= $pack->getId(); ?>"></td>
        </tr>
        <?php } } else { ?>
          <tr>
            <td><label>No se encontraron Envases</label></td>
          </tr>
        <?php } ?>
        <tr>
          <td><label for="image">Imagen</label></td>
        </tr>
        <tr>
          <td colspan="2"><input type="file" name="image" value=""></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" class="submit" value="Agregar Cerveza"></td>
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
    </script>
  </body>
</html>
