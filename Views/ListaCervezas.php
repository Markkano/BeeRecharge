
    <div class="pizarra expandir-fondo centrar" style="margin-top: 30px; width: 800px; font-family: 'Old Bookshop'; font-size: 20px; color: white;">
      <div style="padding: 10px 0px 10px 30px ">
        <b style="font-size: 40px;">Lista de Cervezas:</b>
      </div>
      <div>
        <table class="tabla-cervezas">
          <tr>
            <td>Nombre</td>
            <td>Grad</td>
            <td>Ibu</td>
            <td>Srm</td>

            <td>Nombre</td>
            <td>Grad</td>
            <td>Ibu</td>
            <td>Srm</td>
          </tr>
          <?php
          $i = 0; while ($i < count($cervezas)) {
          if (isset($cervezas[$i])) { ?>
          <tr>
            <td><a class="link-cerveza" href="/<?= BASE_URL ?>Lobby/AgregarCerveza/<?= $cervezas[$i]->getId(); ?>"><?= $cervezas[$i]->getName(); ?></a></td>
            <td><?= $cervezas[$i]->getGraduation()."%"; ?></td>
            <td><?= $cervezas[$i]->getIbu(); ?></td>
            <td><?= $cervezas[$i]->getSrm(); ?></td>
            <?php $i++; }
            if (isset($cervezas[$i])) { ?>
            <td><a class="link-cerveza" href="/<?= BASE_URL ?>Lobby/AgregarCerveza/<?= $cervezas[$i]->getId(); ?>"><?= $cervezas[$i]->getName(); ?></a></td>
            <td><?= $cervezas[$i]->getGraduation()."%"; ?></td>
            <td><?= $cervezas[$i]->getIbu(); ?></td>
            <td><?= $cervezas[$i]->getSrm(); ?></td>
          </tr>
          <?php } $i++;
          }?>
        </table>
      </div>
    </div>
    <br><br><br><br>
  </body>
</html>
