

function login() {

    /**  Valores  del formulario para agregar o actualizar una raza */

    var user= $('#user').val();
    var password=  $('#password').val();
    var _token= $('input[name=_token]').val();

                $.ajax({
                    type: 'POST',
                    url: '/inicioController/login', //llamada a la ruta ingresar materia
                    data: {
                      _token:_token,
                      password:password ,
                      user: user
                    },
                    success: function(data){
                      
                        if (Object.entries(data).length==0)
                        alert("Credenciales no validas");
                        else
                        window.location.href='inicio';
                }

        });

    
}