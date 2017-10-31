<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gestion | DLL</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
  <body>
    <script src="/<?= BASE_URL ?>Js/Comprobacion.js" charset="utf-8"></script>
    <script src="/<?= BASE_URL ?>Js/Ajax.js" charset="utf-8"></script>
    <style media="screen">
      .account {
        text-align: right;
        font-size: 15px;
        margin-right: 20px;
        margin-bottom: 5px;
      }
    </style>
    <div class="account">
      Usuario <?= $_SESSION['account']->getUsername(); ?> logueado como <?= $_SESSION['role']->getRolename(); ?>
    </div>
    <ul class="dropdown-contenedor">
      <li><a href="/<?= BASE_URL ?>gestion" class="dropdown-link">Inicio</a></li>
      <li class="dropdown">
        <a class="dropdown-btn">Consultas</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionConsults/FilterOrdersByClient">Consultar ordenes por Cliente</a>
          <a href="/<?= BASE_URL ?>gestionConsults/FilterOrdersByDates">Consultar ordenes por Fechas</a>
          <a href="/<?= BASE_URL ?>gestionConsults/FilterOrdersBySubsidiary">Consultar ordenes por Sucursal</a>
          <a href="/<?= BASE_URL ?>gestionConsults/ConsultSoldLiters">Consultar litros vendidos</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Cervezas</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionBeer/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>gestionBeer/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>gestionBeer/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Envases</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionPackaging/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>gestionPackaging/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>gestionPackaging/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Sucursales</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionSubsidiary/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionSubsidiary/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionSubsidiary/Update">Modificacion</a>
          <a href="/<?= BASE_URL ?>GestionSubsidiary/ManageMarkers">Administrar Marcadores</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Staff</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionStaff/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>gestionStaff/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>gestionStaff/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Roles</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionRole/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>gestionRole/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>gestionRole/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Rangos Horarios</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionTimeRange/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>gestionTimeRange/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>gestionTimeRange/Update">Modificacion</a>
        </div>
      </li>
      <li><a href="/<?= BASE_URL ?>login/logout" class="dropdown-link">Cerrar sesión</a></li>
    </ul>
