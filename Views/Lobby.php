<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Lobby  | DLL</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
    <body class="fondo-madera expandir-fondo">
    <!-- <script src="/<?= BASE_URL ?>Js/Comprobacion.js" charset="utf-8"></script> -->
    <!-- <script src="/<?= BASE_URL ?>Js/Ajax.js" charset="utf-8"></script> -->
    <style media="screen">
      .account {
        text-align: right;

        font-size: 15px;
        margin-right: 20px;
        margin-bottom: 5px;
      }
    </style>
    <div class="account">
      Usuario <?php echo $_SESSION['account']->getUsername(); ?>
    </div>
    <ul class="dropdown-contenedor">
      <li><a href="/<?= BASE_URL ?>Lobby/" class="dropdown-link">Seleccionar Cervezas</a>
      </li>
      <li><a href="/<?= BASE_URL ?>Lobby/ElegirSucursal" class="dropdown-link">Elegir Sucursal</a>
      </li>
      <li><a href="/<?= BASE_URL ?>Lobby/SubmitOrder" class="dropdown-link">Confirmar Pedido</a>
      </li>
      <li><a href="/<?= BASE_URL ?>consultarEstado/Index" class="dropdown-link">Consultar Estado</a>
      </li>
      <li><a href="/<?= BASE_URL ?>login/logout" class="dropdown-link" align='right'>Cerrar sesión</a></li>
    </ul>

    </div>
