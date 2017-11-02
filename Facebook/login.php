<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login | DLL</title>
    <link rel="stylesheet" href="../Proyect/css/style.css"/>
    <script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
    <script type="text/javascript" src="../Proyect/js/Ajax.js"></script>
    <script type="text/javascript" src="../Proyect/js/facebookLogin.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  </head>
  <body>

    <form class="" action="login/facebookLogin" method="post" id="fb">
      <input type="hidden" name="usuario" id='user'>
      <fb:login-button   scope="public_profile,email"   onlogin="checkLoginState();"> </fb:login-button>
    </form>

    <form class="" action="login/procesarLogin" method="post">
      <div class="pizarra expandir-fondo" style="margin-top: 50px">
        <table class="centrar tabla-login">
          <tr>
            <td colspan="2"><img src="../Proyect/Image/beer.jpg" class="img-login"></td>
          </tr>
          <tr>
            <td><label for="username">Usuario</label></td>
            <td><input type="text" name="username" value=""></td>
          </tr>
          <tr>
            <td><label for="password">Contraseña</label></td>
            <td><input type="password" name="password" value=""></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="" value="Iniciar Sesion" class="btn-login"></td>
          </tr>
          <tr>
            <td colspan="2" class="login-register"><a href="register.php">Si no tiene cuenta, registrese</a></td>


          </tr>
        </table>
      </div>
    </form>
  </body>
</html>
