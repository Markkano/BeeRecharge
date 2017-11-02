 var  usrNombre;
 var  usrApellido;
 var  usuario;
 var  usrCorreo;
 var  usrID;
 var usrPicture;

function User(name, surname, email, password, image)
{

  this.name = name;
  this.surname = surname;
  this.email = email;
  this.password = password;
  this.image = image;
}

  window.fbAsyncInit = function() {
    FB.init({
    appId      : '457866144607936',
    cookie     : true,
    xfbml      : true,
    version    : 'v2.10'
    });
    FB.AppEvents.logPageView();   
  };

  function checkLoginState() {
    FB.getLoginStatus(function(response) 
    { statusChangeCallback(response); });
  }

 function statusChangeCallback(response) {
    if (response.status === 'connected') 
    {
        datPer();
    } 
    else {
      alert("not connected, not logged into facebook, we don't know. Good Luck! talk with Marcos D.");
    }
  }


 function datPer(){
  FB.api(
    '/me', 'GET', {"fields":"email,first_name,last_name,id,gender,picture"},
      function(response) {
        usrNombre = response.first_name;
        usrApellido =  response.last_name;     
        usrCorreo = response.email;
        usrID = response.id;
        usrPicture = response.picture.data.url;

        var usuario = new User(usrNombre,usrApellido,usrCorreo,'',usrPicture);
        var usuarioJSON = JSON.stringify(usuario);
        $('#user').val(usuarioJSON);
        $('#fb').submit();
       
    }
  );
}

