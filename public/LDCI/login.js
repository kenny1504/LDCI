
/** Funcion para validar credenciales del usuario */
function login() {

    var user= $('#user').val(); /** Token obligatorio en ajax */
    var password=  $('#password').val();
    var _token= $('input[name=_token]').val();

               showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/inicioController/login', //llamada a la ruta
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
                            alertSuccess("El usuario esta desactivado");
                            $('#user').val("");
                            $('#password').val("");
                          }
                          else
                          {
                            alertSuccess("Bienvenido");
                            /** Detiene , para mostrar alertSucess  */
                            setTimeout(function(){
                              window.location.href='inicio';
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

