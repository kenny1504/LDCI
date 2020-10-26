var tblUsuario = null;

    $(document).ready(function () {
    showLoad(true);
    listarUsuarios();

    });

        /** Funcion que lista todos los usuarios registrados */
    function listarUsuarios() {

        var _token= $('input[name=_token]').val();

         tblUsuario = setDataTable("#tblUsuario", {
                ajax: {
                    type: 'POST',
                    url: '/usuarios/getAll', //llamada a la ruta
                    data: {
                      _token:_token
                    },
                },
                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: 3,
                        data: null,
                        orderable: false,
                        render: function (json) { 
                            $Estado =json[3];
                            if ($Estado!="Confirmar")
                            return '<div class="form-group">'
                                     +'<label class="switch">'
                                        +'<input disabled type="checkbox">'
                                        +'<span class="slider round"></span>'
                                     +'</label>'
                                   +'</div>';
                            else
                            return '<div class="form-group">'
                                        +'<label class="switch">'
                                        +'<input disabled checked type="checkbox">'
                                        +'<span class="slider round"></span>'
                                        +'</label>'
                                    +'</div>';
                            

                        }
                    },
                    {
                        targets: [ 5],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [ 7],
                        visible: false,
                        searchable: false
                    } ,
                    {
                        targets: 8,
                        data: null,
                        orderable: false,
                        render: function (json) { 
                            $Estado =json[8];
                            if ($Estado!="Activo")
                            return '<div class="form-group">'
                                     +'<label class="switch">'
                                        +'<input type="checkbox">'
                                        +'<span class="slider round"></span>'
                                     +'</label>'
                                   +'</div>';
                            else
                            return '<div class="form-group">'
                                        +'<label class="switch">'
                                        +'<input checked type="checkbox">'
                                        +'<span class="slider round"></span>'
                                        +'</label>'
                                    +'</div>';
                            

                        }
                    },
                    {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i class="btn btn-info fa fa-edit" onclick="selectUsuario(this)"></i>'
                   }
                ]
            });
        
      /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
      $('#tblUsuario').DataTable().on("draw", function(){
        showLoad(false);
       })

    }


    /** Selecciona el usuario de  y carga valores en formulario */
    function selectUsuario(datos) {


        var tr = $(datos).parents("tr")
        var data = tblUsuario.row(tr).data();
        //Capturamos valores de tabla
        usuario = {

            id_usuario: data[0],
            usuario:data[1],
            telefono:data[2],
            correo: data[4],
            tipo: data[5],
            estado: data[7]
        };
        
        //Asignamos valores a formulario
        $('#id_usuario').val(usuario.id_usuario);
        $('#txt_usuario').val(usuario.usuario);
        $('#txt_telefono').val(usuario.telefono);
        $('#txt_correo').val(usuario.correo);
        $('#selecTipo').val(usuario.tipo);

        var Estado =   document.getElementById('ckestado');

        /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
        if (usuario.estado==1)
        {
            if (Estado.checked == false)
                $('#ckestado').click();
        }
        else
        {
            if (Estado.checked == true)
                $('#ckestado').click();
        }


    }


      /** Limpia el formulario */
      function resetForm() {
        $('#ckestado').removeAttr('checked');
        $("#id_usuario,#txt_usuario,#txt_telefono,#txt_correo,#selecTipo").val("");
    }
