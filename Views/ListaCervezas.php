<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Lista de Cervezas | BeeRecharge</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
  <body class="fondo-madera expandir-fondo">
    <?php // TODO: Header.php ?>
    <?php include('Views/header.php'); ?>
    <div class="pizarra expandir-fondo centrar" style="width: 800px; font-family: 'Old Bookshop'; font-size: 20px; color: white;">
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
            <td><a class="link-cerveza" href="agregarCerveza/mostrar/<?= $cervezas[$i]->getId(); ?>"><?= $cervezas[$i]->getName(); ?></a></td>
            <td><?= $cervezas[$i]->getGraduation()."%"; ?></td>
            <td><?= $cervezas[$i]->getIbu(); ?></td>
            <td><?= $cervezas[$i]->getSrm(); ?></td>
            <?php $i++; }
            if (isset($cervezas[$i])) { ?>
            <td><a class="link-cerveza" href="agregarCerveza/mostrar/<?= $cervezas[$i]->getId(); ?>"><?= $cervezas[$i]->getName(); ?></a></td>
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
