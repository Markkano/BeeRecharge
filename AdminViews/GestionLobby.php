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
        <a class="dropdown-btn">Pedidos</a>
        <div class="dropdown-contenido">
          <a href="/">Consultar</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Cervezas</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionBeer/SubmitBeer">Alta</a>
          <a href="/<?= BASE_URL ?>gestionBeer/DeleteBeer">Baja</a>
          <a href="/<?= BASE_URL ?>gestionBeer/UpdateBeer">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Envases</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionPackaging/SubmitPackaging">Alta</a>
          <a href="/<?= BASE_URL ?>gestionPackaging/DeletePackaging">Baja</a>
          <a href="/<?= BASE_URL ?>gestionPackaging/UpdatePackaging">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Sucursales</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>GestionSubsidiary/SubmitSubsidiary">Alta</a>
          <a href="/<?= BASE_URL ?>GestionSubsidiary/DeleteSubsidiary">Baja</a>
          <a href="/<?= BASE_URL ?>GestionSubsidiary/UpdateSubsidiary">Modificacion</a>
          <a href="/<?= BASE_URL ?>GestionSubsidiary/ManageMarkers">Administrar Marcadores</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Staff</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionStaff/SubmitStaff">Alta</a>
          <a href="/<?= BASE_URL ?>gestionStaff/DeleteStaff">Baja</a>
          <a href="/<?= BASE_URL ?>gestionStaff/UpdateStaff">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Roles</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionRole/SubmitRole">Alta</a>
          <a href="/<?= BASE_URL ?>gestionRole/DeleteRole">Baja</a>
          <a href="/<?= BASE_URL ?>gestionRole/UpdateRole">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Rangos Horarios</a>
        <div class="dropdown-contenido">
          <a href="/<?= BASE_URL ?>gestionTimeRange/SubmitTimeRange">Alta</a>
          <a href="/<?= BASE_URL ?>gestionTimeRange/DeleteTimeRange">Baja</a>
          <a href="/<?= BASE_URL ?>gestionTimeRange/UpdateTimeRange">Modificacion</a>
        </div>
      </li>
      <li><a href="/<?= BASE_URL ?>login/logout" class="dropdown-link">Cerrar sesión</a></li>
    </ul>
