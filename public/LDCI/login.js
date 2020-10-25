
/** Funcion para validar credenciales del usuario */
function login() {

    var user= $('#user').val(); /** Token obligatorio en ajax */
    var password=  $('#password').val();
    password=Base64.encode(password);/** Encripta password */
    var _token= $('input[name=_token]').val();

               showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/login/in', //llamada a la ruta
                    data: {
                      _token:_token,
                      password:password ,
                      user: user
                    },
                    success: function(data){
                      showLoad(false);
         
                        if (data==0)
                           alertError("Credenciales no validas");
                        else
                        {
                          if (data!=1)
                          {
                            if (data==3)
                            {
                              alertSuccess("El usuario aun no ha confirmado el correo electronico");
                              $('#user').val("");
                              $('#password').val("");
                            }
                            else
                            {
                              alertSuccess("El usuario esta desactivado");
                              $('#user').val("");
                              $('#password').val("");
                            }
                          }
                          else
                          {
                            alertSuccess("Credenciales Validadas");
                            /** Detiene , para mostrar alertSucess  */
                            setTimeout(function(){
                              window.location.href='/';
                              }, 200);
                          }
                         
                        }   
                   },
                    error : function(err){
                      showLoad(false);
                        alertError(err.responseText);
                    }

        });

    
}


