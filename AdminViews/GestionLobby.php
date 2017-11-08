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
      <li><a href="/<?= BASE_URL ?>Gestion" class="dropdown-link">Inicio</a></li>
      <li class="dropdown">
        <a class="dropdown-btn">Consultas</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionConsults/FilterOrdersByClient">Consultar ordenes por Cliente</a>
          <a href="/<?= BASE_URL ?>GestionConsults/FilterOrdersByDates">Consultar ordenes por Fechas</a>
          <a href="/<?= BASE_URL ?>GestionConsults/FilterOrdersBySubsidiary">Consultar ordenes por Sucursal</a>
          <a href="/<?= BASE_URL ?>GestionConsults/ConsultSoldLiters">Consultar litros vendidos</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Cervezas</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionBeer/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionBeer/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionBeer/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Envases</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionPackaging/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionPackaging/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionPackaging/Update">Modificacion</a>
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
          <a href="/<?= BASE_URL ?>GestionStaff/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionStaff/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionStaff/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Roles</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionRole/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionRole/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionRole/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Rangos Horarios</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionTimeRange/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionTimeRange/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionTimeRange/Update">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Estados</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionState/Submit">Alta</a>
          <a href="/<?= BASE_URL ?>GestionState/Delete">Baja</a>
          <a href="/<?= BASE_URL ?>GestionState/Update">Modificacion</a>
        </div>
      </li>
      <li><a href="/<?= BASE_URL ?>Login/Logout" class="dropdown-link">Cerrar sesión</a></li>
    </ul>
