
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
          <td colspan="4"><?= $beer->getName(); ?> disponible en:</td>
        </tr>
        <?php foreach ($beer->getPackagings() as $package) { ?>
          <tr>
            <td>
              <?php if ($package->getDescription() != null) { ?>
              <img src="/<?= BASE_URL.IMG_PATH ?><?= $package->getImage(); ?>" style="height: 50px;">
              <?php } ?>
            </td>
            <td><?= $package->getDescription(); ?></td>
            <td>$<?= round($package->getFactor() * ( $package->getCapacity() * $beer->getPrice()), 2); ?></td>
            <td><input type="button" name="" value="Agregar a pedido" style="cursor: pointer; cursor: hand;"
               onclick="SelCant('<?= $package->getDescription()."','".$package->getId(); ?>');"></td>
          </tr>
          <?php } ?>
      </table>
    </div>

    <!-- PopUp Confirmar Compra -->
    <div class="popup">
      <span class="popup-texto" id="popup">
        <form action="/<?= BASE_URL ?>AgregarCerveza/NewBeer" method="post">
          <table>
            <input type="hidden" id="popup_beer" name="id_beer" value="<?= $beer->getID(); ?>">
            <input type="hidden" id="popup_packaging" name="id_packaging" value="">
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


      function SelCant(envase, id_packaging) {
        console.log(envase + id_packaging);
        document.getElementById('envase').innerHTML = envase;
        document.getElementById('cant').value = 1;
        document.getElementById('popup_packaging').value = id_packaging;
        var popup = document.getElementById("popup");
        popup.classList.remove("show");
        popup.classList.toggle("show");
      }
    </script>
  </body>
</html>
