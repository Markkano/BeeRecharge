<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login | DLL</title>
    <link rel="stylesheet" href="/<?= BASE_URL ?>Css/style.css"/>
  </head>
  <body>
    <div class="pizarra expandir-fondo">
      <table class="centrar tabla-login">

        <tr>
          <td colspan="2">
            <form class="" action="login/facebookLogin" method="post" id="fb">
              <input type="hidden" name="usuario" id='user'>
              <fb:login-button   scope="public_profile,email"  onlogin="checkLoginState();"> </fb:login-button>
            </form>
          </td>
        </tr>

        <form class="" action="/<?= BASE_URL ?>login/procesarLogin" method="post">
          <tr>
            <td colspan="2"><img src="/<?= BASE_URL.IMG_PATH ?>beer.jpg" class="img-login"></td>
          </tr>
          <tr>
            <td colspan="2">
              <?php if (isset($msj) && !strcmp($msj, "") == 0) { ?>
                <div class="alert red" style="text-align: center; width: 95%; margin-top: 0px;"><?= $msj; ?></div>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><label for="username">Usuario</label></td>
          </tr>
          <tr>
            <td><input type="text" name="username" value=""></td>
          </tr>
          <tr>
            <td><label for="password">Contraseña</label></td>
          </tr>
          <tr>
            <td><input type="password" name="password" value=""></td>
          </tr>
          <tr>
            <td colspan="2"><input style="margin-top: 20px;" type="submit" name="" value="Iniciar Sesion" class="btn-login"></td>
          </tr>
          <tr>
            <td colspan="2" class="login-register"><a href="/<?= BASE_URL ?>register">Si no tiene cuenta, registrese</a></td>
          </tr>
        </div>
      </form>
    </table>
    <script type="text/javascript" src="/<?= BASE_URL ?>Js/Ajax.js" charset="utf-8"></script>
    <script type="text/javascript" src="/<?= BASE_URL ?>Js/facebookLogin.js" charset="utf-8"></script>
    <script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </body>
</html>
