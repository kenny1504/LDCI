var tblUsuario = null;
var select2=null;

    $(document).ready(function () {

        showLoad(true);
        listarUsuarios();

        var input = document.querySelector("#txt_telefono");
        select2 = window.intlTelInput(input, {
            allowDropdown: true,
            autoHideDialCode: false,
            autoPlaceholder: "off",
            dropdownContainer: document.body,
            formatOnDisplay: false,
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            hiddenInput: "full_number",
            initialCountry: "auto",
            nationalMode: false,
            placeholderNumberType: "MOBILE",
            separateDialCode: true,
            setNumber:351,
            utilsScript: "LDCI/Core/utils.js",
        });

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
                        targets: [0,2,6,8],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: 4,
                        data: null,
                        orderable: false,
                        render: function (json) {
                            $Estado =json[4];
                            if ($Estado!="Confirmar")
                            return '<div title="Estado de correo" class="form-group">'
                                     +'<label class="switch">'
                                        +'<input disabled type="checkbox">'
                                        +'<span class="slider round"></span>'
                                     +'</label>'
                                   +'</div>';
                            else
                            return '<div title="Estado de correo" class="form-group">'
                                        +'<label class="switch">'
                                        +'<input disabled checked type="checkbox">'
                                        +'<span class="slider round"></span>'
                                        +'</label>'
                                    +'</div>';
                        }
                    },
                    {
                        targets: 9,
                        data: null,
                        orderable: false,
                        render: function (json) {
                            $Estado =json[9];
                            if ($Estado!="Activo")
                            return '<div title="Cambiar estado de usuario" class="form-group">'
                                     +'<label class="switch">'
                                        +'<input class="cambiar" type="checkbox">'
                                        +'<span class="slider round"></span>'
                                     +'</label>'
                                   +'</div>';
                            else
                            return '<div title="Cambiar estado de usuario" class="form-group">'
                                        +'<label class="switch">'
                                        +'<input class="cambiar" checked type="checkbox">'
                                        +'<span class="slider round"></span>'
                                        +'</label>'
                                    +'</div>';
                        }
                    },
                    {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i class="btn btn-info fa fa-edit" title="Selecciona el registro" onclick="selectUsuario(this)"></i>'
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
        $('#btnResetUser').removeAttr('disabled');
        //Capturamos valores de tabla
        usuario = {
                id_usuario: data[0],
                usuario:data[1],
                iso:data[2],
                telefono:data[3],
                correo: data[5],
                tipo: data[6],
                estado: data[8]
        };

        //Asignamos valores a formulario
        $('#id_usuario').val(usuario.id_usuario);
        $('#txt_usuario').val(usuario.usuario);
        $('#txt_telefono').val(usuario.telefono);
        $('#txt_correo').val(usuario.correo);
        $('#txt_correo').attr("data-correo",usuario.correo);
        $('#selecTipo').val(usuario.tipo);
        select2.setCountry(usuario.iso);

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

    /** Funcion para cambiar el estado del usuario (desactivar,activar) */
    $(document).off("click", ".cambiar").on("click", ".cambiar", function () {

        showLoad(true);
        let estado; var _token= $('input[name=_token]').val();
        var dt = tblUsuario.row($(this).parents('tr')).data();

        var checkbox=$(this);
        if (checkbox[0].checked == false)
             estado=-1;
        if (checkbox[0].checked == true)
             estado=1;
        $.ajax({
            type: 'POST',
            url: '/usuarios/estado', //llamada a la ruta
            data: {
                _token:_token,
                id_usuario: dt[0],
                estado:estado
            },
            success: function(data){
                if(data==1)
                    alertSuccess("Usuario actualizado");
                else
                    alertError("hubo un error al actualizar usuario");

                showLoad(false);

            },
            error : function(err){
                showLoad(false);
                alertError(err.responseText);
            }

        });

    });

    /** Limpia el formulario */
    function resetForm() {
        $('#ckestado').removeAttr('checked');
        $("#id_usuario,#txt_usuario,#txt_telefono,#txt_correo,#selecTipo").val("");
        $('#btnResetUser').attr("disabled", "FALSE");
    }

    /** Funcion que permite actualizar o agregar un nuevo usuario */
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_usuario= $('#id_usuario').val();
        var usuario= $('#txt_usuario').val();
        var telefono= $('#txt_telefono').val();
        var correo= $('#txt_correo').val();
        var correo_old=$('#txt_correo').attr("data-correo");
        var tipo= $('#selecTipo').val();
        var iso=select2.getSelectedCountryData().iso2;

        if (id_usuario=="")
            alertSuccess("Al registrar el usuario se genera una contraseña por default 'ldci123' ");

        if (usuario!="" && telefono!="" && correo!="" && tipo!="")
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/usuarios/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_usuario:id_usuario,
                        usuario:usuario,
                        correo:correo.trim(),
                        correo_old:correo_old,
                        telefono:telefono,
                        iso:iso,
                        tipo:tipo
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                            return;
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            tblUsuario.ajax.reload();
                            resetForm();
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            });

        }
        else
            alertError("Favor completar todos los campos");

    }

    //funcion para resetear password
    function ressetpassword()
    {
        var _token = $('input[name=_token]').val();
        var id_usuario=$('#id_usuario').val();

        if(id_usuario=="")
        {
            alertError("Ningun Usuario Seleccionado");
        }
        if(id_usuario!="")
        {
            alertConfirm("Proceder a restaurar contraseña", function (e){
                showLoad(true);
                $.ajax({
                    type:'POST',
                    url: '/usuario/resetpassword',
                    data:{
                        _token:_token,
                        id_usuario:id_usuario
                    },
                    success: function(data){
                        showLoad(false);
                        if(data.error){
                            alertError(data.mensaje);
                            return;
                        }
                        else{
                            alertSuccess(data.mensaje);
                            tblUsuario.ajax.reload();
                            resetForm();
                        }
                    },
                    error: function(err){
                        alertError(err.responseText);
                        showLoad(false);
                    }
                });
            });
        }
    }
