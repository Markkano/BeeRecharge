<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?= $beer->getName(); ?> | DLL</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
  <body class="fondo-madera expandir-fondo">
    <!-- Volver a lista de Cervezas -->
    <div>
      <a href="/<?= BASE_URL ?>listaCervezas" class="btn-volver">Volver a lista de cervezas</a>
    </div>

    <!-- Descripcion -->
    <div class="centrar" style="width: 80%; margin-top: 40px;">
      <table style="margin: auto; width: 100%; margin-bottom: 80px;">
        <tr>
          <td>
            <div class="marco">
              <img src="/<?= BASE_URL.IMG_PATH ?><?= $beer->getImage(); ?>" style="width: inherit;height: inherit;">
            </div>
          </td>
          <td>
            <div class="descripcion pizarra expandir-fondo" style="font-family: 'Crayon Crumble';">
              <p style="margin: 10px"><?= $beer->getName(); ?> </p>
              <p style="margin: 0px"><?= $beer->getDescription(); ?></p>
            </div>
          </td>
        </tr>
      </table>

      <!-- Envases y precio -->
      <table class="tabla-envases pizarra expandir-fondo">
        <tr>
          <td colspan="3"><?= $beer->getName(); ?> disponible en:</td>
        </tr>
        <?php foreach ($envases as $package) { ?>
          <tr>
            <td><?= $package->getDescription(); ?></td>
            <td>$<?= round($package->getFactor() * ( $package->getCapacity() * $beer->getPrice()), 2); ?></td>
            <td><input type="button" name="" value="Agregar a pedido" style="cursor: pointer; cursor: hand;"
               onclick="SelCant('<?= $package->getDescription(); ?>');"></td>
          </tr>
          <?php } ?>
      </table>
    </div>

    <!-- PopUp Confirmar Compra -->
    <div class="popup">
      <span class="popup-texto" id="popup">
        <?php // TODO: action del formulario popup ?>
        <form action="#" method="post">
          <table>
            <tr>
              <td colspan="2" style="text-align: left;"><?= $beer->getName(); ?></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: left;" id="envase"></td>
            </tr>
            <tr>
              <td><label id="label" for="cantidad">Cantidad</label></td>
              <td><input id="cant" type="number" name="cantidad" min="1" value="1" style="width: 40px;"></td>
            </tr>
            <tr>
              <td><input type="button" value="Cancelar" onclick="document.getElementById('popup').classList.remove('show');"></td>
              <td><input type="submit" value="Aceptar"></td>
            </tr>
          </table>
        </form>
      </span>
    </div>

    <script type="text/javascript">
      function SelCant(envase) {
        document.getElementById('envase').innerHTML = envase;
        document.getElementById('cant').value = 1;
        var popup = document.getElementById("popup");
        popup.classList.remove("show");
        popup.classList.toggle("show");
      }
    </script>
  </body>
</html>
