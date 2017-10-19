<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gestion | DLL</title>
    <link rel="stylesheet" href="/Css/style.css"/>
  </head>
  <body>
    <script src="/Js/Comprobacion.js" charset="utf-8"></script>
    <script src="/Js/Ajax.js" charset="utf-8"></script>
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
      <li><a href="/gestion" class="dropdown-link">Inicio</a></li>
      <li class="dropdown">
        <a class="dropdown-btn">Pedidos</a>
        <div class="dropdown-contenido">
          <a href="">Consultar</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Cervezas</a>
        <div class="dropdown-contenido">
          <a href="/gestionBeer/SubmitBeer">Alta</a>
          <a href="/gestionBeer/DeleteBeer">Baja</a>
          <a href="/gestionBeer/UpdateBeer">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Envases</a>
        <div class="dropdown-contenido">
          <a href="/gestionPackaging/SubmitPackaging">Alta</a>
          <a href="/gestionPackaging/DeletePackaging">Baja</a>
          <a href="/gestionPackaging/UpdatePackaging">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Sucursales</a>
        <div class="dropdown-contenido">
          <a href="/GestionSubsidiary/SubmitSubsidiary">Alta</a>
          <a href="/GestionSubsidiary/DeleteSubsidiary">Baja</a>
          <a href="/GestionSubsidiary/UpdateSubsidiary">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Staff</a>
        <div class="dropdown-contenido">
          <a href="/gestionStaff/SubmitStaff">Alta</a>
          <a href="/gestionStaff/DeleteStaff">Baja</a>
          <a href="/gestionStaff/UpdateStaff">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Roles</a>
        <div class="dropdown-contenido">
          <a href="/gestionRole/SubmitRole">Alta</a>
          <a href="/gestionRole/DeleteRole">Baja</a>
          <a href="/gestionRole/UpdateRole">Modificacion</a>
        </div>
      </li>
      <li class="dropdown">
        <a class="dropdown-btn">Gestion Rangos Horarios</a>
        <div class="dropdown-contenido">
          <a href="/gestionRole/SubmitRole">Alta</a>
          <a href="/gestionRole/DeleteRole">Baja</a>
          <a href="/gestionRole/UpdateRole">Modificacion</a>
        </div>
      </li>
      <li><a href="/login/logout" class="dropdown-link">Cerrar sesión</a></li>
    </ul>
